<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 21.03.2019
 * Time: 2:57
 */

namespace App\Statements\DAO;
use App\Statements\Plans\SectionPlan;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Statements\Plans\ControlWorkPlan;

class ControlWorkPlanDAO implements ItemSectionDAO {
    public function get($id){
        $control_work_plan = ControlWorkPlan::where('id_control_work_plan', $id)->first();
        return $control_work_plan;
    }

    public function store(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $control_work_plan = new ControlWorkPlan();
        $control_work_plan->control_work_plan_name = $form['control_work_plan_name'];
        $control_work_plan->control_work_plan_desc = $form['control_work_plan_desc'];
        $control_work_plan->control_work_plan_type = $form['control_work_plan_type'];

        if($form['control_work_plan_type'] == 'ONLINE_TEST' || $form['control_work_plan_type'] == 'OFFLINE_TEST') {
            $control_work_plan->id_test =  $form['id_test'];
        } else {
            $control_work_plan->id_test = NULL;
        }
        $control_work_plan->max_points =  $form['max_points'];
        $control_work_plan->id_section_plan = $request->input('id_section_plan');
        $control_work_plan->save();
        return $control_work_plan->id_control_work_plan;
    }

    public function update(Request $request){
        $form = $this->deserializationHtmlForm($request->form);
        $control_work_plan = $this->get($form['id_control_work_plan']);
        $control_work_plan->control_work_plan_name = $form['control_work_plan_name'];
        $control_work_plan->control_work_plan_desc = $form['control_work_plan_desc'];
        $control_work_plan->control_work_plan_type = $form['control_work_plan_type'];

        if($form['control_work_plan_type'] == 'ONLINE_TEST' || $form['control_work_plan_type'] == 'OFFLINE_TEST') {
            $control_work_plan->id_test =  $form['id_test'];
        } else {
            $control_work_plan->id_test = NULL;
        }
        $control_work_plan->max_points =  $form['max_points'];
        $control_work_plan->update();
    }

    public function getValidate(Request $request) {
        $form = $this->deserializationHtmlForm($request->input('form'));
        $request_array = array();
        $request_array['control_work_plan_name'] = $form['control_work_plan_name'];
        $request_array['control_work_plan_type'] = $form['control_work_plan_type'];
        $request_array['max_points'] = $form['max_points'];
        $request_array['id_test'] = $form['id_test'];
        $request_array['id_control_work_plan'] = $form['id_control_work_plan'];
        $request_array['id_course_plan'] = $request->input('id_course_plan');
        $request_array['id_section_plan'] = $request->input('id_section_plan');

        $validator = Validator::make($request_array, [
            'control_work_plan_name' => 'required',
            'control_work_plan_type' => 'required',
            'max_points' => ['required',
                'numeric',
                'between:0,100']
        ]);

        $validator->after(function ($validator) {
            //введённый макс балл
            $current_max_points = $validator->getData()['max_points'];
            if (SectionPlan::where('id_section_plan', $validator->getData()['id_section_plan'])
                    ->first()->is_exam == 0) {
                //Кол баллов за все к.м. в курсе (обычные разделы курса)
                $max_points = DB::table('section_plans')
                    ->join('control_work_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
                    ->where('id_course_plan', $validator->getData()['id_course_plan'])
                    ->where('control_work_plans.id_control_work_plan', '<>', $validator->getData()['id_control_work_plan'])
                    ->where('is_exam', 0)
                    ->sum('max_points');

                $max_controls = DB::table('course_plans')->select('max_controls')
                    ->where('id_course_plan', $validator->getData()['id_course_plan'])
                    ->first()->max_controls;
                $different = $max_points + $current_max_points - $max_controls;
                if ($max_points + $current_max_points > $max_controls) {
                    $validator->errors()->add('exceeded_max_points', 'Сумма баллов за все К.М превышает Макс балл за раздел "Контрольные мероприятия в семестре"' . '(' . $max_controls . ')
                     на '. $different);
                }
            } else {
                //Кол баллов за все к.м. в курсе (Экзамены(Зачёты))
                $max_points = DB::table('section_plans')
                    ->join('control_work_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
                    ->where('id_course_plan', $validator->getData()['id_course_plan'])
                    ->where('control_work_plans.id_control_work_plan', '<>', $validator->getData()['id_control_work_plan'])
                    ->where('is_exam', 1)
                    ->sum('max_points');

                $max_exam = DB::table('course_plans')->select('max_exam')
                    ->where('id_course_plan', $validator->getData()['id_course_plan'])
                    ->first()->max_exam;
                $different = $max_points + $current_max_points - $max_exam;
                if ($max_points + $current_max_points > $max_exam) {
                    $validator->errors()->add('exceeded_max_points', 'Сумма баллов за все К.М превышает Макс балл за раздел "Зачет (экзамен)"' . '(' . $max_exam . ')
                     на ' . $different);
                }
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

    public function getStoreValidate(Request $request) {
        $validator = $this->getValidate($request);
        $validator->after(function ($validator) {
           //ПРоверка на уникальность теста в учебном плане
           //toDo потом эту проверку надо удалить
           $count_test = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])
               ->join('control_work_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
               ->where('control_work_plans.id_test', '=', $validator->getData()['id_test'])
               ->count();
           if ($count_test != 0) {
               $validator->errors()->add('unique_test','Выбранный тест уже существует в данном учебном плане');
           }
        });
        return $validator;
    }

    public function getUpdateValidate(Request $request) {
        $validator = $this->getValidate($request);
        $validator->after(function ($validator) {
            //ПРоверка на уникальность теста в учебном плане
            //toDo потом эту проверку надо удалить
            $count_test = SectionPlan::where('id_course_plan', $validator->getData()['id_course_plan'])
                ->join('control_work_plans', 'section_plans.id_section_plan', '=', 'control_work_plans.id_section_plan')
                ->where('control_work_plans.id_test', '=', $validator->getData()['id_test'])
                ->where('control_work_plans.id_control_work_plan', '<>', $validator->getData()['id_control_work_plan'])
                ->count();
            if ($count_test != 0) {
                $validator->errors()->add('unique_test','Выбранный тест уже существует в данном учебном плане');
            }
        });
        return $validator;
    }

    public function delete(Request $request){
        ControlWorkPlan::findOrFail($request->input('id_item_plan'))->delete();
    }

//Десирилизация серилизованной формы html
    public function deserializationHtmlForm($serForm) {

        $form =  array();
        //Десирилизация серилизованной формы html
        parse_str($serForm, $form);
        return $form;
    }
}