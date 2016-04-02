<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 22.02.16
 * Time: 2:45
 */

namespace App\Http\Controllers;
use App\Fine;
use App\Test;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/** Модуль преподавателя для управления возможностью переписывания тестов студентами */
class TeacherRetestController extends Controller {
    public function index(){
        $id = [];
        $student_names = [];
        $test_names = [];
        $groups = [];
        $accesses = [];
        $fines = [];
        $all_tests = [];
        $users = [];
        $distinct_groups = [];

        // TODO: добавить фильтр по текущему году для отбора действующих студентов
        $users_query = User::join('fines', 'users.id', '=', 'fines.id_user')
            ->orderBy('last_name', 'asc')
            ->distinct()
            ->select('first_name', 'last_name')->get();
        foreach($users_query as $user){
            array_push($users, $user);
        }

        $groups_query = User::join('fines', 'users.id', '=', 'fines.id_user')
            ->orderBy('group', 'asc')
            ->distinct()
            ->select('group')
            ->get();
        foreach($groups_query as $group){
            array_push($distinct_groups, $group);
        }

        $fine_table = Fine::get();
        foreach ($fine_table as $row){
            array_push($id, $row->id_fine);
            // TODO: добавить фильтр по текущему году для отбора действующих студентов
            $user = User::whereId($row->id_user)->select('first_name', 'last_name', 'group')->first();
            array_push($student_names, $user->last_name.' '.$user->first_name);
            $test = Test::whereId_test($row->id_test)->select('test_name')->first();
            array_push($groups, $user->group);
            array_push($test_names, $test->test_name);
            array_push($accesses, $row->access);
            array_push($fines, Fine::levelToPercent($row->fine));
        }

        $tests = Test::distinct()->select('test_name')->get();
        foreach($tests as $test){
            array_push($all_tests, $test->test_name);
        }
        return view('personal_account.retest', compact('id','student_names', 'test_names', 'groups', 'accesses', 'fines', 'all_tests', 'users', 'distinct_groups'));
    }

   /** Применение изменений на странице переписывания тестов (возможность прохождения и уровень штрафа) */
    public function change(Request $request){
        for ($i=0; $i < count($request->input('fines')); $i++){
            Fine::whereId_fine($request->input('id')[$i])->update(['fine' => Fine::percentToLevel($request->input('fine-levels')[$i]),
                                                                   'access' => $request->input('fines')[$i]]);
        }
       return redirect()->back();
    }

   public function outOfDateTests(){
       $out_of_date_control_tests = [];
       $out_of_date_training_tests = [];
       $current_date = date('U');
       $test = Test::whereTest_type('Контрольный')->select()->get();
       foreach ($test as $row)
       if ($current_date >= strtotime($row->start) && $current_date <= strtotime($row->end) && $row->test_course != 'Рыбина'){
           array_push($out_of_date_control_tests, $row);
       }
       $test = Test::whereTest_type('Тренировочный')->select()->get();
       foreach ($test as $row)
           if ($current_date >= strtotime($row->start) && $current_date <= strtotime($row->end) && $row->test_course != 'Рыбина'){
               array_push($out_of_date_training_tests, $row);
           }
       return view('personal_account.out_of_date_tests', compact('out_of_date_control_tests', 'out_of_date_training_tests'));
   }

    /** Завершает выбранные просроченные тесты
     * Завершить тест - Отнять у всех текущих студентов попытку прохождения теста и,
     возможно, добавить записи user-test в таблицу штрафов
     */
    public function finishTest(Request $request){

    }

    /** продлевает все просроченные тесты на 4 месяца */
    public function prolongTest(Request $request){

    }
} 