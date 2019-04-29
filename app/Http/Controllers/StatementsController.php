<?php
namespace App\Http\Controllers;
use App\Statements\DAO\ControlWorkPlanDAO;
use App\Statements\DAO\LecturePlanDAO;
use App\Statements\DAO\SectionPlanDAO;
use App\Statements\DAO\SeminarPlanDAO;
use App\Statements\LectureStatementManage;
use App\Statements\ResultStatementManage;
use App\Statements\SeminarStatementManage;
use App\Testing\Test;
use App\TeacherHasGroup;
use App\Pass_plan;
use App\Group;
use Auth;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use App\Statements\DAO\CoursePlanDAO;
use stdClass;

class StatementsController extends Controller{

    private $coursePlanDao;
    private $sectionPlanDAO;
    private $lecturePlanDAO;
    private $seminarPlanDAO;
    private $controlWorkPlanDAO;
    private $lecture_statement_manage;
    private $seminar_statement_manage;
    private $result_statement_manage;

    public function __construct(CoursePlanDAO $coursePlanDAO, SectionPlanDAO $sectionPlanDAO, LecturePlanDAO $lecturePlanDAO
    , SeminarPlanDAO $seminarPlanDAO, ControlWorkPlanDAO $controlWorkPlanDAO, LectureStatementManage $lecture_statement_manage
, SeminarStatementManage $seminar_statement_manage, ResultStatementManage $result_statement_manage)
    {
        $this->coursePlanDao = $coursePlanDAO;
        $this->sectionPlanDAO = $sectionPlanDAO;
        $this->lecturePlanDAO = $lecturePlanDAO;
        $this->seminarPlanDAO = $seminarPlanDAO;
        $this->controlWorkPlanDAO = $controlWorkPlanDAO;
        $this->lecture_statement_manage = $lecture_statement_manage;
        $this->seminar_statement_manage = $seminar_statement_manage;
        $this->result_statement_manage = $result_statement_manage;
    }

    // возвращает страницу с учебными планами
    public function showCoursePlans() {
        $read_only = true;
        $course_plans = $this->coursePlanDao->allCoursePlan()
            ->map( function ($course_plan) {
                $exist_statements = $this->coursePlanDao->existStatements($course_plan->id_course_plan);
                return ['course_plan' => $course_plan,
                        'exist_statements' => $exist_statements];
            });
        return view('personal_account.statements.course_plans.course_plans', compact('course_plans', 'read_only'));
    }

    // возвращает страницу создание нового учебного плана
    public function createCoursePlans() {
        return view('personal_account.statements.course_plans.create_course_plans');
    }

    //сохранение учебного плана
    public function storeCoursePlan(Request $request) {
        $validator = $this->coursePlanDao->getStoreValidate($request);
        if ($validator->passes()) {
            $idCoursePlan = $this->coursePlanDao->storeCoursePlan($request);
            return redirect('course_plan/'.$idCoursePlan);
        } else {
            return redirect()->to($this->getRedirectUrl())
                ->withInput($request->input())->withErrors($validator->errors());
        }


    }

    //возвращает конкретный учебный план для просмотра и редактирования
    public function getCoursePlan($id) {
        $coursePlan = $this->coursePlanDao->getCoursePlan($id);
        $read_only = true;
        $tests_control_work = Test::whereTest_type('Контрольный')
            ->where('archived', '<>', '1')
            ->orderByDesc('id_test')
            ->select()
            ->get();
        $exist_statements = $this->coursePlanDao->existStatements($id);
        return view('personal_account.statements.course_plans.course_plan', compact('coursePlan', 'read_only', 'tests_control_work', 'exist_statements'));
    }

    //Обновление основной информации об учебном плане
    public function updateCoursePlan(Request $request)
    {
        $validator = $this->coursePlanDao->getUpdateValidate($request);
        if ($validator->passes()) {
            $this->coursePlanDao->updateCoursePlan($request);
            return response()->json(['idCoursePlan' => $request->id_course_plan,'courseName' => $request->course_plan_name]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'idCoursePlan' => $request->id_course_plan]);
        }
    }

    //Удаление учебного плана
    public function deleteCoursePlan(Request $request) {
        $this->coursePlanDao->deleteCoursePlan($request->id_course_plan);
        return redirect('course_plans');
    }

    //Проверка баллов за конт. меропр. всего учебного плана
    public function checkPointsCoursePlan(Request $request) {
        if ($request->ajax()) {
            $validator = $this->coursePlanDao->checkPointsCoursePlan($request->input('id_course_plan'));
            if ($validator->passes()) {
                return 0;
            } else {
                return response()->json(['error'=>$validator->errors()->all()]);
            }
        }
    }

    //возвращает представление для добавления раздела учебного плана
    public function getAddSection(Request $request) {
        $sectionNumForFindJs = json_decode($request->currentCount,true);
        $idCoursePlan = json_decode($request->idCoursePlan,true);
        return view('personal_account.statements.course_plans.sections.add_section', compact('sectionNumForFindJs', 'idCoursePlan'));
    }

    //Сохранение раздела учебного плана
    public function storeSection(Request $request) {
        $validator = $this->sectionPlanDAO->getValidateStoreSectionPlan($request);
        //Для вставки html через js, используя число сгенерированное системой , а не написанного вручную номера раздела
        $sectionNumForFindJs = $request->section_num_for_find_js;

        if ($validator->passes()) {
           $idSectionPlan = $this->sectionPlanDAO->storeSectionPlan($request);
           $sectionPlan = $this->sectionPlanDAO->getSectionPlan($idSectionPlan);
           $readOnly = true;
           $returnHtmlString = view('personal_account.statements.course_plans.sections.view_or_update_section', compact('sectionPlan', 'readOnly',
               'sectionNumForFindJs'))
               ->render();
            return response()->json(['view'=>$returnHtmlString, 'section_num_for_find_js' => $sectionNumForFindJs]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'section_num_for_find_js' => $sectionNumForFindJs]);
        }

    }

    //Обновление  информации о разделе учебного плана
    public function updateSection(Request $request) {
        $validator = $this->sectionPlanDAO->getValidateUpdateSectionPlan($request);
        //Для вставки html через js
        $sectionNumForFindJs = $request->section_num_for_find_js;

        if ($validator->passes()) {
            $this->sectionPlanDAO->updateSectionPlan($request);

            return response()->json(['section_num_for_find_js' => $sectionNumForFindJs ,
                'real_section_num' => $request->section_num]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'section_num_for_find_js' => $sectionNumForFindJs]);
        }
    }

    //Удаление раздела
    public function deleteSection(Request $request) {
        $this->sectionPlanDAO->deleteSectionPlan($request->id_section_plan);
        return $request->section_num_for_find_js;
    }

    // Возвращает представление для добавления семинара или лекции или КМ
    public function getAddLecOrSemOrCW(Request $request) {

        $typeCard = $request->type_card;
        $viewPath = $this->getPathAddViewLecSemCW($typeCard);
        $numberNewCard = $request->number_new_card;
        $tests_control_work = new stdClass();
        if($typeCard == 'control_work') {
            $tests_control_work = Test::whereTest_type('Контрольный')
                ->where('archived', '<>', '1')
                ->orderByDesc('id_test')
                ->select()
                ->get();
        }
        $returnHtmlString = view('personal_account.statements.course_plans.sections.'.$viewPath,
            ['idNewCardForFindJs' => $request->id_new_card_for_find_js,
                'numberNewCard' => $request->number_new_card, 'tests_control_work' => $tests_control_work
            ])->render();

        return response()->json(['view' => $returnHtmlString
            , 'idSectionForFindJs' => $request->id_section_for_find_js,
            'numberNewCard' => $numberNewCard,
            'typeCard' => $typeCard]);
    }

    //Сохранение семинара или лекции в разделе учебного плана
    public function storeLecOrSemOrCW(Request $request) {
        $typeCard = $request->type_card;
        $viewPath = $this->getViewUpdatePathLecSemCW($typeCard);
        $itemSectionDAO = $this->getItemSectionDAO($typeCard);
        $validator = $itemSectionDAO->getStoreValidate($request);

        if ($validator->passes()) {
            $idItemSectionPlan = $itemSectionDAO->store($request);
            $itemSectionPlan = $itemSectionDAO->get($idItemSectionPlan);
            $readOnly = true;
            $idCardForFindJs = $request->id_card_for_find_js;
            $tests_control_work = new stdClass();
            if($typeCard == 'control_work') {
                $tests_control_work = Test::whereTest_type('Контрольный')
                    ->where('archived', '<>', '1')
                    ->orderByDesc('id_test')
                    ->select()
                    ->get();
            }
            $returnHtmlString = view('personal_account.statements.course_plans.sections.'.$viewPath,
                compact('itemSectionPlan', 'readOnly',
                'idCardForFindJs', 'tests_control_work'))
                ->render();
            return response()->json(['view'=>$returnHtmlString, 'id_section_for_find_js' => $request->id_section_for_find_js
                , 'id_card_for_find_js' => $request->id_card_for_find_js,'type_card' => $request->type_card]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'id_section_for_find_js' => $request->id_section_for_find_js
                , 'id_card_for_find_js' => $request->id_card_for_find_js,'type_card' => $request->type_card]);
        }

    }

    //Обновление лекции, семинара, контрольн. меропри в разделе учебного плана
    public function updateLecOrSemOrCW(Request $request) {

        $itemSectionDAO = $this->getItemSectionDAO($request->type_card);
        $validator = $itemSectionDAO->getUpdateValidate($request);

        if ($validator->passes()) {
           $itemSectionDAO->update($request);
            return response()->json(['id_section_for_find_js' => $request->id_section_for_find_js
                , 'id_card_for_find_js' => $request->id_card_for_find_js,'type_card' => $request->type_card]);
        } else {
            return response()->json(['error'=>$validator->errors()->all(), 'id_section_for_find_js' => $request->id_section_for_find_js
                , 'id_card_for_find_js' => $request->id_card_for_find_js,'type_card' => $request->type_card]);
        }

    }

    public function deleteLecOrSemOrCW(Request $request)
    {
        $itemSectionDAO = $this->getItemSectionDAO($request->type_card);
        $itemSectionDAO->delete($request);
        return response()->json(['id_section_for_find_js'=>$request->id_section_for_find_js, 'id_card_for_find_js' => $request->id_card_for_find_js
            , 'type_card' => $request->type_card]);
    }


    public function getItemSectionDAO ($typeCard) {
        $itemSectionDAO =  new stdClass();
        switch ($typeCard) {
            case 'lecture':
                $itemSectionDAO = $this->lecturePlanDAO;
                break;
            case 'seminar':
                $itemSectionDAO = $this->seminarPlanDAO;
                break;
            case 'control_work':
                $itemSectionDAO = $this->controlWorkPlanDAO;
                break;
        }
        return $itemSectionDAO;
    }

    public function getViewUpdatePathLecSemCW($typeCard) {
        if ($typeCard == 'lecture') {
            return 'lectures.view_or_update_lecture';
        } else if ($typeCard == 'seminar'){
            return 'seminars.view_or_update_seminar';
        } else {
            return 'control_works.view_or_update_control_work';
        }
    }

    public function getPathAddViewLecSemCW($typeCard) {
        if ($typeCard == 'lecture') {
            return 'lectures.add_lecture';
        } else if ($typeCard == 'seminar'){
            return 'seminars.add_seminar';
        } else {
            return 'control_works.add_control_work';
        }
    }

    public function copyCoursePlan(Request $request) {
        $id_new_course_plan = $this->coursePlanDao->copyCoursePlan($request->input('id_course_plan'));
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
        $course_plan = $this->coursePlanDao->getCoursePlan( $id_course_plan);
        $statement_lecture = $this->lecture_statement_manage->getStatementByUser($id_course_plan, $user);
        $statement_seminar = $this->seminar_statement_manage->getStatementByUser($id_course_plan, $user);
        $statement_result = $this->result_statement_manage->getStatementByUser($id_course_plan, $user);
        return view('personal_account/student_account',  compact('course_plan','statement_lecture','statement_seminar', 'statement_result'));
    }

    public function manage_plan(Request $request){
        $user = Auth::user();
        if($user['role'] == 'Админ') {
            $plans = Pass_plan::join('groups', 'groups.group_id', '=', 'pass_plan.group')->where('groups.archived', 0)->get();
        } else {
            $plans = TeacherHasGroup::join('pass_plan', 'teacher_has_group.group', '=', 'pass_plan.group')
                ->join('groups', 'groups.group_id', '=', 'pass_plan.group')
                ->where('groups.archived', 0)
                ->where('teacher_has_group.user_id', $user['id'])
                ->get();
        }
        return view('personal_account/manage_plan', compact('plans'));
    }

    public function plan_is(Request $request){
        $column = $request->input('column');
        $group = $request->input('group');
        Pass_plan::where('group', $group)->update([$column => 1]);
        return 0;
    }
    public function plan_is_not(Request $request){
        $column = $request->input('column');
        $group = $request->input('group');
        Pass_plan::where('group', $group)->update([$column => 0]);
        return 0;
    }



    //Возвращают представление соответствующей ведомости
    public function get_lectures(Request $request){
        $id_group = $request->input('group');
        $statement_lecture = $this->lecture_statement_manage->getStatementByGroup($id_group);
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->coursePlanDao->getCoursePlan( $id_course_plan);
        return view('personal_account/statements/lectures', compact('course_plan','id_group', 'statement_lecture'));
    }

    public function get_seminars(Request $request){
        $id_group = $request->input('group');
        $statement_seminar = $this->seminar_statement_manage->getStatementByGroup($id_group);
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->coursePlanDao->getCoursePlan($id_course_plan);
        return view('personal_account/statements/seminars', compact('course_plan','id_group', 'statement_seminar'));
    }

    public function get_resulting(Request $request){
        $id_group = $request->input('group');
        $statement_result = $this->result_statement_manage->getStatementByGroup($id_group);
        $id_course_plan = Group::where('group_id', $id_group)->select('id_course_plan')
            ->first()->id_course_plan;
        $course_plan = $this->coursePlanDao->getCoursePlan($id_course_plan);
        return view('personal_account/statements/results',  compact('course_plan','id_group', 'statement_result'));
    }


    //Отмечает или раз-отмечает студента на лекции
    public function lecture_was(Request $request){
        $this->lecture_statement_manage->lectureWas($request);
        return 0;
    }
    public function lecture_wasnot(Request $request){
        $this->lecture_statement_manage->lectureWasNot($request);
        return 0;
    }

    //NEW 05.09.2016
    public function lecture_was_all(Request $request){
        $this->lecture_statement_manage->lectureWasAll($request);
        return 0;
    }
    public function seminar_was_all(Request $request){
        $this->seminar_statement_manage->seminarWasAll($request);
        return 0;
    }

    //Отмечает или раз-отмечает студента на семинаре
    public function seminar_was(Request $request){
        $this->seminar_statement_manage->seminarWas($request);
        return 0;
    }
    public function seminar_wasnot(Request $request){
        $this->seminar_statement_manage->seminarWasNot($request);
        return 0;
    }

    //Изменяет балл студента за работу на семинаре
    public function classwork_change(Request $request){
        $validator = $this->seminar_statement_manage->getClassworkChangeValidate($request);
        if ($validator->passes()) {
            $this->seminar_statement_manage->classworkChange($request);
            return 0;
        } else {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    //Отмечает или раз-отмечает студента на Контрольном мероприятии
    public function result_was(Request $request){
        $this->result_statement_manage->resultWas($request);
        return 0;
    }
    public function result_wasnot(Request $request){
        $this->result_statement_manage->resultWasNot($request);
        return 0;
    }

    //Изменяет балл студента за контр мероприятие
    public function result_change(Request $request){
        $validator = $this->result_statement_manage->getResultChangeValidate($request);
        if ($validator->passes()) {
            $this->result_statement_manage->resultChange($request);
            $id_user = $request->input('id_user');
            $id_course_plan = $request->input('id_course_plan');
            $section_result = $this->result_statement_manage->getResultSectionByNumber($request->input('section_num'),
                $id_user);
            $sum_result_control_works = $this->result_statement_manage->getSumResultSectionControlWork($id_course_plan, $id_user);
            $sum_result_exam_works = $this->result_statement_manage->getSumResultSectionExamWork($id_course_plan, $id_user);
            $class_work = $this->result_statement_manage->getResultWorkSeminar($id_course_plan, $id_user);
            $seminar_pass = $this->result_statement_manage->getResultSeminar($id_course_plan, $id_user);
            $lecture_pass = $this->result_statement_manage->getResultLecture($id_course_plan, $id_user);
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

    public function resultWasAll(Request $request){
        $this->result_statement_manage->resultWasAll($request);
        return 0;
    }
}