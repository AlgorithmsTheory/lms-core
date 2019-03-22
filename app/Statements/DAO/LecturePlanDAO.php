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
class LecturePlanDAO {
    public function getLecturePlan($id){
        $lecture_plan = LecturePlan::where('id_lecture_plan', $id)->first();
        return $lecture_plan;
    }

    public function storeLecturePlan(Request $request){
        $lecture_plan = new LecturePlan();
        $lecture_plan->lecture_plan_name = $request->form->lecture_plan_name;
        $lecture_plan->lecture_plan_desc = $request->form->lecture_plan_desc;
        $lecture_plan->id_section_plan = $request->id_sectionDB;
        $lecture_plan->lecture_plan_num = $request->form->lecture_plan_num;
        $lecture_plan->save();
        return $lecture_plan->id_lecture_plan;
    }



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


}