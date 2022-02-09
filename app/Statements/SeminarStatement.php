<?php


namespace App\Statements;

use App\Statements\Plans\SectionPlan;
use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\DAO\SectionPlanDAO;
use App\Statements\Passes\SeminarPasses;
use App\Statements\Plans\SeminarPlan;
use Validator;

class SeminarStatement {
    private $course_plan_DAO;
	private $section_plan_DAO;
	
    public function __construct(CoursePlanDAO $course_plan_DAO, SectionPlanDAO $section_plan_DAO) {
        $this->course_plan_DAO = $course_plan_DAO;
		$this->section_plan_DAO = $section_plan_DAO;
    }

    public function getWorkSeminarBySection($id_course_plan, $id_user, $all_seminars) {
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });

        $result_point =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get();


        $result = collect([]);
        $all_seminars->map(function($seminar_by_section) use($result_point){
            $seminar_by_section->map(function ($seminar_u) use ($result_point){
                $seminar_u['points'] = '0';
                $result_point->map(function ($seminarWork) use ($seminar_u){
                    if ($seminarWork['id_seminar_plan'] == $seminar_u['id_seminar_plan']){
                        $seminar_u['points']  = $seminarWork['work_points'];
                    }
                });
            });

        });

        return $all_seminars;
    }

    //Вывод ведомости посящения и работы на семинарах по группе
    public function getStatementByGroup($id_group) {
        $users = User::where([['group', '=', $id_group], ['role', '=', 'Студент']])->join('groups', 'groups.group_id', '=', 'users.group')
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
        //echo $seminar_passes_sections;

        $all_id_seminar2 = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan)
            ->map(function ($section) {
                return  $section->map(function ($seminar) {
                    return ($seminar->id_seminar_plan);
                });

            });
        $all_seminars = $this->course_plan_DAO->getAllSeminarsBySections($id_course_plan);
        $sem_pres = collect([]);
        $i = 0;
        $ballsBySections = collect();
        $all_id_seminar2->map(function($section) use($user,$sem_pres){
            $sectionRes = SeminarPasses::whereIn('id_seminar_plan', $section)
                ->where('id_user', $user->id)
                ->get();
            $sem_pres->push($sectionRes);
        });
        $sp = SectionPlan::where('id_course_plan', $id_course_plan)
            ->where('is_exam', '=', 0)
            ->get()
            ->sortBy('section_num');
        $maxes = collect();
        $sp->map(function($section) use($maxes){
            $maxes->push($section['max_seminar_pass_point']);
        });
        $sem_sum = collect();
        foreach ($sem_pres as $lect){
            $sum = 0;
            $c = 0;
            foreach ($lect as $lecture){
                $sum += $lecture->presence;
                $c += 1;
            }
            $sem_sum->push($sum);
            if ($c == 0) {
                $ballsBySections->push(0);
            } else {
                $ballsBySections->push($sum / $c * $maxes[$i]);
            }
            $i += 1;
        }

        $seminarWorks = $this->getWorkSeminarBySection($id_course_plan, $user->id, $all_seminars);

        $maxesW = collect();
        $sumW_balls = collect();

        $sections = $this->section_plan_DAO->getSectionPlansByCourse($id_course_plan);

        foreach ($seminarWorks as $seminar){
            $sum = 0;
            foreach ($seminar as $semBal){
                $sum += $semBal['points'];
            }
            $sect = $this->getSectionById($sections, $seminar[0]['id_section_plan']);
            $maxesW->push($sect['max_seminar_work_point']);
            $sumW_balls->push($sum);
        }
        $ind = 0;
        foreach($sumW_balls as $sec){
            if ($sec > $maxesW[$ind]){
                $sumW_balls[$ind] = $maxesW[$ind];
            }
            $ind += 1;
        }
        $user_statement_seminar->put('ballsBySectionsPass', $ballsBySections);
        $user_statement_seminar->put('ballsBySectionsWorks', $sumW_balls);
        $user_statement_seminar->put('seminar_passes_sections', $seminar_passes_sections);
        $user_statement_seminar->put('lala1', $maxesW);
        return $user_statement_seminar;
    }

    private function getSectionById($sections, $id) {
        foreach ($sections as $section) {
            if ($section['id_section_plan'] == $id) {
                return $section;
            }
        }
        return null;
    }

    //Отметка присутствия на семинаре
    public function markPresent(Request $request){
        $id_seminar_pass = $request->input('id_seminar_pass');
        $is_presence = $request->input('is_presence');
        if ($is_presence == 'true') {
            SeminarPasses::where('id_seminar_pass', $id_seminar_pass)
                ->update(['presence' => 1]);
        } else {
            SeminarPasses::where('id_seminar_pass', $id_seminar_pass)
                ->update(['presence' => 0, 'work_points' => 0]);
        }

    }

    //Отмечаем всех на семинаре
    public function markPresentAll(Request $request){
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
                'numeric',
                'between:-100,100']
        ]);
        $validator->after(function ($validator) {
            $course_plan =  $this->course_plan_DAO
                ->getCoursePlan($validator->getData()['id_course_plan']);
			$section_plan =  $this->section_plan_DAO->getSectionPlanByCourse($validator->getData()['id_course_plan']);
            $max_seminars_work = $course_plan['max_seminars_work'];
            $all_section_plans =$this->section_plan_DAO->getSectionPlansByCourse($validator->getData()['id_course_plan']);//, $validator->getData()['id_seminar_pass']
            $sec_count =1 ;
			#$lectures_count = LecturePlan->getLecture;
			#$min_seminars_work = 0.6 * (100-$course_plan['max_exam']);
            $all_id_seminars = $this->course_plan_DAO->getAllSeminars($validator->getData()['id_course_plan'])
                ->map(function ($item) {
                    return $item->id_seminar_plan;
                });
            $id_user = SeminarPasses::where('id_seminar_pass', $validator->getData()['id_seminar_pass'])
                ->first()['id_user'];
            $current_point = $validator->getData()['class_work_point'];
            $all_points = SeminarPasses::whereIn('id_seminar_plan', $all_id_seminars)
                    ->where('id_user', $id_user)
                    ->where('id_seminar_pass', '<>', $validator->getData()['id_seminar_pass'])
                    ->sum('work_points');
            //$section_plan_num = $section_plan->section_num'];
            $section = $this->course_plan_DAO->getSectionPlanByCoursePlan($validator->getData()['id_course_plan'],$validator->getData()['section_num']);
            $max_section_balls = $section['section_plans'][$validator->getData()['section_num']-1]['max_seminar_work_point'];
            $sp = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])->get();
            //$validator->errors()->add('exceeded_max_points', 'С ' .  . ' ');
            $maxes = collect();
            $sp->map(function($section) use($maxes){
                $maxes->push($section['max_seminar_work_point']);
            });
            $different = abs($max_section_balls - $current_point);
            if ( $current_point > $max_section_balls)
                {
                    $validator->errors()->add('exceeded_max_points', 'Сумма баллов превышает Макс балл за раздел "Работа на семинарах":' . '(' . $max_section_balls . ') на ' . $different);
                }
			else{
				if ($current_point < -50)
                {
                    $validator->errors()->add('exceeded_max_points', 'Сумма баллов ниже Мин балл за раздел "Работа на семинарах":' . '(' . -50 . ') на ' . $different);
                }
            }
        });
        return $validator;
    }
}