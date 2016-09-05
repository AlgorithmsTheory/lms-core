<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 22.02.16
 * Time: 2:45
 */

namespace App\Http\Controllers;
use App\Testing\Fine;
use App\Testing\Result;
use App\Testing\Test;
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
        $attempts = [];
        $last_marks = [];
        $all_tests = [];
        $users = [];
        $distinct_groups = [];

        $current_year = date('Y');
        $users_query = User::join('fines', 'users.id', '=', 'fines.id')
            ->where('year', '=', $current_year)
            ->orderBy('last_name', 'asc')
            ->distinct()
            ->select('first_name', 'last_name')->get();
        foreach($users_query as $user){
            array_push($users, $user);
        }

        $groups_query = User::join('fines', 'users.id', '=', 'fines.id')
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
            $user = User::whereId($row->id)->where('year', '=', $current_year)->select('first_name', 'last_name', 'group')->first();
            array_push($student_names, $user->last_name.' '.$user->first_name);
            $test = Test::whereId_test($row->id_test)->select('test_name')->first();
            array_push($groups, $user->group);
            array_push($test_names, $test->test_name);
            array_push($accesses, $row->access);
            array_push($fines, Fine::levelToPercent($row->fine));
            array_push($attempts, Result::whereId_test($row->id_test)->whereId($row->id)->where('mark_ru', '>=', 0)->count());
            //dd(Result::whereId_test($row->id_test)->whereId_user($row->id_user)->select('mark_eu')->orderBy('id_result', 'desc')->first()->mark_eu);
            $result = Result::whereId_test($row->id_test)->whereId($row->id)->select('mark_eu')->orderBy('id_result', 'desc')->first()->mark_eu;
            array_push($last_marks, preg_replace('/^absent$/', 'Отсутствие', $result));
        }

        $marks = ['A', 'B', 'C', 'D', 'E', 'F'];

        $tests = Test::distinct()->select('test_name')->get();
        foreach($tests as $test){
            array_push($all_tests, $test->test_name);
        }
        return view('personal_account.retest', compact('id','student_names', 'test_names', 'groups', 'attempts', 'last_marks', 'accesses', 'fines', 'all_tests', 'users', 'distinct_groups', 'marks'));
    }

   /** Применение изменений на странице переписывания тестов (возможность прохождения и уровень штрафа) */
    public function change(Request $request){
        for ($i=0; $i < count($request->input('fines')); $i++){
            Fine::whereId_fine($request->input('id')[$i])->update(['fine' => Fine::percentToLevel($request->input('fine-levels')[$i]),
                                                                   'access' => $request->input('fines')[$i]]);
        }
       return redirect()->back();
    }

    /** Завершает выбранные просроченные тесты
     * Завершить тест - Отнять у всех текущих студентов попытку прохождения теста и,
     возможно, добавить записи user-test в таблицу штрафов
     */
    public function finishTest(Request $request){
        //найти всех студентов текущего года
        //а скорее искать тех, кого нет в таблице результатов по данному тесту в указанный интервал времени
        $absents = [];                                                                                                  //отсутствующие на тесте
        $fine = new Fine();
        $current_year = date('Y');
        for ($i=0; $i < count($request->input('changes')); $i++){
            if ($request->input('changes')[$i] == true){                                                                //если тест был выбран для завершения
                $id_test = $request->input('id-test')[$i];
                $user_query = User::where('year', '=', $current_year)                                                   //пример сырого запроса
                            ->whereRole('Студент')
                            ->whereRaw("not exists (select `id` from `results`
                                        where results.id = users.id
                                        and `results`.`id_test` = ".$id_test. "
                                        and `results`.`result_date` between '".Test::whereId_test($id_test)->select('start')->first()->start."'
                                        and '".Test::whereId_test($id_test)->select('end')->first()->end."'
                                        )")
                            ->distinct()
                            ->select()
                            ->get();
                foreach ($user_query as $user){
                    array_push($absents, $user->id);
                    //добавить их в таблицу штрафов, записав им первый уровень штрафа
                    //в таблице штрафов присвоить всем по этому тесту досутп 0, у кого досутп есть
                    $fine_query = Fine::whereId($user->id)->whereId_test($id_test)->select('id_fine')->first();
                    if (is_null($fine_query))
                        Fine::insert(['id' => $user->id, 'id_test' => $request->input('id-test')[$i],
                            'fine' => 1, 'access' => 0]);
                    else Fine::whereId($user->id)->whereId_test($id_test)
                            ->update(['fine' => $fine->maxFine($fine_query->fine + 1), 'access' => 0]);

                    //добавить их в таблицу результатов, записав в качестве результатов -2 -2 absence
                    //если тест прошедший, то время результата должно быть на 5 секунд меньше, чем время завершения теста
                    if (Test::whereId_test($id_test)->select('end')->first()->end < date("Y-m-d H:i:s")){
                        $result_date = date("Y-m-d H:i:s",strtotime(Test::whereId_test($id_test)->select('end')->first()->end) - 5);
                    }
                    else $result_date = date("Y-m-d H:i:s");
                    Result::insert(['id' => $user->id, 'id_test' => $id_test,
                    'result_date' => $result_date,
                    'result' => -2, 'mark_ru' => -2, 'mark_eu' => 'absent', 'saved_test' => null]);

                }
                //если тест является текущим, то сделать время его закрытия текущим временем (чтобы он попал в прошлые)
                if (Test::whereId_test($id_test)->select('start')->first()->start < date("Y-m-d H:i:s") &&
                    Test::whereId_test($id_test)->select('end')->first()->end > date("Y-m-d H:i:s")){
                    Test::whereId_test($id_test)->update(['end' => date("Y-m-d H:i:s")]);
                }
                //нельзя ставить дату открытия раньше сегодняшнего числа!
            }
        }
        return redirect()->back();
    }
} 