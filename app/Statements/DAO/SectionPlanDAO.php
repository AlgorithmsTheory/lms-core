<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 14.03.2019
 * Time: 18:26
 */

namespace App\Statements\DAO;


use App\Statements\ControlWorkPlan;
use App\Statements\LecturePlan;
use App\Statements\SectionPlan;
use App\Statements\SeminarPlan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
class SectionPlanDAO {

    public function getSectionPlan($id){
        $section_plan = SectionPlan::where('id_section_plan', $id)->first();
        return $section_plan;
    }

    public function storeSectionPlan(Request $request){
        $section_plan = new SectionPlan();
        $section_plan->section_plan_name = $request->input('section_plan_name');
        $section_plan->section_plan_desc = $request->input('section_plan_desc');
        $section_plan->id_course_plan = $request->input('id_course_plan');
        $section_plan->section_num = $request->input('section_num');
        $section_plan->is_exam = $request->input('is_exam');
        $section_plan->save();
        return $section_plan->id_section_plan;
    }

    public function updateSectionPlan(Request $request){
        $section_plan = $this->getSectionPlan($request->input('id_section_plan'));
        $section_plan->section_plan_name = $request->input('section_plan_name');
        $section_plan->section_plan_desc = $request->input('section_plan_desc');
        $section_plan->section_num = $request->input('section_num');
        $section_plan->is_exam = $request->input('is_exam');
        $section_plan->save();
    }

public function getValidateStoreSectionPlan(Request $request) {
    $validator = Validator::make($request->all(), [
        'section_plan_name' => 'required|between:5,255',
        'section_plan_desc' => 'between:5,5000',
        'is_exam' => 'required',
        'section_num' => [ 'required',
            'integer',
            'min:1',
            Rule::unique('section_plans')->where('id_course_plan', $request->input('id_course_plan'))
        ],
    ]);
    return $validator;
}

    public function getValidateUpdateSectionPlan(Request $request) {
        $validator = Validator::make($request->all(), [
            'section_plan_name' => 'required|between:5,255',
            'section_plan_desc' => 'between:5,5000',
            'is_exam' => 'required',
            'section_num' => [ 'required',
                'integer',
                'min:1',
                Rule::unique('section_plans')->where('id_course_plan', $request->input('id_course_plan'))
                    ->ignore( $request->input('id_section_plan'), 'id_section_plan')
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