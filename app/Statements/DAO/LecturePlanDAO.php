<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 18.03.2019
 * Time: 2:20
 */

namespace App\Statements\DAO;
use App\Statements\LecturePlan;
use App\Http\Requests\Request;
use Validator;
use Illuminate\Validation\Rule;
class LecturePlanDAO
{
    public function getLecturePlan($id){
        $LecturePlan = LecturePlan::where('id_lecture_plan', $id)->first();
        return $LecturePlan;
    }

    public function storeLecturePlan(Request $request){
        $LecturePlan = new LecturePlan();
        $LecturePlan->lecture_plan_name = $request->form->lecture_plan_name;
        $LecturePlan->lecture_plan_desc = $request->form->lecture_plan_desc;
        $LecturePlan->id_section_plan = $request->id_sectionDB;
        $LecturePlan->lecture_plan_num = $request->form->lecture_plan_num;
        $LecturePlan->save();
        return $LecturePlan->id_lecture_plan;
    }

//    public function updateLecturePlan(Request $request){
//        $LecturePlan = $this->getLecturePlan($request->id_section_plan);
//        $LecturePlan->section_plan_name = $request->section_plan_name;
//        $LecturePlan->section_plan_desc = $request->section_plan_desc;
//        $LecturePlan->section_num = $request->section_num;
//        $LecturePlan->is_exam = $request->is_exam;
//        $LecturePlan->save();
//    }

    public function getValidateStoreLecturePlan(Request $request) {
        $validator = Validator::make($request->all(), [
            'form.lecture_plan_name' => 'required|between:5,255',
            'form.lecture_plan_desc' => 'between:5,5000',
            'form.lecture_plan_num' => [ 'required',
                'integer',
                'min:1',
                Rule::unique('lecture_plans')->where('id_section_plan', $request->id_sectionDB)
            ],
        ]);
        return $validator;
    }

//    public function getValidateUpdateLecturePlan(Request $request) {
//        $validator = Validator::make($request->all(), [
//            'section_plan_name' => 'required|between:5,255',
//            'section_plan_desc' => 'between:5,5000',
//            'is_exam' => 'required',
//            'section_num' => [ 'required',
//                'integer',
//                'min:1',
//                Rule::unique('section_plans')->where('id_course_plan', $request->id_course_plan)
//                    ->ignore( $request->id_section_plan, 'id_section_plan')
//            ],
//        ]);
//        return $validator;
//    }
//
//
//    public function deleteLecturePlan($id){
//        LecturePlan::findOrFail($id)->delete();
//    }
}