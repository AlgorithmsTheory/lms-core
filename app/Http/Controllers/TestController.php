<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */

namespace App\Http\Controllers;
use App\Test;
use App\Theme;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use PDOStatement;
use  PDO;
use Illuminate\Routing\Controller;

class TestController extends Controller{
    private $test;

    function __construct(Test $test){
        $this->test=$test;
    }

    public function index(){
        $tr_tests = [];             //массив тренировочных тестов
        $ctr_tests = [];            //массив контрольных тестов
        $tr_names = [];
        $ctr_names = [];
        $query = $this->test->select('id_test', 'test_name')->get();
        foreach ($query as $test){
            $test_name = explode(";", $test->test_name);
            if ($test_name[0] == 'Тренировочный'){
                array_push($tr_tests, $test->id_test);          //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($tr_names, $test_name[1]);           //самого названия теста
            }
            else {
                array_push($ctr_tests, $test->id_test);
                array_push($ctr_names, $test->test_name);
            }
        }
        $tr_amount = count($tr_tests);
        $ctr_amount = count($ctr_tests);
        return view('tests.index', compact('tr_tests', 'ctr_tests', 'tr_names', 'ctr_names', 'tr_amount', 'ctr_amount'));
    }

    public function create(){
        $codificator = new Codificator();
        $types = [];
        $sections = [];
        $query = $codificator->whereCodificator_type('Тип')->select('value')->get();                                    //формируем массив типов
        foreach ($query as $type){
            array_push($types,$type->value);
        }
        $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();                                 //формируем массив разделов
        foreach ($query as $section){
            array_push($sections, $section->value);
        }
        return view('tests.create', compact('types', 'sections'));
    }

}