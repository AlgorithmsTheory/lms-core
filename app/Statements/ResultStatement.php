<?php


namespace App\Statements;
use App\Statements\Passes\LecturePasses;
use App\Statements\Passes\SeminarPasses;
use App\Testing\Test;
use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\Passes\ControlWorkPasses;
use Illuminate\Support\Collection;
use Validator;

class ResultStatement {
    private $course_plan_DAO;

    public function __construct(CoursePlanDAO $course_plan_DAO) {
        $this->course_plan_DAO = $course_plan_DAO;
    }

    //Вывод итоговой ведомости  по группе
    public function getStatementByGroup($id_group) {
        $users = User::where([['group', '=', $id_group], ['role', '=', 'Студент']])->join('groups', 'groups.group_id', '=', 'users.group')
            ->orderBy('users.last_name', 'asc')->distinct()->get();
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $statement_result = collect([]);
        foreach($users as $user) {
            $statement_result->push($this->getStatementByUser($id_course_plan, $user));
        }
        return $statement_result;
    }

    //Вывод ведомости по id_user
    public function getStatementByUser($id_course_plan, $user) {
        $all_works = $this->getAllWorksUser($id_course_plan, $user->id);
        $control_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 0;
        });
        $exam_works = $all_works->filter(function ($value, $key) {
            return $value->is_exam == 1;
        });
        $control_work_groupBy_sections = $this->getControlWorksGroupBySec($control_works);
        $exam_work_groupBy_sections = $this->getExamWorksGroupBySection($exam_works);
        $result_control_work_sections = $this->getResultControlWorkSections($control_work_groupBy_sections, $user->id);
        $result_exam_work_sections = $this->getResultExamWorkSections($exam_work_groupBy_sections, $user->id);
        $sum_result_section_control_work = $result_control_work_sections->sum();
        $sum_result_section_exam_work = $result_exam_work_sections->sum();
        $result_lecture = $this->getResultLecture($id_course_plan, $user->id);
        $result_seminar = $this->getResultSeminar($id_course_plan, $user->id);
        $result_work_seminar = $this->getResultWorkSeminar($id_course_plan, $user->id);
        $sum_result = $sum_result_section_exam_work + $sum_result_section_control_work + $result_lecture
            + $result_seminar + $result_work_seminar;
        $markRus = Test::calcMarkRus(100, $sum_result);
        $markBologna = Test::calcMarkBologna(100, $sum_result);

        $user_statement_result = collect([]);
        $user_statement_result->put('user',  $user);
        $user_statement_result->put('control_work_groupBy_sections', $control_work_groupBy_sections);
        $user_statement_result->put('result_control_work_sections', $result_control_work_sections);
        $user_statement_result->put('sum_result_section_control_work', $sum_result_section_control_work);
        $user_statement_result->put('exam_work_groupBy_sections', $exam_work_groupBy_sections);
        $user_statement_result->put('result_exam_work_sections', $result_exam_work_sections);
        $user_statement_result->put('sum_result_section_exam_work', $sum_result_section_exam_work);
        $user_statement_result->put('result_lecture', $result_lecture);
        $user_statement_result->put('result_seminar', $result_seminar);
        $user_statement_result->put('result_work_seminar', $result_work_seminar);
        $user_statement_result->put('sum_result', $sum_result);
        $user_statement_result->put('markRus', $markRus);
        $user_statement_result->put('markBologna', $markBologna);
        return $user_statement_result;
    }

    public function getSumResultSectionControlWork($id_course_plan,$id_user) {
        $all_works = $this->getAllWorksUser($id_course_plan, $id_user);
        $control_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 0;
        });
        $control_work_groupBy_sections = $this->getControlWorksGroupBySec($control_works);
        $result_control_work_sections = $this->getResultControlWorkSections($control_work_groupBy_sections, $id_user);
        return $result_control_work_sections->sum();
    }

    public function getSumResultSectionExamWork($id_course_plan, $id_user) {
        $all_works = $this->getAllWorksUser($id_course_plan, $id_user);
        $exam_works =$all_works->filter(function ($value, $key)  {
            return $value->is_exam == 1;
        });
        $exam_work_groupBy_sections = $this->getExamWorksGroupBySection($exam_works);
        $result_exam_work_sections = $this->getResultExamWorkSections($exam_work_groupBy_sections, $id_user);
        return $result_exam_work_sections->sum();
    }

    public function getResultExamWorkSections(Collection $exam_work_groupBy_sections, $id_user) {
        return $exam_work_groupBy_sections->map( function($value, $key) use($id_user) {
            return $this->getResultSectionById($key, $id_user);
        });
    }

    public function getResultSectionById($id_section, $id_user) {
        return ControlWorkPasses::where('id_user', $id_user)
            ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', '=' ,'control_work_passes.id_control_work_plan')
            ->leftJoin('section_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
            ->where('section_plans.id_section_plan', '=', $id_section)
            ->get(['control_work_passes.points'])
            ->sum(function ($item) {
                return $item->points;
            });
    }

    public function getResultControlWorkSections(Collection $control_work_groupBy_sections, $id_user) {
        return $control_work_groupBy_sections->map( function($value, $key) use($id_user) {
            return $this->getResultSectionByNumber($key, $id_user);
        });
    }

    public function getResultSectionByNumber($num_section, $id_user) {
       return ControlWorkPasses::where('id_user', $id_user)
           ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', '=' ,'control_work_passes.id_control_work_plan')
           ->leftJoin('section_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
           ->where('section_plans.section_num', '=', $num_section)
           ->get(['control_work_passes.points'])
           ->sum(function ($item) {
               return $item->points;
           });
    }

    public function getExamWorksGroupBySection(Collection $exam_works) {
        $exam_work_groupBy_sections = $exam_works
            ->groupBy('id_section_plan')
            ->sortBy(function ($value, $key) {
                return $key;//значение ключа = id раздела (Экзамена/Зачёта)
            })
            ->map(function ($item) {
                return $item->sortBy('id_control_work_plan');
            });
        return $exam_work_groupBy_sections;
    }

    public function getControlWorksGroupBySec(Collection $control_works) {
        $control_work_groupBy_sections = $control_works
            ->groupBy('section_num')
            ->sortBy(function ($value, $key) {
                return $key;//значение ключа = номер раздела
            })
            ->map(function ($item) {
                return $item->sortBy('id_control_work_plan');
            });
        return $control_work_groupBy_sections;
    }

    public function getAllWorksUser($id_course_plan, $id_user) {
        $all_id_control_work = $this->course_plan_DAO->getAllControlWorks($id_course_plan)
            ->map(function ($item) {
                return $item->id_control_work_plan;
            });
        $all_id_exam_work = $this->course_plan_DAO->getAllExamWorks($id_course_plan)
            ->map(function ($item) {
                return $item->id_control_work_plan;
            });
        $all_id_works = $all_id_control_work->merge($all_id_exam_work);
        $all_works = ControlWorkPasses::where('control_work_passes.id_user',$id_user)
            ->whereIn('control_work_passes.id_control_work_plan',$all_id_works)
            ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', 'control_work_passes.id_control_work_plan')
            ->leftJoin('section_plans', 'section_plans.id_section_plan', 'control_work_plans.id_section_plan')
            ->get(['section_plans.id_section_plan'
                , 'section_plans.section_num'
                , 'section_plans.is_exam'
                , 'control_work_plans.id_control_work_plan'
                , 'control_work_plans.max_points'
                , 'control_work_plans.control_work_plan_name'
                , 'control_work_passes.id_control_work_pass'
                , 'control_work_passes.presence'
                , 'control_work_passes.points'
                , 'control_work_passes.id_user']);
        return $all_works;
    }

    public function getResultWorkSeminar($id_course_plan, $id_user) {
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });
        $result_point =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get()
            ->sum(function ($item) {
                return $item->work_points;
            });
        return $result_point;
    }

    public function getResultSeminar($id_course_plan, $id_user) {
        $max_seminars =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan)
            ->max_seminars;
        $all_id_seminar = $this->course_plan_DAO->getAllSeminars($id_course_plan)
            ->map(function ($item) {
                return $item->id_seminar_plan;
            });
        $count_seminar = $all_id_seminar->count();
        $temp_arr = ['max_seminars' => $max_seminars, 'count_seminar' => $count_seminar];
        $result =  SeminarPasses::whereIn('id_seminar_plan', $all_id_seminar)
            ->where('id_user', $id_user)
            ->get()
            ->sum(function ($item) use ($temp_arr){
                return $item->presence * $temp_arr['max_seminars'] / $temp_arr['count_seminar'];
            });
        return $result;
    }

    public function getResultLecture($id_course_plan, $id_user) {
        $max_lecrures =  $this->course_plan_DAO
            ->getCoursePlan($id_course_plan)
            ->max_lecrures;
        $all_id_lecture = $this->course_plan_DAO->getAllLectures($id_course_plan)
            ->map(function ($item) {
                return $item->id_lecture_plan;
            });
        $count_lecture = $all_id_lecture->count();
        $temp_arr = ['max_lecrures' => $max_lecrures, 'count_lecture' => $count_lecture];
        $result =  LecturePasses::whereIn('id_lecture_plan', $all_id_lecture)
            ->where('id_user', $id_user)
            ->get()
            ->sum(function ($item) use ($temp_arr){
                return $item->presence * $temp_arr['max_lecrures'] / $temp_arr['count_lecture'];
            });
        return $result;
    }

    //Отметка присутствия на контр меропр
    public function markPresent(Request $request){
        $id_control_work_pass = $request->input('id_control_work_pass');
        $is_presence = $request->input('is_presence');
        if ($is_presence == 'true') {
            ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
                ->update(['presence' => 1]);
        } else {
            ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
                ->update(['presence' => 0]);
        }

    }

    public function resultChange(Request $request){
        $id_control_work_pass = $request->input('id_control_work_pass');
        $control_work_points = $request->input('control_work_points');
        ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
            ->update(['points' => $control_work_points]);
    }

    public function getResultChangeValidate(Request $request) {
        $validator = Validator::make($request->toArray(), [
            'control_work_points' => ['required',
                'numeric',
                'between:0,100']
        ]);
        $validator->after(function ($validator) {
            $current_point = $validator->getData()['control_work_points'];
            $id_control_work_pass = $validator->getData()['id_control_work_pass'];
            $max_points = ControlWorkPasses::where('id_control_work_pass', $id_control_work_pass)
                ->leftJoin('control_work_plans', 'control_work_plans.id_control_work_plan', '=',
                    'control_work_passes.id_control_work_plan')
                ->first()->max_points;
            $different = abs($current_point - $max_points);
            if($current_point > $max_points) {
                $validator->errors()->add('exceeded_max_points_control_work',
                    'Сумма баллов превышает Макс балл за контрольное мероприятие (' . $max_points . ') на ' . $different);
            }

        });
        return $validator;
    }

    public function markPresentAll(Request $request) {
        $id_control_work_plan = $request->input('id_control_work_plan');
        $id_group = $request->input('id_group');
        $users_group = User::where('group', '=', $id_group)->get()
            ->map(function ($item) {
                return $item->id;
            });
        ControlWorkPasses::whereIn('id_user', $users_group)
            ->where('id_control_work_plan', '=', $id_control_work_plan)
            ->update(['presence' => 1]);
    }

}