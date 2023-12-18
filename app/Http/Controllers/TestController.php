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
use App\Statements\Passes\ControlWorkPasses;
use App\Statements\Passes\LecturePasses;
use App\Statements\Plans\ControlWorkPlan;
use App\Statements\Plans\CoursePlan;
use App\Testing\Fine;
use App\Testing\Result;
use App\Testing\Section;
use App\Testing\StructuralRecord;
use App\Testing\Test;
use App\Testing\TestForGroup;
use App\Testing\TestGeneration\GraphBuilder;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use View;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\ResultStatement;
use App\Statements\DAO\SectionPlanDAO;

class TestController extends Controller{
    private $test;
    private $course_plan_DAO;

    function __construct(Test $test ,CoursePlanDAO $course_plan_DAO,SectionPlanDAO $section_plan_DAO){
        $this->test=$test;
        $this->course_plan_DAO = $course_plan_DAO;
        $this->section_plan_DAO = $section_plan_DAO;
    }

    public function trainTests() {
        $tr_tests = [];
        $query = $this->test->whereTest_type('Тренировочный')
            ->whereVisibility(1)->whereArchived(0)->whereOnly_for_print(0)->get();
        foreach ($query as $test) {
            $availability_for_group = TestForGroup::whereId_group(Auth::user()['group'])
                ->whereId_test($test['id_test'])
                ->select('availability')->first()->availability;
            if ($availability_for_group) {
                $test['amount'] = Test::getAmount($test['id_test']);
                $test['attempts'] = Result::whereId_test($test['id_test'])->whereId(Auth::user()['id'])->where('mark_ru', '>=', 0)->count();
                array_push($tr_tests, $test);
            }
        }
        return view('tests.list.train_tests', compact('tr_tests'));
    }

    private $section_plan_DAO;

    public function controlTests() {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $isAdmin = $role === 'Админ' || $role === 'Преподаватель';
        $query = $this->test->whereTest_type('Контрольный')
            ->whereVisibility(1)->whereArchived(0)->whereOnly_for_print(0)->get();
        $ctr_tests = [];
        foreach ($query as $test){
            $availability_for_group = TestForGroup::whereId_group(Auth::user()['group'])
                ->whereId_test($test['id_test'])
                ->select('availability')->first()->availability;
            if ($availability_for_group/* && $us_state['all_ok'] == 1*/) {
                $fine = Fine::whereId_test($test['id_test'])->whereId(Auth::user()['id'])->select('access')->get();

                $test['access_for_student'] = (count($fine) == 0 || $isAdmin) ? 1 : $fine[0]->access;
                $test['max_points'] = Fine::levelToPercent(Fine::whereId(Auth::user()['id'])->whereId_test($test['id_test'])->select('fine')->first()->fine) / 100 * $test['total'];
                $test['amount'] = Test::getAmount($test['id_test']);
                $test['attempts'] = Result::whereId_test($test['id_test'])->whereId(Auth::user()['id'])->where('mark_ru', '>=', 0)->count();
                array_push($ctr_tests, $test);
            }
        }
        return view('tests.list.control_tests', compact('ctr_tests'));
    }

    private function testIsInExamSection($test, $examSectionsBySection) {
        foreach ($examSectionsBySection as $examSections) {
            foreach ($examSections as $examSection) {
                $controlWorkID = $examSection->id_control_work_plan;
                $controlWorkPlan = ControlWorkPlan::where('id_control_work_plan', $controlWorkID)->select('id_test')->first();
                if (empty($controlWorkPlan)) {
                    continue;
                }
                $idTest = $controlWorkPlan->id_test;
                if (empty($idTest)) {
                    continue;
                }
                if ($idTest == $test['id_test']) {
                    return true;
                }
            }
        }
        return false;
    }

    /** генерирует страницу создания нового теста (шаг 1 - основные настройки) */
    public function create(){
        $groups = Group::whereArchived(0)->get();
        return view('tests.create', compact('groups'));
    }

    public function finishFstCreationStep(Request $request) {
        $general_settings = [];
        $test_for_groups = [];

        $general_settings['test_name'] = $request->input('test-name');
        $general_settings['test_type'] = $request->input('training') ? 'Тренировочный' : 'Контрольный';
        $general_settings['adaptive'] = $request->input('adaptive') ? 1 : 0;
        $general_settings['visibility'] = $request->input('visibility') ? 1 : 0;
        $general_settings['multilanguage'] = $request->input('multilanguage') ? 1 : 0;
        $general_settings['only_for_print'] = $request->input('only-for-print') ? 1 : 0;
        $general_settings['total'] = $request->input('total');
        $general_settings['test_time'] = $request->input('test-time');
        $general_settings['max_questions'] = $request->input('max_questions');

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
        $structures_data = $request->session()->get('structures_data');
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
        return view('tests.create2', compact('general_settings', 'sections', 'types', 'json_sections', 'json_types', 'structures_data'));
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

        $graph = GraphBuilder::buildGraphFromRestrictions($restrictions);
        $graph->fordFulkersonMaxFlow();
        return (String) $graph->isSaturated();
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
            'only_for_print' => $general_settings['only_for_print'],
            'is_adaptive' => $general_settings['adaptive'],
            'max_questions' => $general_settings['max_questions']
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
        $request->session()->forget('general_settings');
        $request->session()->forget('test_for_groups');
        $request->session()->forget('structures_data');
        return redirect()->route('test_create');
    }

    /** Возвращает идентификаторы тех тестов, которые доступны хотя бы для одной неархивной группы.
     * Ответ имеет следующий вид: assoc(10 => 1, 23 => 1, 50 => 1);
     * В качестве значений могут быть только единицы, отражающие тот факт, что тест с id, указанным
     * в ключе, является "доступным".
     */
    private function getAvailableTests() {
        $available_tests = TestForGroup::query()
            ->join('groups', 'test_for_group.id_group', 'groups.group_id')
            ->where('groups.archived', '=', 0)
            ->where('test_for_group.availability', '=', 1)
            ->orderBy('test_for_group.id_test')
            ->select('test_for_group.id_test')
            ->distinct()
            ->get();
        $res = [];
        foreach ($available_tests as $test) {
            $res[$test['id_test']] = 1;
        }
        return $res;
    }

    /** Список всех тестов для их редактирования и завершения */
    public function editList(){
        $available_tests = $this->getAvailableTests();

        $ctr_tests = $this->test->whereTest_type('Контрольный')
            ->where('archived', '<>', '1')
            ->orderByDesc('id_test')
            ->select()
            ->get();
        foreach ($ctr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
            $test['at_least_one_available'] = array_key_exists($test['id_test'], $available_tests);
        }

        $tr_tests = $this->test->whereTest_type('Тренировочный')
            ->where('archived', '<>', '1')
            ->orderByDesc('id_test')
            ->select()
            ->get();
        foreach ($tr_tests as $test){
            $test['amount'] = Test::getAmount($test['id_test']);
            $test['at_least_one_available'] = array_key_exists($test['id_test'], $available_tests);
        }

        return view('personal_account.test_list', compact('ctr_tests', 'tr_tests'));
    }

    public function profile($id_test) {
        $test = Test::whereId_test($id_test)->first();
        $test['mean'] = Test::getMean($id_test);
        $test['median'] = Test::getMedian($id_test);
        $test['deviation'] = sqrt(Test::getVariance($id_test));
        $test['reliability'] = Test::getReliability($id_test);

        $structures = TestStructure::whereId_test($id_test)->select('id_structure', 'amount')->get();
        $restrictions = [];
        for ($i = 0; $i < count($structures); $i++) {
            $restrictions[$i]['amount'] = $structures[$i]->amount;
            $records = StructuralRecord::whereId_structure($structures[$i]->id_structure)->select('section_code', 'theme_code', 'type_code')->get();
            $sections = [];
            $themes = [];
            $types = [];
            foreach ($records as $record) {
                $section_name = Section::whereSection_code($record->section_code)->select('section_name')->first()->section_name;
                $theme_name = Theme::whereTheme_code($record->theme_code)->select('theme_name')->first()->theme_name;
                $type_name = Type::whereType_code($record->type_code)->select('type_name')->first()->type_name;
                if (!in_array($section_name, $sections)) array_push($sections, $section_name);
                if (!in_array($theme_name, $themes)) array_push($themes, $theme_name);
                if (!in_array($type_name, $types)) array_push($types, $type_name);
            }
            $restrictions[$i]['sections'] = $sections;
            $restrictions[$i]['themes'] = $themes;
            $restrictions[$i]['types'] = $types;

        }

        $groups = Group::whereArchived(0)->whereAcademic(1)->select('group_id', 'group_name')->get();
        return view('tests.profile', compact('test', 'restrictions', 'groups'));
    }

    public function updateSettings(Request $request) {
        Test::whereId_test($request->input('id_test'))->update([
            'visibility' => $request->input('visibility'),
            'only_for_print' => $request->input('only_for_print'),
            'multilanguage' => $request->input('multilanguage'),
            'is_adaptive' => $request->input('adaptive'),
            'max_questions' => $request->input('max_questions')
        ]);
    }

    /** Редактирование выбранного теста */
    public function edit($id_test){
        $test = Test::whereId_test($id_test)->first();
        $test['is_resolved'] = Test::isResolved($id_test);
        $test['finish_opportunity'] = Test::isFinished($id_test) ? 0 : 1;
        $test_for_groups = TestForGroup::whereId_test($test->id_test)
            ->join('groups', 'test_for_group.id_group', 'groups.group_id')
            ->where('archived', '=', 0)
            ->get();
        foreach ($test_for_groups as $test_for_group) {
            $test_for_group['group_name'] = Group::whereGroup_id($test_for_group['id_group'])->select('group_name')->first()->group_name;
            $test_for_group['finish_opportunity'] = Test::isFinishedForGroup($id_test, $test_for_group['id_group']) ? 0 : 1;
        }
        return view ('tests.edit', compact('test',  'test_for_groups'));
    }

    public function cloneTest(Request $request) {
        if ($request->ajax()) {
            $old_test_id = $request->input('test_id');
            $old_items = Test::whereId_test($old_test_id)->get()->toArray();
            $item = $old_items[0];
            $item['id_test'] = null;
            $item['test_name'] = $item['test_name'] . ' (копия)';
            $new_test_id = Test::insertGetId($item);
            $old_test_structures = TestStructure::whereId_test($old_test_id)->get()->toArray();
            $new_structure_id = TestStructure::max('id_structure');
            foreach ($old_test_structures as $old_test_structure) {
                $new_structure_id++;
                $old_structural_records = StructuralRecord::whereId_test($old_test_structure['id_test']) // whereId_test($old_test_id)
                    ->where('id_structure', '=', $old_test_structure['id_structure'])->get()->toArray();

                $old_test_structure['id_test'] = $new_test_id;
                $old_test_structure['id_structure'] = $new_structure_id;

                TestStructure::insert($old_test_structure);

                foreach ($old_structural_records as $old_structural_record) {
                    $old_structural_record['id_test'] = $new_test_id;
                    $old_structural_record['id_structure'] = $new_structure_id;
                    StructuralRecord::insert($old_structural_record);
                }
            }
            // adding test_for_group
            $groups = Group::whereArchived(0)->get();
            foreach ($groups as $group) {
                TestForGroup::insert(['id_test' => $new_test_id, 'id_group' => $group['group_id'], 'availability' => 0]);
            }
        }
        return null;
    }

    /** Применение изменений после редактирования теста */
    public function update(Request $request){
        $id_test = $request->input('id-test');
        $test_name = $request->input('test-name');
        $test_type = $request->input('test-type');
        $is_adaptive = $request->input('adaptive') ? 1 : 0;
        $visibility = $request->input('visibility') ? 1 : 0;
        $multilanguage = $request->input('multilanguage') ? 1 : 0;
        $only_for_print = $request->input('only-for-print') ? 1 : 0;
        $total = $request->input('total');
        $test_time = $request->input('test-time');
        $max_questions = $request->input('max_questions');
        
        if ($request->input('go-to-create-extended-test') == 0) {
            /* Update test and test_for_group */
            Test::whereId_test($id_test)->update([
                'test_name' => $test_name, 'test_type' => $test_type, 'test_time' => $test_time,
                'total' => $total,'visibility' => $visibility, 'archived' => 0,
                'multilanguage' => $multilanguage, 'only_for_print' => $only_for_print,
                'is_adaptive' => $is_adaptive, 'max_questions' => $max_questions]);

            $availability_input = ($request->input('availability') == null) ? [] : $request->input('availability');

            for ($i = 0; $i < count($request->input('id-group')); $i++) {
                $availability = in_array($request->input('id-group')[$i], $availability_input) ? 1 : 0;
                TestForGroup::whereId_test($id_test)
                    ->whereId_group($request->input('id-group')[$i])
                    ->update(['id_test' => $id_test, 'id_group' => $request->input('id-group')[$i], 'availability' => $availability]);
            }
            
            if($request->input('go-to-edit-structure') == 0){
                return redirect()->route('tests_list');
            }
        }
        
        /* Get general settings for update structure or create new test based on it */
        $general_settings = [];
        $general_settings['id_test'] = $id_test;
        $general_settings['test_name'] = $test_name;
        $general_settings['test_type'] = $test_type;
        $general_settings['only_for_print'] = $only_for_print;
        $request->session()->put('general_settings', $general_settings);
        
        /* Get structures data for id_test */
        $structures = TestStructure::whereId_test($id_test)->select('id_structure', 'amount')->get();
        
        $structures_data = [];
        for ($i = 0; $i < count($structures); $i++) {
            $structures_data[$i]['amount'] = $structures[$i]->amount;
            $records = StructuralRecord::whereId_structure($structures[$i]->id_structure)->select('section_code', 'theme_code', 'type_code')->get();
            
            $sections = [];
            $themes = [];
            $types = [];
            foreach ($records as $record) {
                $section_code = $record->section_code;
                $theme_code = $record->theme_code;
                $type_code = $record->type_code;
                if (!in_array($section_code, $sections)) array_push($sections, $section_code);
                if (!in_array($theme_code, $themes)) array_push($themes, $theme_code);
                if (!in_array($type_code, $types)) array_push($types, $type_code);
            }
            $structures_data[$i]['sections'] = $sections;
            $structures_data[$i]['themes'] = $themes;
            $structures_data[$i]['types'] = $types;
        }
        
        $structures_data = json_encode($structures_data);
        $request->session()->put('structures_data', $structures_data);
        
        
        if ($request->input('go-to-edit-structure')) {
            return redirect()->route('test_edit_structure', ['id_test' => $id_test]);
        }
        else {
            $groups = Group::whereArchived(0)->get();
            $test = Test::whereId_test($id_test)->first();
            return view('tests.create', compact('groups', 'test'));
        }
    }

    public function makeAllControlTestsUnavailable() {
        $this->makeAllTestsUnavailable('control');
    }

    public function makeAllTrainTestsUnavailable() {
        $this->makeAllTestsUnavailable('train');
    }

    private function makeAllTestsUnavailable($test_type) {
        $test_type_real = $test_type === 'control' ? 'Контрольный' : 'Тренировочный';
        TestForGroup::whereAvailability(1)
            ->whereIn('id_test', function($query) use ($test_type_real) {
                $query->from('tests')
                    ->select('id_test')
                    ->where('test_type', '=', $test_type_real);
            })
            ->update(['availability' => 0]);
    }

    /** Редактирование структуры теста */
    public function editStructure(Request $request, $id_test) {
        
        /* Get all sections and themes and types */
        $structures_data = $request->session()->get('structures_data');
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
        
        return view('tests.edit2', compact('general_settings', 'sections', 'types', 'json_sections', 'json_types', 'structures_data'));
    }
    
    public function changeStructure(Request $request) {
        $general_settings = $request->session()->get('general_settings');
        $id_test = $general_settings['id_test'];
        
        StructuralRecord::where('id_test', $id_test)->delete();
        TestStructure::where('id_test', $id_test)->delete();

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
        $request->session()->forget('general_settings');
        $request->session()->forget('test_for_groups');
        $request->session()->forget('structures_data');
        return redirect()->route('tests_list');
    }

    /** Завершает выбранный тест для всех учебных групп */
    public function finishTest($id_test) {
        Test::finishTest($id_test);
        return redirect()->route('test_edit', $id_test);
    }

    public function finishTestForGroup($id_test, $id_group) {
        Test::finishTestForGroup($id_test, $id_group);
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
            TestForGroup::whereId_test($id_test)->delete();
            Test::whereId_test($id_test)->delete();
        }
        else {
            Test::whereId_test($id_test)->update(['archived' => 1]);
        }

        // fill null results
        $active_results = Result::whereId_test($id_test)->whereNull('result')->select('id_result')->get();
        foreach ($active_results as $result) {
            Result::whereId_result($result->id_result)->update(['result' => -1, 'mark_ru' => -1, 'mark_eu' => 'test deleted']);
        }

        // make this test unavailable for all groups
        TestForGroup::whereId_test($id_test)->update(['availability' => 0]);

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

        $test = $this->test->whereId_test($id_test)->first();
        $amount = $this->test->getAmount($id_test);
        $test_time = $test->test_time;
        $test_type = $test->test_type;
        if (Result::getCurrentResult(Auth::user()['id'], $id_test) == -1) {                                             //если пользователь не имеет начатый тест                                                                                     //если в тест зайдено первый раз
            $generator = new UsualTestGenerator();
            $generator->generate($test);
            for ($i=0; $i < $amount; $i++) {
                $id = $generator->chooseQuestion();
                $data = $question->show($id, $i+1, false);                                                                     //должны получать название view и необходимые параметры
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
                //Log::debug($saved_test[$i]);
                $widgets[] = View::make($saved_test[$i]['view'], $saved_test[$i]['arguments']);
            }
        }

        $current_time = date_create();                                                                                  //текущее время
        $int_left_time = $int_end_time - date_format($current_time, 'U');                                               //оставшееся время
        $left_min =  ($int_left_time > 0) ? floor($int_left_time/60) : 0;                                                                          //осталось минут
        $left_sec = ($int_left_time > 0) ? $int_left_time % 60 : 0;                                                                                //осталось секунд

        $widgetListView = View::make('questions.student.widget_list',compact('amount', 'id_test','left_min', 'left_sec', 'test_type'))->with('widgets', $widgets);
        $response = new Response($widgetListView);
        return $response;
    }

    private function saveTestScreenshot($pngBase64Screenshot, $userId, $testId) {
        $img = $pngBase64Screenshot;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        //saving
        $fileName = 'photo.png';
        file_put_contents($fileName, $fileData);
    }

    /** Проверка контрольной (теста) */
    public function checkTest(Request $request) {
        $userId = Auth::user()['id'];
        // id контрольной
        $id_test = $request->input('id_test');
        // Получаем начатую пользователем попытку прохождения контрольной с id = $id_test
        $current_test = Result::getCurrentResult($userId, $id_test);
        if ($current_test == -1) {
            return redirect('tests');
        }
        // Число вопросов.
        $amount = $request->input('amount');
        if ($amount < 2) {
            return "Error. Too few questions";
        }
        //сумма набранных баллов
        $score_sum = 0;
        //сумма максимально возможных баллов
        $points_sum = 0;
        //запоминаем выбранные варианты пользователя
        $choice = [];
        //Процент правильности ответа на неверный вопрос
        $right_percent = [];
        $j = 1;
        $question = new Question();

        $query = $this->test->whereId_test($id_test)->select('total', 'test_name', 'test_type')->first();
        $total = $query->total;
        $test_type = $query->test_type;

        $id_user = Result::whereId_result($current_test)
            ->join('users', 'results.id', '=', 'users.id')->select('users.id')->first()->id;

        //обрабатываем каждый вопрос
        for ($i=0; $i<$amount; $i++) {
            $data = $request->input($i);
            $array = json_decode($data);
            $link_to_lecture[$j] = $question->linkToLecture($array[0]);

            // get type of test
            $id_question = $array[0];
            $query1 = Question::whereId_question($id_question)->select('answer','points', 'type_code')->first();
            $type_name = Type::whereType_code($query1['type_code'])->select('type_name')->first()->type_name;

            if ($type_name == 'Эмулятор Тьюринга' || $type_name == 'Эмулятор Маркова') {
                /* Get current saved test */
                $test = Result::whereId_result($current_test)->first();
                $saved_test = $test->saved_test;
                $saved_test = unserialize($saved_test);

                $arguments = $saved_test[$i]['arguments'];
                $debug_counter = $arguments['debug_counter'];
                $solution = $array[2];
                $should_increment_debug_counter = false;
                $check_syntax_counter = $arguments['check_syntax_counter'];
                $run_counter = $arguments['run_counter'];
                $data = $question->check([$id_question, $debug_counter, $check_syntax_counter, $run_counter,
                    $should_increment_debug_counter, $solution]);
            } else {
                $data = $question->check($array);
            }
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
            $fraction_score = $score / $total;
            Test::addToStatements($id_test, $id_user, $fraction_score);                                                          //занесение балла в ведомость
            $screenshot = $request->input('screenshot');
            $this->saveTestScreenshot($screenshot, $userId, $id_test);
        } else {                                                                                                          //тест тренировочный
            $widgetListView = View::make('questions.student.training_test',compact('total','score','right_or_wrong', 'mark_bologna', 'mark_rus', 'right_percent', 'link_to_lecture'))->with('widgets', $widgets);
        }
        $result->whereId_result($current_test)->update(['result_date' => $date, 'result' => $score, 'mark_ru' => $mark_rus, 'mark_eu' => $mark_bologna]);
        return $widgetListView;
    }

    /** Пользователь отказался от прохождения теста */
    public function dropTest(Request $request){
        $current_result = Result::getCurrentResult(Auth::user()['id'], $request->input('id_test'));
        if ($current_result != -1) {
            date_default_timezone_set('Europe/Moscow');
            $date = date('Y-m-d H:i:s', time());
            Result::whereId_result($current_result)->update(['result_date' => $date, 'result' => -1, 'mark_ru' => -1, 'mark_eu' => 'drop']);                                 //Присваиваем результату и оценке значения -1
        }
        return redirect('home');
    }
    
    /* Отображение состояния тестов */
    public function monitor(){
        return view('tests.monitor');
    }
}
