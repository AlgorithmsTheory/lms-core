<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 22.02.16
 * Time: 2:45
 */

namespace App\Http\Controllers;
use App\Fine;
use App\Result;
use App\Test;
use App\User;
use DB;
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

        $current_year = date('Y');
        $users_query = User::join('fines', 'users.id', '=', 'fines.id_user')
            ->where('year', '=', $current_year)
            ->orderBy('last_name', 'asc')
            ->distinct()
            ->select('first_name', 'last_name')->get();
        foreach($users_query as $user){
            array_push($users, $user);
        }

        $groups_query = User::join('fines', 'users.id', '=', 'fines.id_user')
            ->where('year', '=', $current_year)
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
            $user = User::whereId($row->id_user)->where('year', '=', $current_year)->select('first_name', 'last_name', 'group')->first();
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
        //найти всех студентов текущего года
        //а скорее искать тех, кого нет в таблице результатов по данному тесту в указанный интервал времени
        $absents = [];                                                                                                  //отсутствующие на тесте
        $current_year = date('Y');
        for ($i=0; $i < count($request->input('changes')); $i++){
            if ($request->input('changes')[$i] == true){                                                                //если тест был выбран для завершения
                $id_test = $request->input('id-test')[$i];
                $user_query = User::where('year', '=', $current_year)                                                   //пример сырого запроса
                            ->whereRaw("not exists (select `id_user` from `results`
                                        where results.id_user = users.id
                                        and `results`.`id_test` = ".$id_test. "
                                        and `results`.`result_date` between '".Test::whereId_test($id_test)->select('start')->first()->start."' and '".Test::whereId_test($id_test)->select('end')->first()->end."'
                                        )")
                            ->distinct()
                            ->select()
                            ->get();
                foreach ($user_query as $user){
                    array_push($absents, $user->id);
//                  /*Fine::insert(['id_user' => $user->id, 'id_test' => $request->input('id-test')[$i],
//                                  'fine' => 1, ])*/
                }
                dd($absents);
                //добавить их в таблицу штрафов, записав им первый уровень штрафа


            //добавить их в таблицу результатов, записав в качестве результатов -1 -1 absence
            //в таблице штрафов присвоить всем по этому тесту досутп 0, у кого досутп есть
            }
        }
    }

    /** продлевает все просроченные тесты на 4 месяца */
    public function prolongTest(Request $request){

    }
} 