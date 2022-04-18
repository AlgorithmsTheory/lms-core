<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 14.03.2019
 * Time: 18:26
 */

namespace App\Statements\DAO;


use App\Statements\Plans\ControlWorkPlan;
use App\Statements\Plans\CoursePlan;
use App\Statements\Plans\LecturePlan;
use App\Statements\Plans\SectionPlan;
use App\Statements\Plans\SeminarPlan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
class SectionPlanDAO {

    public function getSectionPlan($id){
        return SectionPlan::where('id_section_plan', $id)->first();
    }

    public function getSectionPlanByCourse($id){
        return SectionPlan::where('id_course_plan', $id)->first();
    }

    public function getSectionPlansByCourse($id){
        return SectionPlan::where('id_course_plan', $id)->get();
    }

    public function storeSectionPlan(Request $request){
        $section_plan = new SectionPlan();
        $section_plan->section_plan_name = $request->section_plan_name;
        $section_plan->section_plan_desc = $request->section_plan_desc;
        $section_plan->id_course_plan = $request->id_course_plan;
        $section_plan->section_num = $request->is_exam == 0 ? $request->section_num : null;
        $section_plan->is_exam = $request->is_exam;
        $section_plan->max_seminar_work_point = $request->section_plan_max_ball;
        $section_plan->max_seminar_pass_point = $request->section_plan_max_seminar_pass_ball;
        $section_plan->max_lecture_pass_point = $request->section_plan_max_lecture_ball;
        $section_plan->save();
        return $section_plan->id_section_plan;
    }

    public function updateSectionPlan(Request $request){
        $section_plan = $this->getSectionPlan($request->id_section_plan);
        $section_plan->section_plan_name = $request->section_plan_name;
        $section_plan->section_plan_desc = $request->section_plan_desc;
        $section_plan->section_num = $request->is_exam == 0 ? $request->section_num : null;
        $section_plan->max_seminar_work_point = $request->max_seminar_work_point;
        $section_plan->max_seminar_pass_point = $request->max_seminar_pass_point;
        $section_plan->max_lecture_pass_point = $request->max_lecture_pass_point;
        $section_plan->update();
    }

public function getValidateStoreSectionPlan(Request $request) {
    $validator = Validator::make($request->all(), [
        'section_plan_name' => 'required',
        'is_exam' => 'required',
        'section_num' => [ 'required_if:is_exam,0',
            'integer',
            'min:1',
            Rule::unique('section_plans')->where('id_course_plan', $request->id_course_plan)
        ],
    ]);
    return $validator;
}

    public function getValidateUpdateSectionPlan(Request $request) {
        $validator = Validator::make($request->all(), [
            'section_plan_name' => 'required',
            'is_exam' => 'required',
            'section_num' => [ 'required_if:is_exam,0',
                'integer',
                'min:1',
                Rule::unique('section_plans')->where('id_course_plan', $request->id_course_plan)
                    ->ignore( $request->id_section_plan, 'id_section_plan')
            ],
        ]);
        return $validator;
    }


    public function deleteSectionPlan($id){
        LecturePlan::where('id_section_plan', $id)->delete();
        SeminarPlan::where('id_section_plan', $id)->delete();
        ControlWorkPlan::where('id_section_plan', $id)->delete();
        SectionPlan::findOrFail($id)->delete();
    }
}