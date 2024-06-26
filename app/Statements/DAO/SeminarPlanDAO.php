<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 21.03.2019
 * Time: 0:14
 */

namespace App\Statements\DAO;
use App\Statements\Plans\SectionPlan;
use Illuminate\Http\Request;
use App\Statements\Plans\SeminarPlan;
use Validator;

class SeminarPlanDAO implements ItemSectionDAO {
    public function get($id){
        $seminarPlan = SeminarPlan::where('id_seminar_plan', $id)->first();
        return $seminarPlan;
    }

    public function store(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $seminar_plan = new SeminarPlan();
        $seminar_plan->seminar_plan_name = $form['seminar_plan_name'];
        $seminar_plan->seminar_plan_desc = $form['seminar_plan_desc'];
        $seminar_plan->seminar_plan_num =  $form['seminar_plan_num'];
        $seminar_plan->id_section_plan = $request->input('id_section_plan');
        $seminar_plan->save();
        return $seminar_plan->id_seminar_plan;
    }

    public function update(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $seminar_plan = $this->get($form['id_seminar_plan']);
        $seminar_plan->seminar_plan_name = $form['seminar_plan_name'];
        $seminar_plan->seminar_plan_desc = $form['seminar_plan_desc'];
        $seminar_plan->seminar_plan_num =  $form['seminar_plan_num'];
        $seminar_plan->update();
    }

    public function getStoreValidate(Request $request) {
        return $this->getValidate($request)->after(function ($validator) {
            //ПРоверка на уникальность номера семинара
            $count_seminar = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])
                ->join('seminar_plans', 'section_plans.id_section_plan', '=', 'seminar_plans.id_section_plan')
                ->where('seminar_plans.seminar_plan_num', '=', $validator->getData()['seminar_plan_num'])
                ->count();
            if ($count_seminar != 0) {
                $validator->errors()->add('unique_lecture_plan','Выбранный номер уже существует в данном учебном плане');
            }
        });
    }

    public function getUpdateValidate(Request $request) {
        return $this->getValidate($request)->after(function ($validator) {
            //ПРоверка на уникальность номера семинара
            $count_seminar = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])
                ->join('seminar_plans', 'section_plans.id_section_plan', '=', 'seminar_plans.id_section_plan')
                ->where('seminar_plans.seminar_plan_num', '=', $validator->getData()['seminar_plan_num'])
                ->where('seminar_plans.id_seminar_plan', '<>', $validator->getData()['id_seminar_plan'])
                ->count();
            if ($count_seminar != 0) {
                $validator->errors()->add('unique_lecture_plan','Выбранный номер уже существует в данном учебном плане');
            }
        });
    }

    public function getValidate(Request $request) {
        $form = $this->deserializationHtmlForm($request->input('form'));
        $request_array = array();
        $request_array['seminar_plan_name'] = $form['seminar_plan_name'];
        $request_array['seminar_plan_desc'] = $form['seminar_plan_desc'];
        $request_array['seminar_plan_num'] = $form['seminar_plan_num'];
        $request_array['id_seminar_plan'] = $form['id_seminar_plan'];
        $request_array['id_course_plan'] = $request->input('id_course_plan');
        $validator = Validator::make($request_array, [
            'seminar_plan_num' => [ 'required',
                'integer',
                'min:1']
        ]);
        return $validator;
    }

    public function delete(Request $request){
        SeminarPlan::findOrFail($request->input('id_item_plan'))->delete();
    }

//Десирилизация серилизованной формы html
    public function deserializationHtmlForm($serForm) {

        $form =  array();
        //Десирилизация серилизованной формы html
        parse_str($serForm, $form);
        return $form;
    }
}