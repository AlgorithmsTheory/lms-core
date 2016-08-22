<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */
namespace App\Http\Controllers;
use App\Protocols\TestProtocol;
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
        $tr_tests = [];                                                                                                 //массив тренировочных тестов
        $ctr_tests = [];                                                                                                //массив контрольных тестов
        $current_date = date('U');
        $query = $this->test->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина' && $test->visibility == 1 && $test->year == date("Y")) {                 //проверка, что тест не из Рыбинских, он видим и он текущего года
                if ($test->test_type == 'Тренировочный'){
                    array_push($tr_tests, $test);
                }
                else {
                    array_push($ctr_tests, $test);
                    $test['max_points'] = Fine::levelToPercent(Fine::whereId(Auth::user()['id'])->whereId_test($test['id_test'])->select('fine')->first()->fine)/100 * $test['total'];

                }
                if ($current_date >= strtotime($test->start) && $current_date <= strtotime($test->end))                 //разделение на текущие и недоступные
                    $test['current'] = 1;
                else
                    $test['current'] = 0;
            }
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        if ($role == '' || $role == 'Обычный'){                                                                         // Обычным пользователям не доступны контрольные тесты
            return view('tests.index', compact('tr_tests'));
        }
        else
            return view('tests.index', compact('tr_tests', 'ctr_tests'));
    }

    /** генерирует страницу создания нового теста */
    public function create(){
        $types = [];
        $sections = [];
        $query = Type::where('type_code', '<', 10)->select('type_name')->get();                                                                      //формируем массив типов
        foreach ($query as $type){
            array_push($types,$type->type_name);
        }
        $query = Section::where('section_code', '<', 5)->where('section_code', '>', 0)->select('section_name')->get();                                                                //формируем массив разделов
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
            'start' => $start, 'end' => $end, 'total' => $total, 'year' => 2016, 'visibility' => 1));
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
        $current_ctr_tests = $this->test->whereTest_type('Контрольный')                                                 //формируем текущие тесты
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
            if (Test::isFinished($test->id_test))                                                                       //если таких студентов нет, то такой тест завршить нельзя
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
        Result::whereId_test($id_test)->delete();
        Fine::whereId_test($id_test)->delete();
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

    /** В фоновом режиме создание протокола по контрольному тесту */
    public function getProtocol(Request $request){
        if ($request->ajax()) {
            $protocol = new TestProtocol($request->input('id_test'), $request->input('id_user'), $request->input('html_text'));
            $protocol->create();
            return;
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

        $query = $this->test->whereId_test($id_test)->first();
        if ($current_date < strtotime($query->start) || $current_date > strtotime($query->end) || $query->year != date("Y")){                        //проверка открыт ли тест
            $message = 'Тест не открыт в настоящий момент';
            return view('no_access', compact('message'));
        }
        if ($query->visibility == 0){
            $message = 'Тест не доступен в данный момент';
            return view('no_access', compact('message'));
        }
        $amount = $this->test->getAmount($id_test);
        $test_time = $query->test_time;
        $test_type = $query->test_type;
        if (!Session::has('test')){                                                                                     //если в тест зайдено первый раз
            $ser_array = $this->test->prepareTest($id_test);
            for ($i=0; $i<$amount; $i++){
                $id = $question->chooseQuestion($ser_array);
                if (!$this->test->rybaTest($id)){                                                                       //проверка на вопрос по рыбе
                    $message = 'Тест не предназначен для общего пользования';
                    return view('no_access', $message);
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
        //dd('1');
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

        $id_user = Result::whereId_result($current_test)
                        ->join('users', 'results.id', '=', 'users.id')->select('users.id')->first()->id;

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
            $widgetListView = View::make('tests.ctrresults',compact('total','score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent', 'id_test', 'id_user'))->with('widgets', $widgets);
            $fine = new Fine();
            $fine->updateFine(Auth::user()['id'], $id_test, $mark_rus);                                                 //вносим в таблицу штрафов необходимую инфу
            Test::addToStatements($id_test, $id_user, $score);                                        //занесение балла в ведомость
        }
        else {                                                                                                          //тест тренировочный
            $widgetListView = View::make('questions.student.training_test',compact('score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent', 'link_to_lecture'))->with('widgets', $widgets);
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