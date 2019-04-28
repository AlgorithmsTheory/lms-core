<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.04.2019
 * Time: 18:39
 */

namespace App\Statements;
use App\Statements\DAO\CoursePlanDAO;
use Illuminate\Http\Request;
use App\Statements\Passes\LecturePasses;
use App\User;
use App\Group;

class LectureStatementManage
{

    private $course_plan_DAO;

    public function __construct(CoursePlanDAO $course_plan_DAO)
    {
        $this->course_plan_DAO = $course_plan_DAO;
    }

    //Вывод ведомости посящения лекций студентом по группе
    public function getStatementByGroup($id_group) {
        $users = User::where('group', $id_group)->join('groups', 'groups.group_id', '=', 'users.group')
            ->orderBy('users.last_name', 'asc')->distinct()->get();
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $statement_lecture = collect([]);
        foreach($users as $user) {
            $statement_lecture->push($this->getStatementByUser($id_course_plan ,$user));
        }
        return $statement_lecture;
    }

    //Вывод ведомости посящения лекций студентом по группе
    public function getStatementByUser($id_course_plan ,$user) {
        $all_id_lectures = $this->course_plan_DAO->getAllLectures($id_course_plan)
            ->map(function ($item) {
                return $item->id_lecture_plan;
            });
        $user_statement_lecture = collect([]);
        $user_statement_lecture->put('user',  $user);
        $lecture_passes = LecturePasses::whereIn('lecture_passes.id_lecture_plan',$all_id_lectures)
            ->where('id_user', '=', $user->id)
            ->leftJoin('lecture_plans', 'lecture_plans.id_lecture_plan', 'lecture_passes.id_lecture_plan')
            ->leftJoin('section_plans', 'section_plans.id_section_plan', 'lecture_plans.id_section_plan')
            ->where('is_exam', '=', 0)
            ->get(['lecture_plans.id_lecture_plan', 'lecture_passes.presence', 'lecture_plans.lecture_plan_num'
                , 'section_plans.section_num'])
            ->groupBy('section_num')
            ->sortBy(function ($value, $key) {
                return $key; //ключ = номер раздела
            })
            ->map(function ($item) {
                return $item->sortBy('lecture_plan_num');
            });
        $user_statement_lecture->put('lecture_passes', $lecture_passes);
        return $user_statement_lecture;
    }

    //Отметка присутствия на лекции
    public function lectureWas(Request $request){
        $id_user = $request->input('id_user');
        $id_lecture_plan = $request->input('id_lecture_plan');
        LecturePasses::where('id_user', $id_user)
                ->where('id_lecture_plan', $id_lecture_plan)->update(['presence' => 1]);
    }

    //Отметка отсутствия на лекции
    public function lectureWasNot(Request $request){
        $id_user = $request->input('id_user');
        $id_lecture_plan = $request->input('id_lecture_plan');
        LecturePasses::where('id_user', $id_user)
            ->where('id_lecture_plan', $id_lecture_plan)->update(['presence' => 0]);
    }

    //Отмечаем всех на лекции
    public function lectureWasAll(Request $request){
        $id_lecture_plan = $request->input('id_lecture_plan');
        $id_group = $request->input('id_group');
        $users_group = User::where('group', '=', $id_group)->get()
            ->map(function ($item) {
                return $item->id;
            });
        LecturePasses::whereIn('lecture_passes.id_user', $users_group)
            ->where('id_lecture_plan', '=', $id_lecture_plan)
            ->update(['presence' => 1]);
    }
}