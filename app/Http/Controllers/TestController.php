<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */
namespace App\Http\Controllers;
use App\Fine;
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

    /** Список всех тестов для их редактирования и завершения */
    public function editList(){
        $current_ctr_tests = [];
        $current_tr_tests = [];
        $past_ctr_tests = [];
        $past_tr_tests = [];
        $future_ctr_tests = [];
        $future_tr_tests = [];

        $current_date = date("Y-m-d H:i:s");                                                                            //текущая дата в mySlq формате DATETIME
        $query_ctr = $this->test->whereTest_type('Контрольный')                                                         //формируем текущие тесты
                    ->where('start', '<', $current_date)
                    ->where('end', '>', $current_date)
                    ->select()
                    ->get();
        foreach ($query_ctr as $control_test){
            array_push($current_ctr_tests, $control_test);
        }
        $query_tr = $this->test->whereTest_type('Тренировочный')
                    ->where('start', '<', $current_date)
                    ->where('end', '>', $current_date)
                    ->select()
                    ->get();
        foreach ($query_tr as $training_test){
            array_push($current_tr_tests, $training_test);
        }
        $query_ctr = $this->test->whereTest_type('Контрольный')                                                         //формируем прошлые тесты
            ->where('start', '>', $current_date)
            ->select()
            ->get();
        foreach ($query_ctr as $control_test){
            array_push($past_ctr_tests, $control_test);
        }
        $query_tr = $this->test->whereTest_type('Тренировочный')
            ->where('start', '>', $current_date)
            ->select()
            ->get();
        foreach ($query_tr as $training_test){
            array_push($past_tr_tests, $training_test);
        }
        $query_ctr = $this->test->whereTest_type('Контрольный')                                                         //формируем будущие тесты
            ->where('end', '<', $current_date)
            ->select()
            ->get();
        foreach ($query_ctr as $control_test){
            array_push($future_ctr_tests, $control_test);
        }
        $query_tr = $this->test->whereTest_type('Тренировочный')
            ->where('end', '<', $current_date)
            ->select()
            ->get();
        foreach ($query_tr as $training_test){
            array_push($future_tr_tests, $training_test);
        }
        return view ('personal_account.test_list', compact('current_ctr_tests', 'current_tr_tests', 'past_ctr_tests', 'past_tr_tests', 'future_ctr_tests', 'future_tr_tests'));
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
            $code = $this->test->struct('',$request->input('section'),$request->input('theme'),$request->input('type'));
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
            $structure .= $this->test->struct($request->input('num')[$i],$request->input('section')[$i],$request->input('theme')[$i],$request->input('type')[$i]).';';
            $amount += $request->input('num')[$i];
        }
        $structure .= $this->test->struct($request->input('num')[$request->input('num-rows')],$request->input('section')[$request->input('num-rows')],$request->input('theme')[$request->input('num-rows')],$request->input('type')[$request->input('num-rows')]);
        $amount += $request->input('num')[$request->input('num-rows')];
        Test::insert(array('test_name' => $request->input('test-name'), 'test_type' => $test_type, 'amount' => $amount, 'test_time' => $test_time, 'start' => $start, 'end' => $end, 'structure' => $structure, 'total' => $total));

        return redirect()->route('test_create');
    }

    /** Главный метод: гененрирует полотно вопросов на странице тестов */
    public function showViews($id_test){
        $result = new Result();
        $user = new User();
        $question = new Question();
        $widgets = [];
        $saved_test = [];
        $current_date = date('U');

        $query = $this->test->whereId_test($id_test)->select('amount', 'test_name', 'test_time', 'start', 'end', 'test_type')->first();
        if ($current_date < strtotime($query->start) || $current_date > strtotime($query->end)){                          //проверка открыт ли тест
            return view('no_access');
        }
        $amount = $query->amount;                                                                                       //кол-во вопрососв в тесте
        $result->test_name = $query->test_name;
        $test_time = $query->test_time;
        $test_type = $query->test_type;

        if (!Session::has('test')){                                                                                     //если в тест зайдено первый раз
            $ser_array = $this->test->prepareTest($id_test);
            for ($i=0; $i<$amount; $i++){
                $id = $question->chooseQuestion($ser_array);
                if (!$this->test->rybaTest($id)){                                                                  //проверка на вопрос по рыбе
                    return view('no_access');
                };
                $data = $question->show($id, $i+1);                                                                     //должны получать название view и необходимые параметры
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
        $score_sum = 0;                                                                                                 //сумма набранных баллов
        $points_sum = 0;                                                                                                //сумма максимально овзможных баллов
        $choice = [];                                                                                                   //запоминаем выбранные варианты пользователя
        $right_percent = [];                                                                                            //Процент правильности ответа на неверный вопрос
        $j = 1;
        $question = new Question();

        $query = $this->test->whereId_test($id_test)->select('total', 'test_name', 'amount', 'test_type')->first();
        $total = $query->total;
        $test_type = $query->test_type;
        for ($i=0; $i<$amount; $i++){                                                                                   //обрабатываем каждый вопрос
            $data = $request->input($i);
            $array = json_decode($data);
            $link_to_lecture[$j] = $question->linkToLecture($array[0]);
            $data = $question->check($array);
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

        $mark_bologna = $this->test->calcMarkBologna($total, $score);                                                         //оценки
        $mark_rus = $this->test->calcMarkRus($total, $score);

        $result = new Result();
        $date = date('Y-m-d H:i:s', time());                                                                            //текущее время
                                                                                                                        //если тест тренировочный
        $amount = $query->amount;
        $widgets = [];
        $query = $result->whereId_result($current_test)->first();                                                       //берем сохраненный тест из БД
        $saved_test = $query->saved_test;
        $saved_test = unserialize($saved_test);

        for ($i=0; $i<$amount; $i++){
            $widgets[] = View::make($saved_test[$i]['view'].'T', $saved_test[$i]['arguments'])->with('choice', $choice[$i+1]);
        }

        if ($test_type != 'Тренировочный'){                                                                             //тест контрольный
            $widgetListView = View::make('tests.ctrresults',compact('score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent'))->with('widgets', $widgets);
            $fine = new Fine();
            $fine->updateFine(Auth::user()['id'], $id_test, $mark_rus);                                                 //вносим в таблицу штрафов необходимую инфу
        }
        else {                                                                                                          //тест тренировочный
            $widgetListView = View::make('questions.student.training_test',compact('score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent', 'link_to_lecture'))->with('widgets', $widgets);
            //TODO: Генерация протокола по странице результата контрольного теста. Скорее всего нажать кнопку "Создать протокол и выйти". Проблема возникает с тем, что можно просто перейти на другой адрес. Поэтому стоит это дело запретить?
        }
        $result->whereId_result($current_test)->update(['result_date' => $date, 'result' => $score, 'mark_ru' => $mark_rus, 'mark_eu' => $mark_bologna]);
        return $widgetListView;
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