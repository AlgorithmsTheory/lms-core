<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */
namespace App\Http\Controllers;
use App\Group;
use App\Protocols\TestProtocol;
use App\Testing\Fine;
use App\Testing\Result;
use App\Testing\Section;
use App\Testing\StructuralRecord;
use App\Testing\Test;
use App\Testing\TestForGroup;
use App\Testing\TestGeneration\RecordNode;
use App\Testing\TestGeneration\TestGenerator;
use App\Testing\TestGeneration\UsualTestGenerator;
use App\Testing\TestStructure;
use App\Testing\TestTask;
use App\Testing\Theme;
use App\Testing\Type;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Testing\Question;
use Illuminate\Http\Response;
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
        $query = $this->test->whereVisibility(1)->whereArchived(0)
                            ->whereOnly_for_print(0)
                            ->get();
        foreach ($query as $test){
            $availability_for_group = TestForGroup::whereId_group(Auth::user()['group'])
                                    ->whereId_test($test['id_test'])
                                    ->select('availability')->first()->availability;
            $test['access_for_group'] = $availability_for_group;
            if ($test->test_type == 'Тренировочный') {
                $test['access_for_student'] = 1;
                array_push($tr_tests, $test);
            }
            else {
                array_push($ctr_tests, $test);
                $test['access_for_student'] = 0; //TODO: Вычислить
                $test['max_points'] = Fine::levelToPercent(Fine::whereId(Auth::user()['id'])->whereId_test($test['id_test'])->select('fine')->first()->fine)/100 * $test['total'];
            }
            $test['amount'] = Test::getAmount($test['id_test']);
        }


        //TODO: student's group must be not archived to be able to see control tests
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        if ($role == '' || $role == 'Обычный')                                                                          // Обычным пользователям не доступны контрольные тесты
            return view('tests.index', compact('tr_tests'));
        else
            return view('tests.index', compact('tr_tests', 'ctr_tests'));
    }

    /** генерирует страницу создания нового теста (шаг 1 - основные настройки) */
    public function create(){
        //TODO: get values if session exists
        $groups = Group::all();
        return view('tests.create', compact('groups'));
    }

    public function finishFstCreationStep(Request $request) {
        $general_settings = [];
        $test_for_groups = [];

        $general_settings['test_name'] = $request->input('test-name');
        $general_settings['test_type'] = $request->input('training') ? 'Тренировочный' : 'Контрольный';
        $general_settings['visibility'] = $request->input('visibility') ? 1 : 0;
        $general_settings['multilanguage'] = $request->input('multilanguage') ? 1 : 0;
        $general_settings['only_for_print'] = $request->input('only-for-print') ? 1 : 0;
        $general_settings['total'] = $request->input('total');
        $general_settings['test_time'] = $request->input('test-time');

        $availability_input = ($request->input('availability') == null) ? [] : $request->input('availability');

        for ($i = 0; $i < count($request->input('id-group')); $i++) {
            $availability = in_array($request->input('id-group')[$i], $availability_input) ? 1 : 0;
            $test_for_groups[$request->input('id-group')[$i]] = $availability;
        }

        $request->session()->put('general_settings', $general_settings);
        $request->session()->put('test_for_groups', $test_for_groups);

        return redirect()->route('test_create_step2');
    }

    /** генерирует страницу создания нового теста (шаг 2 - создание структур) */
    public function createSndStep(Request $request) {
        $general_settings = $request->session()->get('general_settings');
        $sections = [];
        $sections_db = Section::where('section_code', '<', 10)->where('section_code', '>', 0)->select('section_code', 'section_name')->get();
        for ($i=0; $i < sizeof($sections_db); $i++) {
            $sections[$i]['name'] = $sections_db[$i]->section_name;
            $sections[$i]['code'] = $sections_db[$i]->section_code;
            $themes_in_section = Theme::whereSection_code($sections_db[$i]->section_code)->select('theme_name', 'theme_code')->get();
            for ($j=0; $j < count($themes_in_section); $j++) {
                $sections[$i]['themes'][$j] = $themes_in_section[$j];
            }
        }

        if ($general_settings['only_for_print']) {
            $types = Type::all();
        }
        else {
            $types = Type::whereOnly_for_print(0)->get();
        }

        $json_sections = json_encode($sections);
        $json_types = json_encode($types);
        $general_settings = json_encode($general_settings);
        return view('tests.create2',compact('general_settings', 'sections', 'types', 'json_sections', 'json_types'));
    }

    public function validateTestStructure(Request $request) {
        $restrictions = [];
        $restrictions['test'] = json_decode($request->input('form')['general-settings']);
        $number_of_structures = count($request->input('form')['sections']);

        for ($i = 0; $i < $number_of_structures; $i++) {
            $restrictions['structures'][$i]['id_structure'] = $i;
            $restrictions['structures'][$i]['amount'] = $request->input('form')['number-of-questions'][$i];
            for ($j = 0; $j < count($request->input('form')['sections'][$i]); $j++) {
                $restrictions['structures'][$i]['sections'][$j]['section_code'] = $request->input('form')['sections'][$i][$j];
                $theme_index = $this->getSectionOrderForThemes($request->input('form')['themes'], $restrictions['structures'][$i]['sections'][$j]['section_code'], $i);
                for ($k = 0; $k < count($request->input('form')['themes'][$i][$theme_index]); $k++) {
                    $restrictions['structures'][$i]['sections'][$j]['themes'][$k]['theme_code'] = $request->input('form')['themes'][$i][$theme_index][$k];
                }
            }
            for ($j = 0; $j < count($request->input('form')['types'][$i]); $j++) {
                $restrictions['structures'][$i]['types'][$j]['type_code'] = $request->input('form')['types'][$i][$j];
            }
        }

        $testGenerator = new UsualTestGenerator();
        $testGenerator->buildGraphFromRestrictions($restrictions);
        $testGenerator->getGraph()->fordFulkersonMaxFlow();
        return (String) $testGenerator->getGraph()->isSaturated();
    }

    private function getSectionOrderForThemes($themes, $section_code, $i) {
        $themes_in_db = Theme::whereSection_code($section_code)->select('theme_code')->get();
        $number_of_sections_in_db = Section::where('section_code', '>', 0)->count();
        for ($l = 0; $l < $number_of_sections_in_db; $l++) {
            for ($n = 0; $n < count($themes[$i][$l]); $n++) {
                foreach ($themes_in_db as $theme_in_db) {
                    if ($theme_in_db->theme_code == $themes[$i][$l][$n]) {
                        return $l;
                    }
                }
            }
        }
        throw new \Exception("Restrictions are invalid!");
    }

    /** Добавляет новый тест в БД */
    public function add(Request $request){
        $general_settings = $request->session()->get('general_settings');
        Test::insert(array(
            'test_name' => $general_settings['test_name'],
            'test_type' => $general_settings['test_type'],
            'test_time' => $general_settings['test_time'],
            'total' => $general_settings['total'],
            'visibility' => $general_settings['visibility'],
            'multilanguage' => $general_settings['multilanguage'],
            'only_for_print' => $general_settings['only_for_print']
        ));

        $id_test = Test::max('id_test');
        $request->session()->get('test_for_groups');
        foreach ($request->session()->get('test_for_groups') as $group_id => $availability) {
            TestForGroup::insert(['id_test' => $id_test, 'id_group' => $group_id, 'availability' => $availability]);
        }

        for ($i = 0; $i < count($request->input('sections')); $i++) {
            $id_structure = TestStructure::max('id_structure') + 1;
            TestStructure::insert(array('id_structure' => $id_structure, 'id_test' => $id_test, 'amount' => $request->input('number-of-questions')[$i]));
            for ($j = 0; $j < count($request->input('sections')[$i]); $j++) {
                $restrictions['structures'][$i]['sections'][$j]['section_code'] = $request->input('sections')[$i][$j];
                $theme_index = $this->getSectionOrderForThemes($request->input('themes'), $request->input('sections')[$i][$j], $i);
                for ($k = 0; $k < count($request->input('themes')[$i][$theme_index]); $k++) {
                    for ($l = 0; $l < count($request->input('types')[$i]); $l++) {
                        StructuralRecord::insert(array(
                            'theme_code' => $request->input('themes')[$i][$theme_index][$k],
                            'section_code' => $request->input('sections')[$i][$j],
                            'type_code' => $request->input('types')[$i][$l],
                            'id_test' => $id_test,
                            'id_structure' => $id_structure
                        ));
                    }
                }
            }
        }
        //TODO: flush session
        return redirect()->route('test_create');
    }

    /** Список всех тестов для их редактирования и завершения */
    public function editList(){
        $ctr_tests = $this->test->whereTest_type('Контрольный')
            ->where('archived', '<>', '1')
            ->select()
            ->get();
        foreach ($ctr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
            //TODO: process finish opportunity
//            if (Test::isFinishedForGroup($test->id_test, $id_group))
//                $test['finish_opportunity'] = 0;
//            else
//                $test['finish_opportunity'] = 1;
        }

        $tr_tests = $this->test->whereTest_type('Тренировочный')
            ->where('archived', '<>', '1')
            ->select()
            ->get();
        foreach ($tr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
        }

        return view ('personal_account.test_list', compact('ctr_tests', 'tr_tests'));
    }

    /** Редактирование выбранного теста */
    public function edit($id_test){
        $test = Test::whereId_test($id_test)->first();
        $test['is_resolved'] = Test::isResolved($id_test);
        $test_for_groups = TestForGroup::whereId_test($test->id_test)->get();
        foreach ($test_for_groups as $test_for_group) {
            $test_for_group['group_name'] = Group::whereGroup_id($test_for_group['id_group'])->select('group_name')->first()->group_name;
        }
        return view ('tests.edit', compact('test',  'test_for_groups'));
    }

    /** Применение изменений после редактирования теста */
    public function update(Request $request){
        $id_test = $request->input('id-test');
        $test_name = $request->input('test-name');
        $test_type = $request->input('test-type');
        $visibility = $request->input('visibility') ? 1 : 0;
        $multilanguage = $request->input('multilanguage') ? 1 : 0;
        $only_for_print = $request->input('only-for-print') ? 1 : 0;
        $total = $request->input('total');
        $test_time = $request->input('test-time');

        Test::whereId_test($id_test)->update([
            'test_name' => $test_name, 'test_type' => $test_type, 'test_time' => $test_time,
            'total' => $total,'visibility' => $visibility, 'archived' => 0,
            'multilanguage' => $multilanguage, 'only_for_print' => $only_for_print]);

        $availability_input = ($request->input('availability') == null) ? [] : $request->input('availability');

        for ($i = 0; $i < count($request->input('id-group')); $i++) {
            $availability = in_array($request->input('id-group')[$i], $availability_input) ? 1 : 0;
            TestForGroup::whereId_test($id_test)
                ->whereId_group($request->input('id-group')[$i])
                ->update(['id_test' => $id_test, 'id_group' => $request->input('id-group')[$i], 'availability' => $availability]);
        }

        if ($request->input('go-to-edit-structure')) {
            //TODO: edit test's structure
            return redirect()->route('in_process');
        }
        else {
            return redirect()->route('tests_list');
        }
    }

    /** Завершает выбранный тест для всех учебных групп */
    public function finishTest($id_test) {
        Test::finishTest($id_test);
        return redirect()->route('test_edit', $id_test);
    }

    /** полное удаление, если никто не проходил его, пометка как архивный в противном случае */
    public function remove($id_test){
        if (!Test::isResolved($id_test)){
            $structures = TestStructure::whereId_test($id_test)->get();
            foreach ($structures as $structure){
                StructuralRecord::whereId_structure($structure['id_structure'])->delete();
            }
            TestStructure::whereId_test($id_test)->delete();
            Test::whereId_test($id_test)->delete();
        }
        else {
            Test::whereId_test($id_test)->update(['archived' => 1]);
        }
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

    /** AJAX-метод: по названию раздела, темы, типа, типа теста, возможности печати вычисляет количество доступных вопросов в БД данной структуры */
    public function getAmount(Request $request){
        if ($request->ajax()) {
            if ($request->input('training')) {
                $test_type = 'Тренировочный';
            }
            else $test_type = 'Контрольный';
            if ($request->input('printable')) {
                $printable = 1;
            }
            else $printable = 0;
            $amount = Question::getAmount($request->input('section'), $request->input('theme'), $request->input('type'), $request->input('test_type'), $printable);
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
        date_default_timezone_set('Europe/Moscow');
        $result = new Result();
        $user = new User();
        $question = new Question();
        $widgets = [];
        $saved_test = [];
        $current_date = date('U');

        $test = $this->test->whereId_test($id_test)->first();
        $id_group = Auth::user()['group'];
        $availability = TestForGroup::whereId_group($id_group)->whereId_test($id_test)->select('availability')->first()->availability;
        if ($availability != 1 || $test->year != date("Y") || $test->visibility == 0){                               //проверка открыт ли тест
            $message = 'Тест не открыт в настоящий момент';
            return view('no_access', compact('message'));
        }
        $amount = $this->test->getAmount($id_test);
        $test_time = $test->test_time;
        $test_type = $test->test_type;
        if (Result::getCurrentResult(Auth::user()['id'], $id_test) == -1) {                                             //если пользователь не имеет начатый тест                                                                                     //если в тест зайдено первый раз
            $generator = new UsualTestGenerator();
            $generator->buildGraphFromTest($test);
            $generator->generate();
            for ($i=0; $i < $amount; $i++) {
                $id = $generator->chooseQuestion();
                if (!$this->test->rybaTest($id)){                                                                       //проверка на вопрос по рыбе
                    $message = 'Тест не предназначен для общего пользования';
                    return view('no_access', $message);
                };
                $data = $question->show($id, $i+1);                                                                     //должны получать название view и необходимые параметры
                $saved_test[] = $data;
                $widgets[] = View::make($data['view'], $data['arguments']);
            }

            $int_end_time =  date('U') + 60*$test_time;                                                                 //время конца
            $test = Result::max('id_result');                                                                          //пример использования агрегатных функций!!!
            $current_result = $test+1;                                                                                 //создаем строку в таблице пройденных тестов
            $query2 = $user->whereEmail(Auth::user()['email'])->select('id')->first();
            $result->id_result = $current_result;
            $result->id = $query2->id;;
            $result->id_test = $id_test;
            $result->result_date = date('Y-m-d H:i:s', $int_end_time);
            $saved_test = serialize($saved_test);
            $result->saved_test = $saved_test;
            $result->save();
        }
        else {                                                                                                          //если была перезагружена страница теста или тест был покинут
			$current_test = Result::getCurrentResult(Auth::user()['id'], $id_test);
            $test = $result->whereId_result($current_test)->first();
            $int_end_time = strtotime($test->result_date);                                                              //время окончания теста
            $saved_test = $test->saved_test;
            $saved_test = unserialize($saved_test);
            for ($i=0; $i<$amount; $i++){
                $widgets[] = View::make($saved_test[$i]['view'], $saved_test[$i]['arguments']);
            }
        }

        $current_time = date_create();                                                                                  //текущее время
        $int_left_time = $int_end_time - date_format($current_time, 'U');                                               //оставшееся время
        $left_min =  floor($int_left_time/60);                                                                          //осталось минут
        $left_sec = $int_left_time % 60;                                                                                //осталось секунд

        $widgetListView = View::make('questions.student.widget_list',compact('current_result', 'amount', 'id_test','left_min', 'left_sec', 'test_type'))->with('widgets', $widgets);
        $response = new Response($widgetListView);
        return $response;
    }

    /** Проверка теста */
    public function checkTest(Request $request){   //обработать ответ на вопрос
        $id_test = $request->input('id_test');
        if (Result::getCurrentResult(Auth::user()['id'], $id_test) != -1)                                                                                       //проверяем повторность обращения к результам
            $current_test = Result::getCurrentResult(Auth::user()['id'], $id_test);                                                                       //определяем проверяемый тест
        else
            return redirect('tests');
        $amount = $request->input('amount');
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
            TestTask::insert(['points' => $data['score'], 'id_question' => $array[0], 'id_result' => $current_test]);
            $j++;
            $score_sum += $data['score'];                                                                               //сумма набранных баллов
            $points_sum += $data['points'];                                                                             //сумма максимально возможных баллов
        }
        if ($points_sum != 0){
            $score = $total*$score_sum/$points_sum;
            $score = round($score,1);
        }
        else $score = $total;

        $fine = Fine::countFactor(Fine::whereId_test($id_test)->whereId($id_user)->select('fine')->first()->fine);      //учитываем штраф, если он есть
        $score = $score * $fine;

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
            Test::addToStatements($id_test, $id_user, $score);                                                          //занесение балла в ведомость
        }
        else {                                                                                                          //тест тренировочный
            $widgetListView = View::make('questions.student.training_test',compact('total','score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent', 'link_to_lecture'))->with('widgets', $widgets);
        }
        $result->whereId_result($current_test)->update(['result_date' => $date, 'result' => $score, 'mark_ru' => $mark_rus, 'mark_eu' => $mark_bologna]);
        return $widgetListView;
    }

    /** Пользователь отказался от прохождения теста */
    public function dropTest(Request $request){
        if (Result::getCurrentResult(Auth::user()['id'], $request->input('id_test') != -1)){
            date_default_timezone_set('Europe/Moscow');
            $date = date('Y-m-d H:i:s', time());
            Result::whereId_result($request->input('id_result'))->update(['result_date' => $date, 'result' => -1, 'mark_ru' => -1, 'mark_eu' => 'drop']);                                 //Присваиваем результату и оценке значения -1
        }
        return redirect('tests');
    }
}