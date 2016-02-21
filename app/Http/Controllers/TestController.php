<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */
namespace App\Http\Controllers;
use App\Result;
use App\Test;
use App\Theme;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use Illuminate\Http\Response;
use Session;
use View;

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
            $query = $codificator->whereCodificator_type('Раздел')->whereValue($section)->select('code')->first();
            $struct .= $query->code.'.';
        }
        if ($theme == 'Любая'){
            $struct .= 'A.';
        }
        else {
            $query = $codificator->whereCodificator_type('Тема')->whereValue($theme)->join('themes', 'themes.theme', '=', 'codificators.value')->where('themes.section', '=', $section)->select('code')->first();
            $struct .= $query->code.'.';
        }
        if ($type == 'Любой'){
            $struct .= 'A';
        }
        else {
            $query = $codificator->whereCodificator_type('Тип')->whereValue($type)->select('code')->first();
            $struct .= $query->code;
        }
        return $struct;
    }

    /**
     * Декодирует кодовую структуру теста
     * Возвращает двумерный массив, где по i идут различные структуры вопросов, j=0 - количество вопросов данной структуры, j=1 - сам код вопроса
     */
    public function destruct($id_test){
        $test = new Test();
        $query = $test->whereId_test($id_test)->select('structure')->first();
        $structure = $query->structure;
        $destructured = explode(';', $structure);
        $array = [];
        for ($i=0; $i<count($destructured); $i++){
            $temp_array = explode('-', $destructured[$i]);
            for ($j=0; $j<=1; $j++){
                $array[$i][$j] = $temp_array[$j];
            }
        }
        return $array;
    }

    /** проверяет права доступа к рыбинским вопросам */
    public function rybaTest($id_question){
        $question = new Question();
        $question_controller = new QuestionController($question);
        if ($question_controller->getCode($id_question)['section_code'] == 10){
            if (Auth::user()['role'] == 'Рыбинец' || Auth::user()['role'] == 'Админ'){
                return true;
            }
        else return false;
        }
        else return true;
    }

    /** вычисляет оценку по Болонской системе, если дан максимально возможный балл и реальный */
    private function calcMarkBologna($max, $real){
        if ($real < $max * 0.6){
            return 'F';
        }
        if ($real >= $max * 0.6 && $real < $max * 0.65){
            return 'E';
        }
        if ($real >= 0.65 && $real < $max * 0.75){
            return 'D';
        }
        if ($real >= 0.75 && $real < $max * 0.85){
            return 'C';
        }
        if ($real >= 0.85 && $real < $max * 0.9){
            return 'B';
        }
        if ($real >= 0.9){
            return 'A';
        }
    }

    /** вычисляет оценку по обычной 5-тибалльной шкале, если дан максимально возможный балл и реальный */
    private function calcMarkRus($max, $real){
        if ($real < $max * 0.6){
            return '2';
        }
        if ($real >= $max * 0.6 && $real < $max * 0.7){
            return '3';
        }
        if ($real >= 0.7 && $real < $max * 0.9){
            return '4';
        }
        if ($real >= 0.9){
            return '5';
        }
    }

    /** генерирует страницу со списком доступных тестов */
    public function index(){
        $tr_tests = [];                                                                                                 //массив id тренировочных тестов
        $ctr_tests = [];                                                                                                //массив id контрольных тестов
        $tr_names = [];                                                                                                 //массив названий тренировочных тестов
        $ctr_names = [];                                                                                                //массив названий тренировочных тестов
        $current_date = date('U');
        $query = $this->test->select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($current_date >= strtotime($test->start) && $current_date <= strtotime($test->end) && $test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
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

    /** генерирует страницу создания нового теста */
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

    /** AJAX-метод: получает список тем раздела */
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

    /** AJAX-метод: по названию раздела, темы и типа вычисляет количество доступных вопросов в БД данной структуры */
    public function getAmount(Request $request){
        if ($request->ajax()) {
            $question = new Question();
            $code = $this->struct('',$request->input('section'),$request->input('theme'),$request->input('type'));
            $code = preg_replace('~A~', '[[:digit:]]+', $code );
            if ($request->input('test_type') == 'Тренировочный')
                $amount = $question->where('code', 'regexp', $code)->whereControl(false)->select('id_question')->count();
            else
                $amount = $question->where('code', 'regexp', $code)->select('id_question')->count();
            return (String) $amount;
        }
    }

    /** Добавляет новый тест в БД */
    public function add(Request $request){
        if ($request->input('training')) {
            $test_type = 'Тренировочный';
        }
        else $test_type = 'Контрольный';

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
        Test::insert(array('test_name' => $request->input('test-name'), 'test_type' => $test_type, 'amount' => $amount, 'test_time' => $test_time, 'start' => $start, 'end' => $end, 'structure' => $structure, 'total' => $total));

        return redirect()->route('test_create');
    }

    /** По номеру теста возвращает список id вопросов, удовлетворяющих всем параметрам теста */
    public function prepareTest($id_test){                                                                             //выборка вопросов
        $test = new Test();
        $question = new Question();
        $test_controller = new TestController($test);
        $question_controller = new QuestionController($question);
        $array = [];
        $k = 0;
        $destructured = $test_controller->destruct($id_test);
        for ($i=0; $i<count($destructured); $i++){                                                                      // идем по всем структурам
            $temp_array = [];
            $j = 0;
            $temp = '"';
            $temp .= preg_replace('~\.~', '\.', $destructured[$i][1]);
            $temp = preg_replace('~A~', '[[:digit:]]+', $temp);                                         //заменям все A (All) на регулярное выражение, соответствующее любому набору цифр
            $temp .= '"';
            $query = Question::whereRaw("code REGEXP $temp")->get();                                                  //ищем всевозможные коды вопросов
            $test_query = Test::whereId_test($id_test)->select('test_type')->first();
            foreach ($query as $id){
                if ($question_controller->getCode($id->id_question)['section_code'] != 'T'){                                                  //если вопрос не временный
                    if ($test_query->test_type == 'Тренировочный'){                                                     //если тест тренировочный
                        if ($id->control == 1)                                                                          //если вопрос скрытый, то проходим мимо
                            continue;
                        array_push($temp_array,$id->id_question);                                                       //для каждого кода создаем массив всех вопрососв с этим кодом
                    }
                    else array_push($temp_array,$id->id_question);                                                      // если тест контрольный
                }
            }
            while ($j < $destructured[$i][0]){                                                                          //пока не закончатся вопросы этой структуры
                $temp_array = $question_controller->randomArray($temp_array);                                                          //выбираем случайный вопрос
                $temp_question = $temp_array[count($temp_array)-1];
                if ($question_controller->getSingle($temp_question)){                                                                  //если вопрос одиночный (то есть как и было ранее)
                    $array[$k] = $temp_question;                                                                        //добавляем вопрос в выходной массив
                    $k++;
                    $j++;
                    array_pop($temp_array);
                }
                else {                                                                                                  //если вопрос может использоваться только в группе
                    $query = $question->whereId_question($temp_question)->first();
                    $base_question_type = $question_controller->getCode($temp_question)['type_code'];                                  //получаем код типа базового вопроса, для которого будем создавать группу
                    $max_id = Question::max('id_question');
                    $new_id = $max_id+1;
                    $new_title = $query->title;                                                                         //берем данные текущего вопроса
                    $new_answer = $query->answer;
                    array_pop($temp_array);                                                                             //и убираем его из массива
                    $new_temp_array = [];
                    for ($p=0; $p < count($temp_array); $p++){                                                          //создаем копию массива подходящих вопросов
                        $new_temp_array[$p] = $temp_array[$p];
                    }
                    $l = 0;
                    while ($l < 3) {                                                                                    //берем еще 3 вопроса этого типа => в итоге получаем 4
                        $new_temp_array = $question_controller->randomArray($new_temp_array);
                        $temp_question_new = $new_temp_array[count($new_temp_array)-1];

                        if ($question_controller->getCode($temp_question_new)['type_code'] != $base_question_type){                    //если тип вопроса не совпадает с базовым
                            array_pop($new_temp_array);                                                                 //удаляем его из новго массива и идем дальше
                            continue;
                        }

                        $index_in_old_array = array_search($temp_question_new, $temp_array);                            //ищем в базовом массиве индекс нашего вопроса
                        $chosen = $temp_array[$index_in_old_array];                                                     //и меняем его с последним элементом в этом массиве
                        $temp_array[$index_in_old_array]=$temp_array[count($temp_array)-1];
                        $temp_array[count($temp_array)-1] = $chosen;

                        $query_new = $question->whereId_question($temp_question_new)->first();
                        $new_title .= ';'.$query_new->title;                                                            //составляем составной вопрос
                        $new_answer .= ';'.$query_new->answer;
                        array_pop($temp_array);                                                                         //удаляем и из базовгго массива
                        array_pop($new_temp_array);                                                                     //и из нового
                        $l++;
                    }
                    Question::insert(array('control' => 0, 'code' => 'T.T.'.$base_question_type, 'title' => $new_title, 'variants' => '', 'answer' => $new_answer, 'points' => 1));    //вопрос про код и баллы
                    $array[$k] = $new_id;                                                                               //добавляем сформированный вопрос в выходной массив
                    $k++;
                    $j++;
                }
            }
        }
        return $array;                                                                                                  //формируем массив из id вошедших в тест вопросов
    }

    /** Главный метод: гененрирует полотно вопросов на странице тестов */
    public function showViews($id_test){
        $test = new Test();
        $result = new Result();
        $user = new User();
        $question = new Question();
        $question_controller = new QuestionController($question);
        $widgets = [];
        $saved_test = [];
        $current_date = date('U');

        $query = $test->whereId_test($id_test)->select('amount', 'test_name', 'test_time', 'start', 'end', 'test_type')->first();
        if ($current_date < strtotime($query->start) || $current_date > strtotime($query->end)){                          //проверка открыт ли тест
            return view('no_access');
        }
        $amount = $query->amount;                                                                                       //кол-во вопрососв в тесте
        $result->test_name = $query->test_name;
        $test_time = $query->test_time;
        $test_type = $query->test_type;

        if (!Session::has('test')){                                                                                     //если в тест зайдено первый раз
            $test = new Test();
            $test_controller = new TestController($test);
            $ser_array = $this->prepareTest($id_test);
            for ($i=0; $i<$amount; $i++){
                $id = $question_controller->chooseQuestion($ser_array);
                if (!$test_controller->rybaTest($id)){                                                                  //проверка на вопрос по рыбе
                    return view('no_access');
                };
                $data = $question_controller->show($id, $i+1);                                                                     //должны получать название view и необходимые параметры
                $saved_test[] = $data;
                $widgets[] = View::make($data['view'], $data['arguments']);
            }

            $start_time = date_create();                                                                                //время начала
            $int_end_time =  date_format($start_time,'U')+60*$test_time;                                                //время конца
            Session::put('end_time',$int_end_time);
            $query = Result::max('id_result');                                                                          //пример использования агрегатных функций!!!
            $current_result = $query+1;                                                                                 //создаем строку в таблице пройденных тестов
            $query2 = $user->whereEmail(Auth::user()['email'])->select('id')->first();
            $result->id_result = $current_result;
            $result->id_user = $query2->id;;
            $result->id_test = $id_test;
            $result->amount = $amount;
            $result->save();
            $saved_test = serialize($saved_test);
            Result::where('id_result', '=', $current_result)->update(['saved_test' => $saved_test]);
            Session::put('test', $current_result);
        }
        else {                                                                                                          //если была перезагружена страница теста или тест был покинут
            $current_test = Session::get('test');
            $query = $result->whereId_result($current_test)->first();
            $int_end_time = Session::get('end_time');                                                                   //время окончания теста
            $saved_test = $query->saved_test;
            $saved_test = unserialize($saved_test);
            for ($i=0; $i<$amount; $i++){
                $widgets[] = View::make($saved_test[$i]['view'], $saved_test[$i]['arguments']);
            }
        }

        $current_time = date_create();                                                                                  //текущее время
        $int_left_time = $int_end_time - date_format($current_time, 'U');                                               //оставшееся время
        $left_min =  floor($int_left_time/60);                                                                          //осталось минут
        $left_sec = $int_left_time % 60;                                                                                //осталось секунд

        $widgetListView = View::make('questions.student.widget_list',compact('amount', 'id_test','left_min', 'left_sec', 'test_type'))->with('widgets', $widgets);
        $response = new Response($widgetListView);
        return $response;
    }

    /** Проверка теста */
    public function checkTest(Request $request){   //обработать ответ на вопрос
        if (Session::has('test'))                                                                                       //проверяем повторность обращения к результам
            $current_test = Session::get('test');                                                                       //определяем проверяемый тест
        else
            return redirect('tests');
        Session::forget('test');                                                                                        //тест считается честно пройденым
        Session::forget('end_time');
        $amount = $request->input('amount');
        $id_test = $request->input('id_test');
        $test = new Test();
        $score_sum = 0;                                                                                                 //сумма набранных баллов
        $points_sum = 0;                                                                                                //сумма максимально овзможных баллов
        $choice = [];                                                                                                   //запоминаем выбранные варианты пользователя
        $right_percent = [];                                                                                            //Процент правильности ответа на неверный вопрос
        $j = 1;
        $question = new Question();
        $question_controller = new QuestionController($question);

        $query = $test->whereId_test($id_test)->select('total', 'test_name', 'amount', 'test_type')->first();
        $total = $query->total;
        $test_type = $query->test_type;
        for ($i=0; $i<$amount; $i++){                                                                                   //обрабатываем каждый вопрос
            $data = $request->input($i);
            $array = json_decode($data);
            $link_to_lecture[$j] = $question_controller->linkToLecture($array[0]);
            //print_r($array);
            $data = $question_controller->check($array);
            $right_or_wrong[$j] = $data['mark'];
            $choice[$j] = $data['choice'];
            $right_percent[$j] = $data['right_percent'];
            $j++;
            $score_sum += $data['score'];                                                                               //сумма набранных баллов
            $points_sum += $data['points'];                                                                             //сумма максимально возможных баллов
        }
        if ($points_sum != 0){
            $score = $total*$score_sum/$points_sum;
            $score = round($score,1);
        }
        else $score = $total;

        $mark_bologna = $this->calcMarkBologna($total, $score);                                                         //оценки
        $mark_rus = $this->calcMarkRus($total, $score);

        $result = new Result();
        $date = date('Y-m-d H:i:s', time());                                                                            //текущее время
        if ($test_type != 'Тренировочный'){                                                                             //если тест контрольный
            $result->whereId_result($current_test)->update(['result_date' => $date, 'result' => $score, 'mark_ru' => $mark_rus, 'mark_eu' => $mark_bologna]);
            return view('tests.ctrresults', compact('score', 'mark_bologna', 'mark_rus'));
        }
        else{                                                                                                           //если тест тренировочный
            $amount = $query->amount;

            $widgets = [];
            $query = $result->whereId_result($current_test)->first();                                                   //берем сохраненный тест из БД
            $saved_test = $query->saved_test;
            $saved_test = unserialize($saved_test);

            for ($i=0; $i<$amount; $i++){
                $widgets[] = View::make($saved_test[$i]['view'].'T', $saved_test[$i]['arguments'])->with('choice', $choice[$i+1]);
            }
            $result->whereId_result($current_test)->update(['result_date' => $date, 'result' => $score, 'mark_ru' => $mark_rus, 'mark_eu' => $mark_bologna]);
            $widgetListView = View::make('questions.student.training_test',compact('score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent', 'link_to_lecture'))->with('widgets', $widgets);
            return $widgetListView;
        }
    }

    /** Пользователь отказался от прохождения теста */
    public function dropTest(){
        if (Session::has('test')){
            $id_result = Session::get('test');
            $date = date('Y-m-d H:i:s', time());
            Session::forget('test');
            Session::forget('end_time');
            Result::whereId_result($id_result)->update(['result_date' => $date, 'result' => -1, 'mark_ru' => -1, 'mark_eu' => 'drop']);                                 //Присваиваем результату и оценке значения -1
        }
        return redirect('tests');
    }
}