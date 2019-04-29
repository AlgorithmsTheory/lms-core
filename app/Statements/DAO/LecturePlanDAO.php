<?php

namespace App\Statements\DAO;

use App\Statements\LecturePlan;

use App\Statements\SectionPlan;
use Illuminate\Http\Request;
use Validator;

class LecturePlanDAO implements ItemSectionDAO
{
    public function get($id){
        $LecturePlan = LecturePlan::where('id_lecture_plan', $id)->first();
        return $LecturePlan;
    }

    public function store(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $LecturePlan = new LecturePlan();
        $LecturePlan->lecture_plan_name = $form['lecture_plan_name'];
        $LecturePlan->lecture_plan_desc = $form['lecture_plan_desc'];
        $LecturePlan->lecture_plan_num =  $form['lecture_plan_num'];
        $LecturePlan->id_section_plan = $request->id_section_DB;
        $LecturePlan->save();
        return $LecturePlan->id_lecture_plan;
    }

    public function update(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $LecturePlan = $this->get($form['id_lecture_plan']);
        $LecturePlan->lecture_plan_name = $form['lecture_plan_name'];
        $LecturePlan->lecture_plan_desc = $form['lecture_plan_desc'];
        $LecturePlan->lecture_plan_num =  $form['lecture_plan_num'];
        $LecturePlan->update();
    }

    public function getStoreValidate(Request $request) {
        return $this->getValidate($request)->after(function ($validator) {
            //ПРоверка на уникальность номера лекции
            $count_lecture = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])
                ->join('lecture_plans', 'section_plans.id_section_plan', '=', 'lecture_plans.id_section_plan')
                ->where('lecture_plans.lecture_plan_num', '=', $validator->getData()['lecture_plan_num'])
                ->count();
            if ($count_lecture != 0) {
                $validator->errors()->add('unique_lecture_plan','Выбранный номер уже существует в данном учебном плане');
            }
        });
    }

    public function getUpdateValidate(Request $request) {
        return $this->getValidate($request)->after(function ($validator) {
            //ПРоверка на уникальность номера лекции
            $count_lecture = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])
                ->join('lecture_plans', 'section_plans.id_section_plan', '=', 'lecture_plans.id_section_plan')
                ->where('lecture_plans.lecture_plan_num', '=', $validator->getData()['lecture_plan_num'])
                ->where('lecture_plans.id_lecture_plan', '<>', $validator->getData()['id_lecture_plan'])
                ->count();
            if ($count_lecture != 0) {
                $validator->errors()->add('unique_lecture_plan','Выбранный номер уже существует в данном учебном плане');
            }
        });
    }

    public function getValidate(Request $request) {
        $form = $this->deserializationHtmlForm($request->input('form'));
        $request_array = array();
        $request_array['lecture_plan_name'] = $form['lecture_plan_name'];
        $request_array['lecture_plan_desc'] = $form['lecture_plan_desc'];
        $request_array['lecture_plan_num'] = $form['lecture_plan_num'];
        $request_array['id_lecture_plan'] = $form['id_lecture_plan'];
        $request_array['id_course_plan'] = $request->input('id_course_plan');
        $validator = Validator::make($request_array, [
            'lecture_plan_name' => 'required|between:5,255',
            'lecture_plan_desc' => 'between:5,5000',
            'lecture_plan_num' => [ 'required',
                'integer',
                'min:1']
        ]);
        return $validator;
    }

    public function delete(Request $request){
        LecturePlan::findOrFail($request->id_item_plan)->delete();
    }

//Десирилизация серилизованной формы html
public function deserializationHtmlForm($serForm) {
    $form =  array();
    //Десирилизация серилизованной формы html
    parse_str($serForm, $form);
    return $form;
}


}