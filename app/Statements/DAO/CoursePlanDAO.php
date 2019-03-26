<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 10.03.2019
 * Time: 20:40
 */

namespace App\Statements\DAO;


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

    public function storeCoursePlan(Request $request){
        $coursePlane = new CoursePlan();
        $coursePlane->course_plan_name = $request->course_plan_name;
        $coursePlane->course_plan_desc = $request->course_plan_desc;
        $coursePlane->max_controls = $request->max_controls;
        $coursePlane->max_seminars = $request->max_seminars;
        $coursePlane->max_seminars_work = $request->max_seminars_work;
        $coursePlane->max_lecrures = $request->max_lecrures;
        $coursePlane->max_exam = $request->max_exam;
        $coursePlane->save();
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
            $result_sum = $max_seminars + $max_controls + $max_seminars_work + $max_lecrures + $max_exam;

            if($result_sum > 100) {
                $validator->errors()->add('exceeded_result_summ_course','Сумма баллов за весь учебный план превышает 100');
            }
        });
        return $validator;
    }


    public function getUpdateValidate(Request $request) {
         return $this->getStoreValidate($request);
    }


    public function deleteCoursePlan($id){
        $section_plans = SectionPlan::where('id_course_plan', $id)->select('id_section_plan')->get();
        foreach ($section_plans as $section_plan) {
            LecturePlan::where('id_section_plan', $section_plan->id_section_plan)->delete();
            SeminarPlan::where('id_section_plan', $section_plan->id_section_plan)->delete();
            ControlWorkPlan::where('id_section_plan', $section_plan->id_section_plan)->delete();
        }
        SectionPlan::where('id_course_plan', $id)->delete();
        CoursePlan::where('id_course_plan', $id)->delete();
    }
}