<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 14.03.2019
 * Time: 18:26
 */

namespace App\Statements\DAO;


use App\Statements\ControlWorkPlan;
use App\Statements\LecturePlane;
use App\Statements\SectionPlan;
use App\Statements\SeminarPlan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
class SectionPlanDAO
{

    public function getSectionPlan($id){
        $sectionPlan = SectionPlan::where('id_section_plan', $id)->first();
        return $sectionPlan;
    }

    public function storeSectionPlan(Request $request){
        $sectionPlan = new SectionPlan();
        $sectionPlan->section_plan_name = $request->section_plan_name;
        $sectionPlan->section_plan_desc = $request->section_plan_desc;
        $sectionPlan->id_course_plan = $request->id_course_plan;
        $sectionPlan->section_num = $request->section_num;
        $sectionPlan->is_exam = $request->is_exam;
        $sectionPlan->save();
        return $sectionPlan->id_section_plan;
    }

    public function updateSectionPlan(Request $request){
        $sectionPlan = $this->getSectionPlan($request->id_section_plan);
        $sectionPlan->section_plan_name = $request->section_plan_name;
        $sectionPlan->section_plan_desc = $request->section_plan_desc;
        $sectionPlan->section_num = $request->section_num;
        $sectionPlan->is_exam = $request->is_exam;
        $sectionPlan->save();
    }

public function getValidateStoreSectionPlan(Request $request) {
    $validator = Validator::make($request->all(), [
        'section_plan_name' => 'required|between:5,255',
        'section_plan_desc' => 'between:5,5000',
        'is_exam' => 'required',
        'section_num' => [ 'required',
            'integer',
            'min:1',
            Rule::unique('section_plans')->where('id_course_plan', $request->id_course_plan)
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
                Rule::unique('section_plans')->where('id_course_plan', $request->id_course_plan)
                    ->ignore( $request->id_section_plan, 'id_section_plan')
            ],
        ]);
        return $validator;
    }


    public function deleteSectionPlan($id){
        LecturePlane::where('id_section_plan', $id)->delete();
        SeminarPlan::where('id_section_plan', $id)->delete();
        ControlWorkPlan::where('id_section_plan', $id)->delete();
        SectionPlan::findOrFail($id)->delete();
    }
}