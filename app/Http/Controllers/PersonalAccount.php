<?php
namespace App\Http\Controllers;
use App\Testing\Result;
use App\Testing\Test;
use App\User;
use Auth;

class PersonalAccount extends Controller{
    private $test;
    function __construct(Test $test){
        $this->test=$test;
    }

    public static function showTestResults(){   //показывает результаты тестов
        $tests = [];
        $names = [];
        $query = Test::select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                array_push($tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($names, $test->test_name);                                                            //самого названия теста
            }
        }
        $amount = count($tests);
        $user = Auth::user();
        $results = Result::whereId($user['id'])->get();
        return view('personal_account/personal_account', compact('results', 'amount', 'tests', 'names'));
    }



    public function showAllTests(){   //показывает результыты всех тестов всех студентов
        $tests = [];
        $names = [];
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
        $resultsQuery = Result::select('id', 'test_name', 'result_date', 'result', 'mark_eu')->get();
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
        return view('personal_account/teacher_account', compact('results', 'last_names', 'first_names', 'groups', 'test_names', 'result_dates', 'marks', 'amount', 'tests', 'names'));
    }

}