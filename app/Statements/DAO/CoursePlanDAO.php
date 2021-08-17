<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 10.03.2019
 * Time: 20:40
 */

namespace App\Statements\DAO;


use App\Group;
use App\Statements\Plans\ControlWorkPlan;
use App\Statements\Plans\CoursePlan;
use App\Statements\Plans\LecturePlan;
use App\Statements\Plans\SectionPlan;
use App\Statements\Plans\SeminarPlan;
use Illuminate\Http\Request;
use Validator;

class CoursePlanDAO
{

    public function allCoursePlan() {
        $course_plans = CoursePlan::all();
        return  $course_plans;
    }

    public function getCoursePlan($id){
        $course_plan = CoursePlan::where('id_course_plan', $id)->first();
        return $course_plan;
    }
    public function getSectionPlanByCoursePlan($id, $section_num){
        $course_plan = CoursePlan::where('id_course_plan', $id)->first();
        return $course_plan;
    }
    public function getAllLectures($id_course_plan){
        $all_lectures = collect([]);
        $course_plan = CoursePlan::where('id_course_plan', $id_course_plan)->first();
        foreach ($course_plan->section_plans as $section_plan) {
            foreach ($section_plan->lecture_plans as $lecture_plan) {
                $all_lectures->push($lecture_plan);
            }
        }
        return $all_lectures;
    }

    public function getAllLecturesBySection($id_course_plan){
        $all_lectures = collect([]);
        $course_plan = CoursePlan::where('id_course_plan', $id_course_plan)->first();
        foreach ($course_plan->section_plans as $section_plan) {
            $section = collect([]);
            foreach ($section_plan->lecture_plans as $lecture_plan) {
                $section->push($lecture_plan);
            }
            $all_lectures->push($section);
        }
        return $all_lectures;
    }
    public function getAllSeminars($id_course_plan){
        $all_seminars = collect([]);
        $course_plan = CoursePlan::where('id_course_plan', $id_course_plan)->first();
        foreach ($course_plan->section_plans as $section_plan) {
            foreach ($section_plan->seminar_plans as $seminar_plan) {
                $all_seminars->push($seminar_plan);
            }
        }
        return $all_seminars;
    }
    public function getAllSeminarsBySections($id_course_plan){
        $all_seminars = collect([]);
        $course_plan = CoursePlan::where('id_course_plan', $id_course_plan)->first();
        foreach ($course_plan->section_plans as $section_plan) {
            $section = collect([]);
            foreach ($section_plan->seminar_plans as $seminar_plan) {
                $section->push($seminar_plan);
            }
            $all_seminars->push($section);
        }
        return $all_seminars;
    }

    public function getAllControlWorks($id_course_plan){
        $all_control_work_plans = collect([]);
        $course_plan = CoursePlan::where('id_course_plan', $id_course_plan)->first();
        foreach ($course_plan->section_plans as $section_plan) {
            foreach ($section_plan->control_work_plans as $control_work_plan) {
                $all_control_work_plans->push($control_work_plan);
            }
        }
        return $all_control_work_plans;
    }

    public function getAllExamWorks($id_course_plan){
        $all_exam_work_plans = collect([]);
        $course_plan = CoursePlan::where('id_course_plan', $id_course_plan)->first();
        foreach ($course_plan->exam_plans as $section_plan) {
            foreach ($section_plan->control_work_plans as $control_work_plan) {
                $all_exam_work_plans->push($control_work_plan);
            }
        }
        return $all_exam_work_plans;
    }

    public function storeCoursePlan(Request $request){
        $course_plan = new CoursePlan();
        $course_plan->course_plan_name = $request->course_plan_name;
        $course_plan->course_plan_desc = $request->course_plan_desc;
        //$course_plan->max_controls = $request->max_controls;
        //$course_plan->max_seminars = $request->max_seminars;
        //$course_plan->max_seminars_work = $request->max_seminars_work;
        //$course_plan->max_lecrures = $request->max_lecrures;
        $course_plan->max_semester = $request->max_semester;
        $course_plan->max_exam = $request->max_exam;
        $groups = $request->input('groups');
        $course_plan->save();
        if ($groups != null) {
         foreach ($groups as $group_id) {
             Group::where('group_id', $group_id)->update(['id_course_plan' => $course_plan->id_course_plan]);
         }
        }
        return $course_plan->id_course_plan;
    }

        public function updateCoursePlan(Request $request){
        $course_plan = CoursePlan::findOrFail($request->input('id_course_plan'));
        $course_plan->course_plan_name = $request->course_plan_name;
        $course_plan->course_plan_desc = $request->course_plan_desc;
        $course_plan->max_controls = $request->max_controls;
        $course_plan->max_seminars = $request->max_seminars;
        $course_plan->max_seminars_work = $request->max_seminars_work;
        $course_plan->max_lecrures = $request->max_lecrures;
        $course_plan->max_exam = $request->max_exam;
        $groups = $request->input('groups');
        $id_course_plan = $request->input('id_course_plan');
        Group::where('id_course_plan', $id_course_plan)->update(['id_course_plan' => null]);
        //Обнуляем ссылки на course plan в groups при удалении названий групп
        if ($groups != null) {
            foreach ($groups as $group_id) {
                Group::where('group_id', $group_id)->update(['id_course_plan' => $id_course_plan]);
            }
        }
        $course_plan->update();
    }

    public function getStoreValidate(Request $request) {
        $validator = Validator::make($request->all(), [
            'course_plan_name' => "required",
            'course_plan_desc' => 'required',
            //'max_semester' => 'required|numeric|between:0,100',
            //'max_exam' => 'required|numeric|between:0,100',
        ]);

        $validator->after(function ($validator) {
            //$max_semester = $validator->getData()['max_semester'];
            //$max_exam = $validator->getData()['max_exam'];
            //$groups = $validator->getData()['groups'];
            //$id_course_plan = $validator->getData()['id_course_plan'];
            //$result_sum = $max_semester + $max_exam;

            //if($result_sum != 100) {
            //    $validator->errors()->add('incorrect_result_summ_course','Сумма баллов (' . $result_sum . ') за весь учебный план не равна 100');
            //}
        });
        return $validator;
    }


    public function getUpdateValidate(Request $request) {
         return $this->getStoreValidate($request);
    }


    public function deleteCoursePlan($id){
        $section_plans = SectionPlan::where('id_course_plan', $id)->select('id_section_plan')->get();

        // Удаление (замена на null) из табл groups ссылки на id удаляемого учебного плана
        Group::where('id_course_plan', $id)->update(['id_course_plan' => null]);
        foreach ($section_plans as $section_plan) {
            LecturePlan::where('id_section_plan', $section_plan->id_section_plan)->delete();
            SeminarPlan::where('id_section_plan', $section_plan->id_section_plan)->delete();
            ControlWorkPlan::where('id_section_plan', $section_plan->id_section_plan)->delete();
        }
        SectionPlan::where('id_course_plan', $id)->delete();
        CoursePlan::where('id_course_plan', $id)->delete();
    }

    //Проверка баллов учебного плана для всех контрольных мероприятий
    public static function checkPointsCoursePlan($id_course_plan) {
        $validator = Validator::make(['id_course_plan' => $id_course_plan], []);
        $validator->after(function ($validator) {
            $course_plan = CoursePlan::where('id_course_plan', $validator->getData()['id_course_plan'])->first();
            $max_results = $course_plan->getMaxes();
            $max_control = $max_results['max_control'];
            $max_ball_gen = $max_results['max_ball_gen'];
            $max_seminar_pass_ball_gen = $max_results['max_seminar_pass_ball_gen'];
            $max_lecture_ball_gen = $max_results['max_lecture_ball_gen'];
            $max_exam_gen = $max_results['max_exam_gen'];
            $cur_max = $max_control + $max_ball_gen + $max_seminar_pass_ball_gen + $max_lecture_ball_gen;
            if ($cur_max != $course_plan->max_semester) {
                $validator->errors()->add('<max_controls','Сумма баллов за семестр (' . $cur_max .') не равна ' . $course_plan->max_semester);
            }
            if ($max_exam_gen != $course_plan->max_exam) {
                $validator->errors()->add('<max_controls','Сумма баллов за все экзаменационные мероприятия (' . $max_exam_gen .') не равна ' . $course_plan->max_exam);
            }
            /*
            $max_controls = $course_plan->max_controls;
            $max_exam = $course_plan->max_exam;
            $current_max_controls = 0;
            $current_max_exam = 0;
            $current_max_controls = $course_plan->section_plans
                ->sum(function ($section) {
                    return $section->control_work_plans
                        ->sum(function ($control_work) {
                        return $control_work->max_points;
                    });
                });
            if ($current_max_controls != $max_controls) {
                $validator->errors()->add('<max_controls','Сумма баллов за все контрольные мероприятия (' . $current_max_controls .') не равна ' . $max_controls);
            }
            $current_max_exam = $course_plan->exam_plans
                ->sum(function ($section) {
                    return $section->control_work_plans
                        ->sum(function ($control_work) {
                        return $control_work->max_points;
                    });
                });
            if ($current_max_exam < $max_exam) {
                $validator->errors()->add('<max_controls','Сумма баллов за все экзаменационные мероприятия (' . $current_max_exam .') меньше ' . $max_exam);
            }
            */
        });
        return $validator;
    }

    public function copyCoursePlan($id_course_plan) {
        $course_plan = $this->getCoursePlan($id_course_plan);
        $new_course_plan = $course_plan->replicate();
        $new_course_plan->course_plan_name .= '(Копия)';
        $new_course_plan->save();
        $all_section_plans = $course_plan->section_plans->merge($course_plan->exam_plans);
        foreach ($all_section_plans as $section_plan) {
            $new_section_plan = $section_plan->replicate();
            $new_section_plan->id_course_plan = $new_course_plan->id_course_plan;
            $new_section_plan->save();
            foreach ($section_plan->control_work_plans as $control_work_plan) {
                $new_control_work_plan = $control_work_plan->replicate();
                $new_control_work_plan->id_section_plan = $new_section_plan->id_section_plan;
                $new_control_work_plan->save();
            }
            foreach ($section_plan->lecture_plans as $lecture_plan) {
                $lecture_plan = $lecture_plan->replicate();
                $lecture_plan->id_section_plan = $new_section_plan->id_section_plan;
                $lecture_plan->save();
            }
            foreach ($section_plan->seminar_plans as $seminar_plan) {
                $seminar_plan = $seminar_plan->replicate();
                $seminar_plan->id_section_plan = $new_section_plan->id_section_plan;
                $seminar_plan->save();
            }
        }
        return $new_course_plan->id_course_plan;
    }

    public function existStatements($id_course_plan) {
        return SectionPlan::where('section_plans.id_course_plan', $id_course_plan)
            ->limit(1)
            ->rightJoin('lecture_plans', 'lecture_plans.id_section_plan', '=' , 'section_plans.id_section_plan')
            ->rightJoin('lecture_passes', 'lecture_passes.id_lecture_plan', '=', 'lecture_plans.id_lecture_plan')
            ->exists();
    }



}