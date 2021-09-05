<?php
namespace App\Http\Controllers;
use App\Statements\DAO\ControlWorkPlanDAO;
use App\Statements\DAO\LecturePlanDAO;
use App\Statements\DAO\SectionPlanDAO;
use App\Statements\DAO\SeminarPlanDAO;
use App\Statements\LectureStatement;
use App\Statements\ResultStatement;
use App\Statements\SeminarStatement;
use App\Testing\Test;
use App\TeacherHasGroup;
use App\Group;
use Auth;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use App\Statements\DAO\CoursePlanDAO;
use stdClass;
use Illuminate\Support\Facades\Storage;

class StatementsController extends Controller{

    private $course_plan_DAO;
    private $section_plan_DAO;
    private $lecture_plan_DAO;
    private $seminar_plan_DAO;
    private $control_work_plan_DAO;
    private $lecture_statement;
    private $seminar_statement;
    private $result_statement;

    public function __construct(CoursePlanDAO $course_plan_DAO, SectionPlanDAO $section_plan_DAO, LecturePlanDAO $lecture_plan_DAO
        , SeminarPlanDAO $seminar_plan_DAO, ControlWorkPlanDAO $control_work_plan_DAO, LectureStatement $lecture_statement
        , SeminarStatement $seminar_statement, ResultStatement $result_statement)
    {
        $this->course_plan_DAO = $course_plan_DAO;
        $this->section_plan_DAO = $section_plan_DAO;
        $this->lecture_plan_DAO = $lecture_plan_DAO;
        $this->seminar_plan_DAO = $seminar_plan_DAO;
        $this->control_work_plan_DAO = $control_work_plan_DAO;
        $this->lecture_statement = $lecture_statement;
        $this->seminar_statement = $seminar_statement;
        $this->result_statement = $result_statement;
    }

    // возвращает страницу с учебными планами
    public function showCoursePlans() {
        $read_only = true;
        $course_plans = $this->course_plan_DAO->allCoursePlan()
            ->map( function ($course_plan) {
                $exist_statements = $this->course_plan_DAO->existStatements($course_plan->id_course_plan);
                return ['course_plan' => $course_plan,
                    'exist_statements' => $exist_statements];
            });
        return view('personal_account.statements.course_plans.course_plans', compact('course_plans', 'read_only'));
    }

    // возвращает страницу создание нового учебного плана
    public function createCoursePlans() {
        $groups = Group::where(['archived' => 0, 'id_course_plan' => null, 'academic' => 1])->get(['group_name', 'group_id']);
        return view('personal_account.statements.course_plans.create_course_plans', compact('groups', $groups));
    }

    //сохранение учебного плана
    public function storeCoursePlan(Request $request) {
        $validator = $this->course_plan_DAO->getStoreValidate($request);
        if ($validator->passes()) {
            $id_course_plan = $this->course_plan_DAO->storeCoursePlan($request);
            return redirect('course_plan/'.$id_course_plan);
        } else {
            return redirect()->to($this->getRedirectUrl())
                ->withInput($request->input())->withErrors($validator->errors());
        }
    }

    //возвращает конкретный учебный план для просмотра и редактирования
    public function getCoursePlan($id) {
        $course_plan = $this->course_plan_DAO->getCoursePlan($id);
        $read_only = true;
        $tests_control_work = Test::whereTest_type('Контрольный')
            ->where('archived', '<>', '1')
            ->orderByDesc('id_test')
            ->select()
            ->get();
        $all_groups = Group::where(['archived' => 0, 'id_course_plan' => null, 'academic' => 1])->orWhere('id_course_plan', $id)->get(['group_name', 'group_id']);
        $exist_statements = $this->course_plan_DAO->existStatements($id);
        $max_results = $course_plan->getMaxes();
        $max_control = $max_results['max_control'];
        $max_ball_gen = $max_results['max_ball_gen'];
        $max_seminar_pass_ball_gen = $max_results['max_seminar_pass_ball_gen'];
        $max_lecture_ball_gen = $max_results['max_lecture_ball_gen'];
        $max_exam_gen = $max_results['max_exam_gen'];
        return view('personal_account.statements.course_plans.course_plan', compact('course_plan', 'read_only', 'tests_control_work', 'exist_statements',
            'all_groups', 'max_ball_gen', 'max_seminar_pass_ball_gen', 'max_lecture_ball_gen', 'max_control', 'max_exam_gen'));
    }

    //Обновление основной информации об учебном плане
    public function updateCoursePlan(Request $request)
    {
        $validator = $this->course_plan_DAO->getUpdateValidate($request);
        if ($validator->passes()) {
            $this->course_plan_DAO->updateCoursePlan($request);
            return response()->json(['idCoursePlan' => $request->id_course_plan,'courseName' => $request->course_plan_name]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'idCoursePlan' => $request->id_course_plan]);
        }
    }

    //Удаление учебного плана
    public function deleteCoursePlan(Request $request) {
        $this->course_plan_DAO->deleteCoursePlan($request->id_course_plan);
        return redirect('course_plans');
    }

    //Проверка баллов за конт. меропр. всего учебного плана
    public function checkPointsCoursePlan(Request $request) {
        if ($request->ajax()) {
            $validator = $this->course_plan_DAO->checkPointsCoursePlan($request->input('id_course_plan'));
            if ($validator->passes()) {
                return 0;
            } else {
                return response()->json(['error'=>$validator->errors()->all()]);
            }
        }
    }

    //возвращает представление для добавления раздела учебного плана
    public function getAddSection(Request $request) {
        $section_num = $request->input('section_num');
        $id_course_plan = $request->input('id_course_plan');
        $id_section_plan_js = $request->input('id_section_plan_js');
        $section_plan_max_ball = $request->input('section_plan_max_ball');
        $section_plan_max_lecture_ball = $request->input('section_plan_max_lecture_ball');
        $section_plan_max_seminar_pass_ball = $request->input('section_plan_max_seminar_pass_ball');
        return view('personal_account.statements.course_plans.sections.add_section', compact('section_num', 'id_course_plan', 'id_section_plan_js','section_plan_max_ball', 'section_plan_max_lecture_ball','section_plan_max_seminar_pass_ball'));
    }

    //Сохранение раздела учебного плана
    public function storeSection(Request $request) {
        $validator = $this->section_plan_DAO->getValidateStoreSectionPlan($request);
        //Для вставки html через js, используя число сгенерированное js
        $id_section_plan_js = $request->input('id_section_plan_js');
        $section_plan_max_ball = $request->input('section_plan_max_ball');
        $section_plan_max_lecture_ball = $request->input('section_plan_max_lecture_ball');
        $section_plan_max_seminar_pass_ball = $request->input('section_plan_max_seminar_pass_ball');
        if ($validator->passes()) {
            $id_section_plan = $this->section_plan_DAO->storeSectionPlan($request);
            $section_plan = $this->section_plan_DAO->getSectionPlan($id_section_plan);
            $read_only = true;
            $returnHtmlString = view('personal_account.statements.course_plans.sections.view_or_update_section', compact('section_plan',
                'section_plan_max_ball','section_plan_max_seminar_pass_ball','section_plan_max_lecture_ball','read_only'))
                ->render();
            return response()->json(['view'=>$returnHtmlString, 'idSectionPlanJs' => $id_section_plan_js]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'idSectionPlanJs' => $id_section_plan_js]);
        }

    }

    //Обновление  информации о разделе учебного плана
    public function updateSection(Request $request) {
        $validator = $this->section_plan_DAO->getValidateUpdateSectionPlan($request);
        //Для вставки html через js
        $id_section_plan = $request->input('id_section_plan');

        if ($validator->passes()) {
            $this->section_plan_DAO->updateSectionPlan($request);

            return response()->json(['idSectionPlan' => $id_section_plan ,
                'sectionNum' => $request->input('section_num')]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'idSectionPlan' => $id_section_plan]);
        }
    }

    //Удаление раздела
    public function deleteSection(Request $request) {
        $this->section_plan_DAO->deleteSectionPlan($request->input('id_section_plan'));
        return $request->input('id_section_plan');
    }

    // Возвращает представление для добавления семинара или лекции или КМ
    public function getAddLecOrSemOrCW(Request $request) {
        $type_card = $request->input('type_card');
        $view_path = $this->getPathAddViewLecSemCW($type_card);
        $section_item_num = $request->input('section_item_num');
        $tests_control_work = new stdClass();
        $id_new_section_item_js = $request->input('id_new_section_item_js');
        if($type_card == 'control_work') {
            $tests_control_work = Test::whereTest_type('Контрольный')
                ->where('archived', '<>', '1')
                ->orderByDesc('id_test')
                ->select()
                ->get();
        }
        $returnHtmlString = view('personal_account.statements.course_plans.sections.'.$view_path,
            ['id_new_section_item_js' => $id_new_section_item_js,
                'section_item_num' => $section_item_num, 'tests_control_work' => $tests_control_work
            ])->render();

        return response()->json(['view' => $returnHtmlString]);
    }

    //Сохранение семинара или лекции в разделе учебного плана
    public function storeLecOrSemOrCW(Request $request) {
        $type_card = $request->input('type_card');
        $view_path = $this->getViewUpdatePathLecSemCW($type_card);
        $item_section_DAO = $this->getItemSectionDAO($type_card);
        $validator = $item_section_DAO->getStoreValidate($request);
        $id_item_section_js = $request->input('id_item_section_js');
        if ($validator->passes()) {
            $id_item_section_plan = $item_section_DAO->store($request);
            $item_section_plan = $item_section_DAO->get($id_item_section_plan);
            $read_only = true;
            $tests_control_work = new stdClass();
            if($type_card == 'control_work') {
                $tests_control_work = Test::whereTest_type('Контрольный')
                    ->where('archived', '<>', '1')
                    ->orderByDesc('id_test')
                    ->select()
                    ->get();
            }
            $return_html_string = view('personal_account.statements.course_plans.sections.'.$view_path,
                compact('item_section_plan', 'read_only', 'tests_control_work'))
                ->render();
            return response()->json(['view'=>$return_html_string]);
        } else {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

    }

    //Обновление лекции, семинара, контрольн. меропри в разделе учебного плана
    public function updateLecOrSemOrCW(Request $request) {
        $type_item_section = $request->input('type_item_section');
        $item_section_DAO = $this->getItemSectionDAO($type_item_section);
        $validator = $item_section_DAO->getUpdateValidate($request);

        if ($validator->passes()) {
            $item_section_DAO->update($request);
            return 0;
        } else {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

    }

    public function deleteLecOrSemOrCW(Request $request)
    {
        $item_section_DAO = $this->getItemSectionDAO($request->input('type_item_section'));
        $item_section_DAO->delete($request);
        return 0;
    }


    public function getItemSectionDAO ($type_card) {
        $item_section_DAO =  new stdClass();
        switch ($type_card) {
            case 'lecture':
                $item_section_DAO = $this->lecture_plan_DAO;
                break;
            case 'seminar':
                $item_section_DAO = $this->seminar_plan_DAO;
                break;
            case 'control_work':
                $item_section_DAO = $this->control_work_plan_DAO;
                break;
        }
        return $item_section_DAO;
    }

    public function getViewUpdatePathLecSemCW($type_card) {
        if ($type_card == 'lecture') {
            return 'lectures.view_or_update_lecture';
        } else if ($type_card == 'seminar'){
            return 'seminars.view_or_update_seminar';
        } else {
            return 'control_works.view_or_update_control_work';
        }
    }

    public function getPathAddViewLecSemCW($type_card) {
        if ($type_card == 'lecture') {
            return 'lectures.add_lecture';
        } else if ($type_card == 'seminar'){
            return 'seminars.add_seminar';
        } else {
            return 'control_works.add_control_work';
        }
    }

    public function copyCoursePlan(Request $request) {
        $id_new_course_plan = $this->course_plan_DAO->copyCoursePlan($request->input('id_course_plan'));
        return redirect('course_plan/' .  $id_new_course_plan);
    }

    //Возвращает главную страницу для выбора типа ведомости и группы
    public function statements(){
        $user = Auth::user();
        $groups = TeacherHasGroup::where('user_id', $user['id'])
            ->join('groups', 'groups.group_id', '=', 'teacher_has_group.group')
            ->where('groups.archived', 0)
            ->get();
        $group_set = Group::where('groups.archived', 0)->where('groups.id_course_plan', '<>', null)->get();
        return view('personal_account/statements', compact('groups', 'user', 'group_set'));
    }

    //показывает личный кабинет студента, вкладку со статистикой
    public function showPersonalAccount()
    {
        $user = Auth::user();
        if (($user['role'] == 'Админ') or ($user['role'] == 'Преподаватель')) {
            return AdministrationController::getAdminPanel();
        } else {
            if ($user['role'] == 'Студент')
            {
                return $this->showStudentInfo();

            }
            else{
                return PersonalAccount::showTestResults();
            }
        }
    }

    //показывает личный кабинет студента, вкладку со статистикой
    public function showStudentInfo()
    {
        $user = Auth::user();
        $id_course_plan = Group::where('group_id', $user->group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->course_plan_DAO->getCoursePlan( $id_course_plan);
        $statement_lecture = $this->lecture_statement->getStatementByUser($id_course_plan, $user);
        $statement_seminar = $this->seminar_statement->getStatementByUser($id_course_plan, $user);
        $statement_result = $this->result_statement->getStatementByUser($id_course_plan, $user);
        return view('personal_account/student_account',  compact('course_plan','statement_lecture','statement_seminar', 'statement_result'));
    }

    //Возвращают представление соответствующей ведомости
    public function get_lectures(Request $request){
        $id_group = $request->input('group');
        $statement_lecture = $this->lecture_statement->getStatementByGroup($id_group);
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->course_plan_DAO->getCoursePlan( $id_course_plan);
        return view('personal_account/statements/lectures', compact('course_plan','id_group', 'statement_lecture'));
    }

    public function get_seminars(Request $request){
        $id_group = $request->input('group');
        $statement_seminar = $this->seminar_statement->getStatementByGroup($id_group);
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->course_plan_DAO->getCoursePlan($id_course_plan);
        return view('personal_account/statements/seminars', compact('course_plan','id_group', 'statement_seminar'));
    }

    public function get_resulting(Request $request){
        $id_group = $request->input('group');
        $statement_result = $this->result_statement->getStatementByGroup($id_group);
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->course_plan_DAO->getCoursePlan($id_course_plan);
        return view('personal_account/statements/results',  compact('course_plan','id_group', 'statement_result'));
    }
    public function get_resulting_excel(Request $request){
        $id_group = $request->input('group');
        $filename= $request->filename;
        $file = $request->file;
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        //echo $file;
        $course_plan = $this->course_plan_DAO->getCoursePlan($id_course_plan);
        $statement_result = $this->result_statement->getStatementByGroup($id_group);
        Storage::disk('local')->put('file.xlsx', file_get_contents($file));
        //
        return $this->result_statement->getExcelLoadOut($course_plan,$statement_result,'/storage/app/file.xlsx');;
    }
    public function get_resulting_excel_ex(Request $request){
        $id_group = $request->input('group');
        $filename= $request->filename;
        $file = $request->file;
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        //echo $file;
        $course_plan = $this->course_plan_DAO->getCoursePlan($id_course_plan);
        $statement_result = $this->result_statement->getStatementByGroup($id_group);
        Storage::disk('local')->put('file.xlsx', file_get_contents($file));
        //
        return $this->result_statement->getExcelLoadOutEx($course_plan,$statement_result,'/storage/app/file.xlsx');;
    }
    //Отмечает или раз-отмечает студента на лекции
    public function lecture_mark_present(Request $request){
        $this->lecture_statement->markPresent($request);
        return 0;
    }

    //NEW 05.09.2016
    public function lecture_mark_present_all(Request $request){
        $this->lecture_statement->markPresentAll($request);
        return 0;
    }
    public function seminar_mark_present_all(Request $request){
        $this->seminar_statement->markPresentAll($request);
        return 0;
    }

    //Отмечает или раз-отмечает студента на семинаре
    public function seminar_mark_present(Request $request){
        $this->seminar_statement->markPresent($request);
        return 0;
    }

    //Изменяет балл студента за работу на семинаре
    public function classwork_change(Request $request){
        $validator = $this->seminar_statement->getClassworkChangeValidate($request);
        if ($validator->passes()) {
            $this->seminar_statement->classworkChange($request);
            return 0;
        } else {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    //Отмечает или раз-отмечает студента на Контрольном мероприятии
    public function result_mark_present(Request $request){
        $this->result_statement->markPresent($request);
        return 0;
    }

    //Изменяет балл студента за контр мероприятие
    public function result_change(Request $request){
        $validator = $this->result_statement->getResultChangeValidate($request);
        if ($validator->passes()) {
            $this->result_statement->resultChange($request);
            $id_user = $request->input('id_user');
            $id_course_plan = $request->input('id_course_plan');
            $section_result = $this->result_statement->getResultSectionByNumber($request->input('section_num'),
                $id_user);
            $sum_result_control_works = $this->result_statement->getSumResultSectionControlWork($id_course_plan, $id_user);
            $sum_result_exam_works = $this->result_statement->getSumResultSectionExamWork($id_course_plan, $id_user);
            $class_work = $this->result_statement->getResultWorkSeminar($id_course_plan, $id_user);
            $seminar_pass = $this->result_statement->getResultSeminar($id_course_plan, $id_user);
            $lecture_pass = $this->result_statement->getResultLecture($id_course_plan, $id_user);
            if ($request->input('work_status') == 'section') {
                $sum_result_section = $sum_result_control_works;
            } else {
                $sum_result_section = $sum_result_exam_works;
            }
            $result_all_course = $sum_result_exam_works +  $sum_result_control_works + $class_work
                + $seminar_pass + $lecture_pass;

            $markRus = Test::calcMarkRus(100, $result_all_course);
            $markBologna = Test::calcMarkBologna(100, $result_all_course);
            return response()->json(['sectionResult' => $section_result, 'sumResultSection' => $sum_result_section,
                'resultAllCourse' => $result_all_course, 'markRus' => $markRus, 'markBologna' => $markBologna]);
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    public function result_mark_present_all(Request $request){
        $this->result_statement->markPresentAll($request);
        return 0;
    }
}
