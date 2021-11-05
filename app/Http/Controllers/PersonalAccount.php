<?php
namespace App\Http\Controllers;
use App\Testing\Result;
use App\Testing\Test;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;
class PersonalAccount extends Controller{
    private $test;
    function __construct(Test $test){
        $this->test=$test;
    }

    public static function showTestResults(){   //показывает результаты тестов
        $tests = [];
        $names = [];
        $query = Test::select('id_test', 'test_course', 'test_name', 'test_type')->get();
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



    public function showAllTests(Request $request){   //показывает результаты всех тестов всех студентов
        $tests = [];
        $names = [];
        $last_names = [];
        $first_names = [];
        $groups = [];
        $test_names = [];
        $result_dates = [];
        $results = [];
        $marks = [];
        $query = $this->test->select('id_test', 'test_course', 'test_name', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                array_push($tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($names, $test->test_name);                                                            //самого названия теста
            }
        }
        $amount = count($tests);
        $resultsQuery = Result::join('tests', 'tests.id_test', '=', 'results.id_test');
        if (!empty($request->test)) {
            $resultsQuery = $resultsQuery->where('tests.id_test', $request->test);
        }
        $resultsQuery = $resultsQuery
            ->leftJoin('users', 'users.id', '=', 'results.id')
            ->leftJoin('groups', 'groups.group_id', '=', 'users.group');

        if (!empty($request->surname)) {
            $resultsQuery = $resultsQuery->where('users.last_name', 'like', '%' . $request->surname . '%');
        }

        if (!empty($request->group)) {
            $resultsQuery = $resultsQuery->where('groups.group_name', 'like', '%' . $request->group . '%');
        }

        $request_test = $request->test;
        $request_surname = $request->surname;
        $request_group = $request->group;

        $resultsQuery = $resultsQuery
            ->select('results.id', 'test_name', 'result_date', 'result', 'mark_eu',
                'users.last_name', 'users.first_name', 'groups.group_name')
            ->paginate(100);
        foreach ($resultsQuery as $res){
            #$user = User::whereId($res->id)->join('groups', 'groups.group_id', '=', 'users.group')->get();
            #if(isset($res->last_name)) {
            #    array_push($last_names, $user[0]->last_name);
            #    array_push($first_names, $user[0]->first_name);
            #    array_push($groups, $user[0]->group_name);
            #}
            #else {
            #    array_push($last_names, 'УДАЛЕН');
            #    array_push($first_names, 'УДАЛЕН');
            #    array_push($groups, '-1');
            #}
            array_push($last_names, $res->last_name);
            array_push($first_names, $res->first_name);
            array_push($groups, $res->group_name);
            array_push($test_names, $res->test_name);
            array_push($result_dates, $res->result_date);
            array_push($results, $res->result);
            array_push($marks, $res->mark_eu);
        }
        return view('personal_account/teacher_account', compact('results', 'last_names',
            'first_names', 'groups', 'test_names', 'result_dates', 'marks', 'amount', 'tests', 'names',
            'resultsQuery', 'request_test', 'request_surname', 'request_group'));
    }

}