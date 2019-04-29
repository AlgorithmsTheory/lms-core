<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 10.03.2019
 * Time: 20:40
 */

namespace App\Statements\DAO;


use App\Group;
use App\Statements\ControlWorkPlan;
use App\Statements\CoursePlan;
use App\Statements\LecturePlan;
use App\Statements\SectionPlan;
use App\Statements\SeminarPlan;
use Illuminate\Http\Request;
use Validator;

class CoursePlanDAO
{

    public function allCoursePlan() {
        $coursePlans = CoursePlan::all();
        return  $coursePlans;
    }

    public function getCoursePlan($id){
        $coursePlan = CoursePlan::where('id_course_plan', $id)->first();
        return $coursePlan;
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
        $coursePlane = new CoursePlan();
        $coursePlane->course_plan_name = $request->course_plan_name;
        $coursePlane->course_plan_desc = $request->course_plan_desc;
        $coursePlane->max_controls = $request->max_controls;
        $coursePlane->max_seminars = $request->max_seminars;
        $coursePlane->max_seminars_work = $request->max_seminars_work;
        $coursePlane->max_lecrures = $request->max_lecrures;
        $coursePlane->max_exam = $request->max_exam;
        $groups = strtoupper($request->input('groups'));
        $coursePlane->save();
        if ($groups != null) {
            $array_groups = $this->parseStringGroups($groups);
            foreach ($array_groups as $group) {
                Group::where('group_name', $group)->update(['id_course_plan' => $coursePlane->id_course_plan]);
            }
        }
        return $coursePlane->id_course_plan;
    }

        public function updateCoursePlan(Request $request){
        $coursePlane = CoursePlan::findOrFail($request->input('id_course_plan'));
        $coursePlane->course_plan_name = $request->course_plan_name;
        $coursePlane->course_plan_desc = $request->course_plan_desc;
        $coursePlane->max_controls = $request->max_controls;
        $coursePlane->max_seminars = $request->max_seminars;
        $coursePlane->max_seminars_work = $request->max_seminars_work;
        $coursePlane->max_lecrures = $request->max_lecrures;
        $coursePlane->max_exam = $request->max_exam;
        $groups = strtoupper($request->input('groups'));
        $id_course_plan = $request->input('id_course_plan');
        Group::where('id_course_plan', $id_course_plan)->update(['id_course_plan' => null]);
        //Обнуляем ссылки на course plan в groups при удалении названий групп
        if ($groups != null) {
            $array_groups = $this->parseStringGroups($groups);
            foreach ($array_groups as $group) {
                Group::where('group_name', $group)->update(['id_course_plan' => $id_course_plan]);
            }
        }
        $coursePlane->update();
    }

    public function getStoreValidate(Request $request) {
        $validator = Validator::make($request->all(), [
            'course_plan_name' => "required",
            'course_plan_desc' => 'required',
            'max_controls' => 'required|integer|between:0,100',
            'max_seminars' => 'required|integer|between:0,100',
            'max_seminars_work' => 'required|integer|between:0,100',
            'max_lecrures' => 'required|integer|between:0,100',
            'max_exam' => 'required|integer|between:0,100',
        ]);

        $validator->after(function ($validator) {
            $max_controls = $validator->getData()['max_controls'];
            $max_seminars = $validator->getData()['max_seminars'];
            $max_seminars_work = $validator->getData()['max_seminars_work'];
            $max_lecrures = $validator->getData()['max_lecrures'];
            $max_exam = $validator->getData()['max_exam'];
            $groups = $validator->getData()['groups'];
            $id_course_plan = $validator->getData()['id_course_plan'];
            $result_sum = $max_seminars + $max_controls + $max_seminars_work + $max_lecrures + $max_exam;

            if($result_sum != 100) {
                $validator->errors()->add('incorrect_result_summ_course','Сумма баллов (' . $result_sum . ') за весь учебный план не равна 100');
            }

            if($groups != null) {
                $array_groups = $this->parseStringGroups($groups);
                if ($array_groups != false) {
                    foreach ($array_groups as $group) {
                        $group_find = Group::where('group_name', strtoupper($group))
                            ->where('id_course_plan', '<>', '')
                            ->where('id_course_plan', '<>', $id_course_plan)->first();

                        if (!$group_find) {
                            $group_find = Group::where('group_name', strtoupper($group))
                                ->where('archived', 0)->first();
                            if (!$group_find) {
                                $validator->errors()->add('false_group' . $group,'Группа ' . $group . ' либо не существует либо архивирована');
                            }
                        } else {
                            $validator->errors()->add('is_equal' . $group,'Группа ' . $group . ' уже назначена на другой учебный план');
                        }
                    }
                } else {
                    $validator->errors()->add('false_pattern_groups','Введите группы через пробел');
                }
            }

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

    public function parseStringGroups($string_groups) {
        return preg_split("/[\s]+/", trim($string_groups));
    }

    //Проверка баллов учебного плана для всех контрольных мероприятий
    public static function checkPointsCoursePlan($id_course_plan) {
        $validator = Validator::make(['id_course_plan' => $id_course_plan], []);
        $validator->after(function ($validator) {
        $course_plan = CoursePlan::where('id_course_plan', $validator->getData()['id_course_plan'])->first();
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
        if ($current_max_controls < $max_controls) {
            $different = $max_controls - $current_max_controls;
            $validator->errors()->add('<max_controls','Сумма баллов за все контрольные мероприятия (' . $current_max_controls .') меньше ' . $max_controls . ' на ' . $different);
        }
        $current_max_exam = $course_plan->exam_plans
            ->sum(function ($section) {
                return $section->control_work_plans
                    ->sum(function ($control_work) {
                    return $control_work->max_points;
                });
            });
        if ($current_max_exam < $max_exam) {
                $different = $max_exam - $current_max_exam;
                $validator->errors()->add('<max_controls','Сумма баллов за все экзаменационные мероприятия (' . $current_max_exam .') меньше ' . $max_exam . ' на ' . $different);
            }
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

}