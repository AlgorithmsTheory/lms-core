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

    /**
     * @param $amount
     * @param $section
     * @param $theme
     * @param $type
     * Из текстовых описаний вопроса, формирует структуру a-b.c.d
     * @return string
     */
    private function struct($amount, $section, $theme, $type){
        $codificator = new Codificator();
        if ($amount != ''){
            $struct = $amount.'-';
        }
        else $struct = '';
        if ($section == 'Любой'){
            $struct .= 'A.';
        }
        else {
            $query = $codificator->whereValue($section)->select('code')->first();
            $struct .= $query->code.'.';
        }
        if ($theme == 'Любая'){
            $struct .= 'A.';
        }
        else {
            $query = $codificator->whereValue($theme)->select('code')->first();
            $struct .= $query->code.'.';
        }
        if ($type == 'Любой'){
            $struct .= 'A';
        }
        else {
            $query = $codificator->whereValue($type)->select('code')->first();
            $struct .= $query->code;
        }
        return $struct;
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

    public function getTheme(Request $request){
        if ($request->ajax()) {
            $themes = new Theme();
            $themes_list = [];
            $query = $themes->whereSection($request->input('choice'))->select('theme')->get();
            foreach ($query as $str){
                array_push($themes_list,$str->theme);
            }
            return (String) view('tests.getTheme', compact('themes_list'));
        }
    }

    public function getAmount(Request $request){
        if ($request->ajax()) {
            $question = new Question();
            $code = $this->struct('',$request->input('section'),$request->input('theme'),$request->input('type'));
            $code = preg_replace('~A~', '[[:digit:]]+', $code );
            $amount = $question->where('code', 'regexp', $code)->select('id_question')->count();
            return (String) $amount;
        }
    }

    public function add(Request $request){
        if ($request->input('training')) {
            $test_name = 'Тренировочный;'.$request->input('test-name');
        }
        else $test_name = $request->input('test-name');

        $total = $request->input('total');
        $test_time = $request->input('test-time');
        $start = $request->input('start-date').' '.$request->input('start-time');
        $end = $request->input('end-date').' '.$request->input('end-time');

        $structure = '';
        $amount = 0;
        for ($i=0; $i<$request->input('num-rows'); $i++){
            $structure .= $this->struct($request->input('num')[$i],$request->input('section')[$i],$request->input('theme')[$i],$request->input('type')[$i]).';';
            $amount += $request->input('num')[$i];
        }
        $structure .= $this->struct($request->input('num')[$request->input('num-rows')],$request->input('section')[$request->input('num-rows')],$request->input('theme')[$request->input('num-rows')],$request->input('type')[$request->input('num-rows')]);
        $amount += $request->input('num')[$request->input('num-rows')];
        Test::insert(array('test_name' => $test_name, 'amount' => $amount, 'test_time' => $test_time, 'start' => $start, 'end' => $end, 'structure' => $structure, 'total' => $total));

        return redirect()->route('test_create');
    }

}