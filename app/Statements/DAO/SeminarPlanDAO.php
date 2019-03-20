<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 21.03.2019
 * Time: 0:14
 */

namespace App\Statements\DAO;
use Illuminate\Http\Request;
use App\Statements\SeminarPlan;
use Validator;

class SeminarPlanDAO implements ItemSectionDAO
{
    public function get($id){
        $seminarPlan = SeminarPlan::where('id_seminar_plan', $id)->first();
        return $seminarPlan;
    }

    public function store(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $seminarPlan = new SeminarPlan();
        $seminarPlan->seminar_plan_name = $form['seminar_plan_name'];
        $seminarPlan->seminar_plan_desc = $form['seminar_plan_desc'];
        $seminarPlan->seminar_plan_num =  $form['seminar_plan_num'];
        $seminarPlan->id_section_plan = $request->id_section_DB;
        $seminarPlan->save();
        return $seminarPlan->id_seminar_plan;
    }

    public function update(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $seminarPlan = $this->get($form['id_seminar_plan']);
        $seminarPlan->seminar_plan_name = $form['seminar_plan_name'];
        $seminarPlan->seminar_plan_desc = $form['seminar_plan_desc'];
        $seminarPlan->seminar_plan_num =  $form['seminar_plan_num'];
        $seminarPlan->update();
    }

    public function getStoreValidate(Request $request) {

        $deserializForm = $this->deserializationHtmlForm($request->form);

        //toDO добавить проверку на уникальность номера семинара в учебном плане
        $validator = Validator::make($deserializForm, [
            'seminar_plan_name' => 'required|between:5,255',
            'seminar_plan_desc' => 'between:5,5000',
            'seminar_plan_num' => [ 'required',
                'integer',
                'min:1']
        ]);
        return $validator;
    }

    public function getUpdateValidate(Request $request) {
        $deserializForm = $this->deserializationHtmlForm($request->form);

        //toDO добавить проверку на уникальность номера семинара в учебном плане
        $validator = Validator::make($deserializForm, [
            'seminar_plan_name' => 'required|between:5,255',
            'seminar_plan_desc' => 'between:5,5000',
            'seminar_plan_num' => [ 'required',
                'integer',
                'min:1']
        ]);
        return $validator;
    }

    public function delete(Request $request){
        SeminarPlan::findOrFail($request->id_item_plan)->delete();
    }

//Десирилизация серилизованной формы html
    public function deserializationHtmlForm($serForm) {

        $form =  array();
        //Десирилизация серилизованной формы html
        parse_str($serForm, $form);
        return $form;
    }
}