<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 21.11.15
 * Time: 16:44
 */

namespace App\Http\Controllers;


use App\Testing\Test;

class FishController extends Controller {
    /** генерирует страницу со списком доступных тестов */
    public function index(){
        $tr_tests = [];                                                                                                 //массив id тренировочных тестов
        $ctr_tests = [];                                                                                                //массив id контрольных тестов
        $tr_names = [];                                                                                                 //массив названий тренировочных тестов
        $ctr_names = [];                                                                                                //массив названий тренировочных тестов
        $current_date = date('U');
        $query = Test::select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($current_date >= strtotime($test->start) && $current_date <= strtotime($test->end) && $test->test_course == 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                $test_type = $test->test_type;
                if ($test_type == 'Тренировочный'){
                    array_push($tr_tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                    array_push($tr_names, $test->test_name);                                                            //самого названия теста
                }
                else {
                    array_push($ctr_tests, $test->id_test);
                    array_push($ctr_names, $test->test_name);
                }
            }
        }
        $tr_amount = count($tr_tests);
        $ctr_amount = count($ctr_tests);
        return view('tests.index', compact('tr_tests', 'ctr_tests', 'tr_names', 'ctr_names', 'tr_amount', 'ctr_amount'));
    }
} 