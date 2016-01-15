<?php
namespace App\Http\Controllers;
use App\Result;
use App\Test;
use App\Theme;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use PDOStatement;
use  PDO;
use Session;

class PersonalAccount extends Controller{
    private $test;
    function __construct(Test $test){
        $this->test=$test;
    }

    public function showPA(){   //показывает личный кабинет, вкладку со статистикой
        $tests = [];                                                                                                 //массив id тренировочных тестов         //массив id контрольных тестов
        $names = [];                                                                                                 //массив названий тренировочных тестов         //массив названий тренировочных тестов
        $query = $this->test->select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                array_push($tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($names, $test->test_name);                                                            //самого названия теста
            }
        }
        $amount = count($tests);
        $user = Auth::user();
        $results = Result::whereId_user($user['id'])->get();
        return view('personal_account/personal_account', compact('results', 'amount', 'tests', 'names'));
    }


    public function showTeacherPA(){   //показывает личный кабинет, вкладку со статистикой
        $tests = [];                                                                                                 //массив id тренировочных тестов         //массив id контрольных тестов
        $names = [];         //массив id тренировочных тестов         //массив id контрольных тестов
        $last_names = [];
        $first_names = [];
        $groups = [];
        $test_names = [];
        $result_dates = [];
        $results = [];
        $marks = [];
        $query = $this->test->select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                array_push($tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($names, $test->test_name);                                                            //самого названия теста
            }
        }
        $amount = count($tests);
        $c = 0;
        $resultsQuery = Result::select('id_user', 'test_name', 'result_date', 'result', 'mark_eu')->get();
        foreach ($resultsQuery as $res){
            $user = User::whereId($res->id_user)->get();
//            $c = $c + count($user);
            if(count($user) != 0) {
                array_push($last_names, $user[0]->last_name);
                array_push($first_names, $user[0]->first_name);
                array_push($groups, $user[0]->group);
            }
            else {
                array_push($last_names, 'УДАЛЕН');
                array_push($first_names, 'УДАЛЕН');
                array_push($groups, '-1');
            }
            array_push($test_names, $res->test_name);
            array_push($result_dates, $res->result_date);
            array_push($results, $res->result);
            array_push($marks, $res->mark_eu);
        }
//        print_r($user);
//        print_r($user[0]->first_name);
//        print_r(count($test_names));
//        print_r($user[0]->first_name);
//        print_r($c);
        return view('personal_account/teacher_account', compact('results', 'last_names', 'first_names', 'groups', 'test_names', 'result_dates', 'marks', 'amount', 'tests', 'names'));
    }

}