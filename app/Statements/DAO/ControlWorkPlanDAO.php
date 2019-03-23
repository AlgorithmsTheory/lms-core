<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 21.03.2019
 * Time: 2:57
 */

namespace App\Statements\DAO;
use App\Statements\CoursePlan;
use App\Statements\SectionPlan;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Statements\ControlWorkPlan;

class ControlWorkPlanDAO implements ItemSectionDAO
{
    public function get($id){
        $controlWorkPlan = ControlWorkPlan::where('id_control_work_plan', $id)->first();
        return $controlWorkPlan;
    }

    public function store(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $controlWorkPlan = new ControlWorkPlan();
        $controlWorkPlan->control_work_plan_name = $form['control_work_plan_name'];
        $controlWorkPlan->control_work_plan_desc = $form['control_work_plan_desc'];
        $controlWorkPlan->control_work_plan_type = $form['control_work_plan_type'];

        if($form['control_work_plan_type'] == 'ONLINE_TEST' || $form['control_work_plan_type'] == 'OFFLINE_TEST') {
            $controlWorkPlan->id_test =  $form['id_test'];
        } else {
            $controlWorkPlan->id_test = NULL;
        }
        $controlWorkPlan->max_points =  $form['max_points'];
        $controlWorkPlan->id_section_plan = $request->id_section_DB;
        $controlWorkPlan->save();
        return $controlWorkPlan->id_control_work_plan;
    }

    public function update(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $controlWorkPlan = $this->get($form['id_control_work_plan']);
        $controlWorkPlan->control_work_plan_name = $form['control_work_plan_name'];
        $controlWorkPlan->control_work_plan_desc = $form['control_work_plan_desc'];
        $controlWorkPlan->control_work_plan_type = $form['control_work_plan_type'];

        if($form['control_work_plan_type'] == 'ONLINE_TEST' || $form['control_work_plan_type'] == 'OFFLINE_TEST') {
            $controlWorkPlan->id_test =  $form['id_test'];
        } else {
            $controlWorkPlan->id_test = NULL;
        }
        $controlWorkPlan->max_points =  $form['max_points'];
        $controlWorkPlan->id_section_plan = $request->id_section_DB;
        $controlWorkPlan->update();
    }

    public function getStoreValidate(Request $request) {
        $form = $this->deserializationHtmlForm($request->input('form'));
        $request_array = array();
        $request_array['control_work_plan_name'] = $form['control_work_plan_name'];
        $request_array['control_work_plan_type'] = $form['control_work_plan_type'];
        $request_array['max_points'] = $form['max_points'];
        $request_array['id_test'] = $form['id_test'];
        $request_array['id_course_plan'] = $request->input('id_course_plan');

        $validator = Validator::make($request_array, [
            'control_work_plan_name' => 'required|between:5,255',
            'control_work_plan_type' => 'required',
            'max_points' => ['required',
                'integer',
                'between:0,100']
        ]);

        $validator->after(function ($validator) {
            //введённый макс балл
            $current_max_points = $validator->getData()['max_points'];
            //Кол баллов за все к.м. в курсе
            $max_points = DB::table('section_plans')
                ->join('control_work_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
                ->where('id_course_plan', $validator->getData()['id_course_plan'])->sum('max_points');

            $max_controls = DB::table('course_plans')->select('max_controls')
                ->where('id_course_plan', $validator->getData()['id_course_plan'])
                ->first()->max_controls;

            if($max_points + $current_max_points > $max_controls) {
                $validator->errors()->add('exceeded_max_points','Сумма баллов за все К.М превышает "Контрольные мероприятия в семестре"' . '(' . $max_controls . ')');
            }

            if($validator->getData()['control_work_plan_type'] == 'ONLINE_TEST'
                || $validator->getData()['control_work_plan_type'] == 'OFFLINE_TEST') {
                if ($validator->getData()['id_test'] == null) {
                    $validator->errors()->add('empty_test','Выберите тест');
                }
            }

        });
        return $validator;
    }

    public function getUpdateValidate(Request $request) {
        return $this->getStoreValidate($request);
    }

    public function delete(Request $request){
        ControlWorkPlan::findOrFail($request->id_item_plan)->delete();
    }

//Десирилизация серилизованной формы html
    public function deserializationHtmlForm($serForm) {

        $form =  array();
        //Десирилизация серилизованной формы html
        parse_str($serForm, $form);
        return $form;
    }
}