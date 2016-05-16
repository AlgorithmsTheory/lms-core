<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */
namespace App\Http\Controllers;
use App\Testing\Fine;
use App\Testing\Result;
use App\Testing\Section;
use App\Testing\StructuralRecord;
use App\Testing\Test;
use App\Testing\TestStructure;
use App\Testing\Theme;
use App\Testing\Type;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Testing\Question;
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
        $types = [];
        $sections = [];
        $query = Type::select('type_name')->get();                                                                      //формируем массив типов
        foreach ($query as $type){
            array_push($types,$type->type_name);
        }
        $query = Section::select('section_name')->get();                                                                //формируем массив разделов
        foreach ($query as $section){
            array_push($sections, $section->section_name);
        }
        return view('tests.create', compact('types', 'sections'));
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
        Test::insert(array('test_name' => $request->input('test-name'), 'test_type' => $test_type,
            'test_time' => $test_time,
            'start' => $start, 'end' => $end, 'total' => $total));
        $id_test = Test::max('id_test');
        for ($i=0; $i<=$request->input('num-rows'); $i++){
            if ($request->input('section')[$i] != 'Любой')
                $section = Section::whereSection_name($request->input('section')[$i])->select('section_code')->first()->section_code;
            else $section = 'Любой';
            if ($request->input('theme')[$i] != 'Любая')
                $theme = Theme::whereTheme_name($request->input('theme')[$i])->select('theme_code')->first()->theme_code;
            else $theme = 'Любая';
            if ($request->input('type')[$i] != 'Любой')
                $type = Type::whereType_name($request->input('type')[$i])->select('type_code')->first()->type_code;
            else $type = 'Любой';
            $amount = $request->input('num')[$i];
            TestStructure::add($id_test, $amount, $section, $theme, $type);
        }
        return redirect()->route('test_create');
    }

    /** Список всех тестов для их редактирования и завершения */
    public function editList(){
        $current_date = date("Y-m-d H:i:s");                                                                            //текущая дата в mySlq формате DATETIME
        $current_ctr_tests = $this->test->whereTest_type('Контрольный')                                                         //формируем текущие тесты
                    ->where('start', '<', $current_date)
                    ->where('end', '>', $current_date)
                    ->select()
                    ->get();
        foreach ($current_ctr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        $current_tr_tests = $this->test->whereTest_type('Тренировочный')
                    ->where('start', '<', $current_date)
                    ->where('end', '>', $current_date)
                    ->select()
                    ->get();
        foreach ($current_tr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        $past_ctr_tests = $this->test->whereTest_type('Контрольный')                                                         //формируем прошлые тесты
            ->where('end', '<', $current_date)
            ->select()
            ->get();
        foreach ($past_ctr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
            if (Test::isFinished($test->id_test))                                                               //если таких студентов нет, то такой тест завршить нельзя
                $test['finish_opportunity'] = 0;
            else                                                                                                        //иначе можно
                $test['finish_opportunity'] = 1;
        }

        $past_tr_tests = $this->test->whereTest_type('Тренировочный')
            ->where('end', '<', $current_date)
            ->select()
            ->get();
        foreach ($past_tr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        $future_ctr_tests = $this->test->whereTest_type('Контрольный')                                                         //формируем будущие тесты
            ->where('start', '>', $current_date)
            ->select()
            ->get();
        foreach ($future_ctr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        $future_tr_tests = $this->test->whereTest_type('Тренировочный')
            ->where('start', '>', $current_date)
            ->select()
            ->get();
        foreach ($future_tr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        return view ('personal_account.test_list', compact('current_ctr_tests', 'current_tr_tests', 'past_ctr_tests', 'past_tr_tests', 'future_ctr_tests', 'future_tr_tests'));
    }

    /** Редактирование выбранного теста */
    public function edit($id_test){
        $test = Test::whereId_test($id_test)->first();
        $sections = Section::where('section_code', '>', '0')->get();
        $types = Type::where('type_code', '>', '0')->get();
        $test['time_zone'] = Test::getTimeZone($id_test);

        $number_of_sections = Section::where('section_code', '>', '0')->count();                                        //число разделов
        $number_of_types = Type::where('type_code', '>', '0')->count();                                                 //число типов
        $structures = TestStructure::whereId_test($id_test)->get();
        foreach ($structures as $structure){
            if (StructuralRecord::whereId_structure($structure['id_structure'])->distinct()->select('section_code')
                                    ->count('section_code') == $number_of_sections) {
                $structure['section'] = 'Любой';
                $structure['theme'] = 'Любая';
                $structure['themes'] = [];
            }
            else {
               $structure['section'] = StructuralRecord::whereId_structure($structure['id_structure'])
                                       ->join('sections', 'structural_records.section_code', '=', 'sections.section_code')
                                       ->select('section_name')->first()->section_name;

                $section_code = StructuralRecord::whereId_structure($structure['id_structure'])                                  //число тем данного раздела
                                    ->select('section_code')->first()->section_code;
                $number_of_themes = Theme::whereSection_code($section_code)->select()->count();
                if (StructuralRecord::whereId_structure($structure['id_structure'])->distinct()->select('theme_code')
                                        ->count('theme_code') == $number_of_themes){
                    $structure['theme'] = 'Любая';
                    $structure['themes'] = [];
                }
                else {
                    $structure['theme'] = StructuralRecord::whereId_structure($structure['id_structure'])
                        ->join('themes', 'structural_records.theme_code', '=', 'themes.theme_code')
                        ->select('theme_name')->first()->theme_name;
                    $structure['themes'] = Theme::whereSection_code($section_code)->select('theme_name')->get();
                }
            }

            if (StructuralRecord::whereId_structure($structure['id_structure'])->distinct()->select('type_code')
                                    ->count('type_code') == $number_of_types)
                $structure['type'] = 'Любой';
            else
                $structure['type'] = StructuralRecord::whereId_structure($structure['id_structure'])
                    ->join('types', 'structural_records.type_code', '=', 'types.type_code')
                    ->select('type_name')->first()->type_name;
            $structure['db-amount'] = Question::getAmount($structure['section'], $structure['theme'],                      //число вопросов в БД заданной структуры
                                    $structure['type'], $test->test_type);
        }
        return view ('tests.edit', compact('test', 'sections', 'types', 'structures'));
    }

    /** Применение изменений после редактирования теста */
    public function update(Request $request){
        if ($request->input('training')) {
            $test_type = 'Тренировочный';
        }
        else $test_type = 'Контрольный';
        $total = $request->input('total');
        $test_time = $request->input('test-time');
        $start = $request->input('start-date').' '.$request->input('start-time');
        $end = $request->input('end-date').' '.$request->input('end-time');
        Test::whereId_test($request->input('id-test'))->update(array('test_name' => $request->input('test-name'), 'test_type' => $test_type,
            'test_time' => $test_time,
            'start' => $start, 'end' => $end, 'total' => $total));

        $id_test = $request->input('id-test');                                                                          //удаляем старые записи и структуры
        $old_structures = TestStructure::whereId_test($id_test)->get();
        foreach ($old_structures as $structure){
            StructuralRecord::whereId_structure($structure['id_structure'])->delete();
        }
        TestStructure::whereId_test($id_test)->delete();

        for ($i=0; $i<=$request->input('num-rows'); $i++){
            if ($request->input('section')[$i] != 'Любой')
                $section = Section::whereSection_name($request->input('section')[$i])->select('section_code')->first()->section_code;
            else $section = 'Любой';
            if ($request->input('theme')[$i] != 'Любая')
                $theme = Theme::whereTheme_name($request->input('theme')[$i])->select('theme_code')->first()->theme_code;
            else $theme = 'Любая';
            if ($request->input('type')[$i] != 'Любой')
                $type = Type::whereType_name($request->input('type')[$i])->select('type_code')->first()->type_code;
            else $type = 'Любой';
            $amount = $request->input('num')[$i];
            TestStructure::add($id_test, $amount, $section, $theme, $type);
        }
        return redirect()->route('tests_list');
    }

    public function remove($id_test){
        $structures = TestStructure::whereId_test($id_test)->get();
        foreach ($structures as $structure){
            StructuralRecord::whereId_structure($structure['id_structure'])->delete();
        }
        TestStructure::whereId_test($id_test)->delete();
        Test::whereId_test($id_test)->delete();
        return redirect()->route('tests_list');
    }

    /** AJAX-метод: получает список тем раздела */
    public function getTheme(Request $request){
        if ($request->ajax()) {
            $themes_list = [];
            $section = $request->input('choice');
            $section_code = Section::whereSection_name($section)->first()->section_code;
            $query = Theme::whereSection_code($section_code)->select('theme_name')->get();
            foreach ($query as $str){
                array_push($themes_list,$str->theme_name);
            }
            return (String) view('tests.getTheme', compact('themes_list'));
        }
    }

    /** AJAX-метод: по названию раздела, темы и типа вычисляет количество доступных вопросов в БД данной структуры */
    public function getAmount(Request $request){
        if ($request->ajax()) {
            if ($request->input('training')) {
                $test_type = 'Тренировочный';
            }
            else $test_type = 'Контрольный';
            $amount = Question::getAmount($request->input('section'), $request->input('theme'), $request->input('type'), $test_type);
            return (String) $amount;
        }
    }

    /** Главный метод: гененрирует полотно вопросов на странице тестов */
    public function showViews($id_test){
        $result = new Result();
        $user = new User();
        $question = new Question();
        $widgets = [];
        $saved_test = [];
        $current_date = date('U');

        $query = $this->test->whereId_test($id_test)->select('test_name', 'test_time', 'start', 'end', 'test_type')->first();
        if ($current_date < strtotime($query->start) || $current_date > strtotime($query->end)){                          //проверка открыт ли тест
            return view('no_access');
        }
        $amount = $this->test->getAmount($id_test);
        $test_time = $query->test_time;
        $test_type = $query->test_type;

        if (!Session::has('test')){                                                                                     //если в тест зайдено первый раз
            $ser_array = $this->test->prepareTest($id_test);
            //dd($ser_array);
            for ($i=0; $i<$amount; $i++){
                $id = $question->chooseQuestion($ser_array);
                if (!$this->test->rybaTest($id)){                                                                       //проверка на вопрос по рыбе
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
            $result->id = $query2->id;;
            $result->id_test = $id_test;
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

        $query = $this->test->whereId_test($id_test)->select('total', 'test_name', 'test_type')->first();
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
        //TODO: учесть коэффициент штрафа

        $mark_bologna = $this->test->calcMarkBologna($total, $score);                                                         //оценки
        $mark_rus = $this->test->calcMarkRus($total, $score);

        $result = new Result();
        $date = date('Y-m-d H:i:s', time());                                                                            //текущее время
                                                                                                                        //если тест тренировочный
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