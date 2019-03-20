<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 18.03.2019
 * Time: 2:20
 */

namespace App\Statements\DAO;

use App\Statements\LecturePlan;

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

        $deserializForm = $this->deserializationHtmlForm($request->form);

        //toDO добавить проверку на уникальность номера лекции
        $validator = Validator::make($deserializForm, [
            'lecture_plan_name' => 'required|between:5,255',
            'lecture_plan_desc' => 'between:5,5000',
            'lecture_plan_num' => [ 'required',
                'integer',
                'min:1']
        ]);
        return $validator;
    }

    public function getUpdateValidate(Request $request) {
        $deserializForm = $this->deserializationHtmlForm($request->form);

        //toDO добавить проверку на уникальность номера лекции
        $validator = Validator::make($deserializForm, [
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