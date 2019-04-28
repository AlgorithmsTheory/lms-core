<?php


namespace App\Statements;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\Passes\SeminarPasses;
use Validator;

class SeminarStatementManage
{
    private $course_plan_DAO;

    public function __construct(CoursePlanDAO $course_plan_DAO)
    {
        $this->course_plan_DAO = $course_plan_DAO;
    }

    //Вывод ведомости посящения и работы на семинарах по группе
    public function getStatementByGroup($id_group) {
        $users = User::where('group', $id_group)->join('groups', 'groups.group_id', '=', 'users.group')
            ->orderBy('users.last_name', 'asc')->distinct()->get();
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;

        $statement_seminar = collect([]);
        foreach($users as $user) {
            $statement_seminar->push($this->getStatementByUser($id_course_plan, $user));
        }
        return $statement_seminar;
    }

    //Ведомость по user
    public function getStatementByUser($id_course_plan, $user) {
        $all_id_seminars = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });
        $user_statement_seminar = collect([]);
        $user_statement_seminar->put('user',  $user);
        $seminar_passes_sections = SeminarPasses::whereIn('seminar_passes.id_seminar_plan',$all_id_seminars)
            ->where('id_user', '=', $user->id)
            ->leftJoin('seminar_plans', 'seminar_plans.id_seminar_plan', 'seminar_passes.id_seminar_plan')
            ->leftJoin('section_plans', 'section_plans.id_section_plan', 'seminar_plans.id_section_plan')
            ->where('is_exam', '=', 0)
            ->get(['seminar_plans.id_seminar_plan', 'seminar_plans.seminar_plan_num', 'seminar_passes.presence'
                , 'seminar_passes.work_points', 'section_plans.section_num', 'seminar_passes.id_seminar_pass'])
            ->groupBy('section_num')
            ->sortBy(function ($value, $key) {
                return $key;
            })
            ->map(function ($item) {
                return $item->sortBy('seminar_plan_num');
            });
        $user_statement_seminar->put('seminar_passes_sections', $seminar_passes_sections);
        return $user_statement_seminar;
    }

    //Отметка присутствия на семинаре
    public function seminarWas(Request $request){
        $id_seminar_pass = $request->input('id_seminar_pass');
        SeminarPasses::where('id_seminar_pass', $id_seminar_pass)
            ->update(['presence' => 1]);
    }

    //Отметка отсутствия на семинаре
    public function seminarWasNot(Request $request){
        $id_seminar_pass = $request->input('id_seminar_pass');
        SeminarPasses::where('id_seminar_pass', $id_seminar_pass)
            ->update(['presence' => 0, 'work_points' => 0]);
    }

    //Отмечаем всех на семинаре
    public function seminarWasAll(Request $request){
        $id_seminar_plan = $request->input('id_seminar_plan');
        $id_group = $request->input('id_group');
        $users_group = User::where('group', '=', $id_group)->get()
            ->map(function ($item) {
                return $item->id;
            });
        SeminarPasses::whereIn('seminar_passes.id_user', $users_group)
            ->where('id_seminar_plan', '=', $id_seminar_plan)
            ->update(['presence' => 1]);
    }

    public function classworkChange(Request $request){
        $id_seminar_pass = $request->input('id_seminar_pass');
        $class_work_point = $request->input('class_work_point');
        SeminarPasses::where('id_seminar_pass', $id_seminar_pass)
            ->update(['work_points' => $class_work_point]);
    }

    public function getClassworkChangeValidate(Request $request) {
        $validator = Validator::make($request->toArray(), [
            'class_work_point' => ['required',
                'integer',
                'between:0,100']
        ]);
        $validator->after(function ($validator) {
            $course_plan =  $this->course_plan_DAO
                ->getCoursePlan($validator->getData()['id_course_plan']);
            $max_seminars_work = $course_plan->max_seminars_work;
            $all_id_seminars = $this->course_plan_DAO->getAllSeminars($validator->getData()['id_course_plan'])
                ->map(function ($item) {
                    return $item->id_seminar_plan;
                });
            $id_user = SeminarPasses::where('id_seminar_pass', $validator->getData()['id_seminar_pass'])
                ->first()
                ->id_user;
            $current_point = $validator->getData()['class_work_point'];
            $all_points = SeminarPasses::whereIn('id_seminar_plan', $all_id_seminars)
                    ->where('id_user', $id_user)
                    ->where('id_seminar_pass', '<>', $validator->getData()['id_seminar_pass'])
                    ->sum('work_points');
            $different = abs($max_seminars_work -  $all_points - $current_point);
            if ($all_points + $current_point > $max_seminars_work) {
                $validator->errors()->add('exceeded_max_points', 'Сумма баллов превышает Макс балл за раздел "Работа на семинарах":' . '(' . $max_seminars_work . ') на ' . $different);
            }
        });
        return $validator;
    }
}