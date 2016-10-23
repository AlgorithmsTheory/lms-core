<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::filter('csrf-ajax', function()
{
    if (Session::token() != Request::header('x-csrf-token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::get('/', function() {
    return redirect('home');
});
Route::get('home', ['as' => 'home', 'uses' => 'HomeController@get_home']);


Route::get('in-process', ['as' => 'in_process', function() {
    return view('in_process');
}]);

// Авторизация
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
Route::get('auth/login', ['as' => 'login', 'uses' => 'HomeController@get_home']);

// Регистрация
Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);

// Восстановление пароля
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', ['as' => 'passEmailPost', 'uses' => 'Auth\PasswordController@postEmail']);
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset',['as' => 'passReset', 'uses' => 'Auth\PasswordController@postReset']);

//модуль тестирования для студентов
Route::get('tests', ['as' => 'tests', 'uses' => 'TestController@index', 'middleware' => 'general_auth']);
Route::get('questions/show-test/{id_test}', ['as' => 'question_showtest', 'uses' => 'TestController@showViews', 'middleware' => ['general_auth', 'single_test', 'have_attempts']]);
Route::patch('questions/check-test', ['as' => 'question_checktest', 'uses' => 'TestController@checkTest']);
Route::post('tests/drop', ['as' => 'drop_test', 'uses' => 'TestController@dropTest', 'middleware' => 'general_auth']);
Route::post('tests/get-protocol', ['as' => 'get_protocol', 'uses' => 'TestController@getProtocol', 'middleware' => 'general_auth']);

//модуль тестирования для курса ИнСист
Route::get('fish', ['as' => 'fish', 'uses' => 'FishController@index', 'middleware' => ['general_auth', 'fish']]);

//модуль тестирования для преподавателей
Route::get('questions', ['as' => 'question_index', 'uses' => 'QuestionController@index', 'middleware' => ['general_auth', 'admin']]);
Route::get('questions/create', ['as' => 'question_create', 'uses' => 'QuestionController@create', 'middleware' => ['general_auth','admin']]);
Route::get('questions/edit', ['as' => 'questions_list', 'uses' => 'QuestionController@editList', 'middleware' => ['general_auth','admin']]);
Route::get('questions/edit/search', ['as' => 'questions_find', 'uses' => 'QuestionController@find', 'middleware' => ['general_auth','admin']]);
Route::post('questions/edit/search', ['as' => 'questions_find', 'uses' => 'QuestionController@find', 'middleware' => ['general_auth','admin']]);
Route::get('questions/edit/{id_question}', ['as' => 'question_edit', 'uses' => 'QuestionController@edit', 'middleware' => ['general_auth','admin']])->where($id_question, '[0-9]+');
Route::post('questions/edit', ['as' => 'question_update', 'uses' => 'QuestionController@update', 'middleware' => ['general_auth','admin']]);
Route::post('questions/delete', ['as' => 'question_delete', 'uses' => 'QuestionController@delete', 'middleware' => ['general_auth','admin']]);
Route::post('get-theme', array('as'=>'get_theme', 'uses'=>'QuestionController@getTheme'));
Route::post('get-type', array('as'=>'get_type', 'uses'=>'QuestionController@getType'));
Route::post('questions/create', ['as' => 'question_add', 'uses' => 'QuestionController@add']);
Route::get('tests/create', ['as' => 'test_create', 'uses' => 'TestController@create', 'middleware' => ['general_auth', 'admin']]);
Route::post('get-theme-for-test', array('as'=>'get_theme_for_test', 'uses'=>'TestController@getTheme'));
Route::post('get-amount', array('as'=>'get_amount', 'uses'=>'TestController@getAmount'));
Route::post('tests/create', ['as' => 'test_add', 'uses' => 'TestController@add']);
Route::get('retest', ['as' => 'retest_index', 'uses' => 'TeacherRetestController@index']);
Route::post('retest', ['as' => 'retest_change', 'uses' => 'TeacherRetestController@change']);
Route::get('tests/edit/{id_group}', ['as' => 'tests_list', 'uses' => 'TestController@editList']);
Route::post('tests/edit', ['as' => 'test_update', 'uses' => 'TestController@update']);
Route::get('tests/remove/{id_test}', ['as' => 'test_remove', 'uses' => 'TestController@remove']);
Route::get('tests/edit/{id_test}', ['as' => 'test_edit', 'uses' => 'TestController@edit']);
Route::post('tests/dates/finish', ['as' => 'finish_test', 'uses' => 'TeacherRetestController@finishTest']);
Route::get('tests/groups-for-tests', ['as' => 'choose_group', 'uses' => 'TestController@chooseGroup']);

//электронная библиотека
Route::get('library', ['as' => 'library_index', 'uses' => 'LibraryController@index']);
Route::get('library/definitions', ['as' => 'library_definitions', 'uses' => 'LibraryController@definitions']);
Route::get('library/theorems', ['as' => 'library_theorems', 'uses' => 'LibraryController@theorems']);
Route::get('library/lecture/{index}{anchor?}', ['as' => 'lecture', 'uses' => 'LibraryController@lecture'])->where('anchor', '[a-z0-9-]+');
Route::get('library/persons', ['as' => 'library_persons', 'uses' => 'LibraryController@persons']);
Route::get('library/persons/{person}', ['as' => 'person', 'uses' => 'LibraryController@person']);
Route::get('library/extra', ['as' => 'library_extra', 'uses' => 'LibraryController@extra']);

Route::get('library/books', ['as' => 'books', 'uses' => 'BooksController@index']); //только студентам и преподавателям
Route::post('library/books/search', ['as' => 'library_search', 'uses' => 'BooksController@search']); //только студентам и преподавателям
Route::get('library/book/{id}', ['as' => 'book', 'uses' => 'BooksController@getBook']); //только студентам и преподавателям
Route::get('library/lection/{id}', ['as' => 'lection', 'uses' => 'BooksController@lection']); //только студентам и преподавателям
Route::get('library/ebooks', ['as' => 'ebooks', 'uses' => 'BooksController@ebookindex']); // всем пользователям
Route::post('library/ebooks/search', ['as' => 'library_esearch', 'uses' => 'BooksController@esearch']); //всем пользователям
Route::post('library/book/{book_id}/order', ['as' => 'book_order', 'uses' => 'BooksController@order']); //только студентам и преподавателям
Route::get('teacher_account/library_calendar', ['as' => 'library_calendar', 'uses' => 'BooksController@library_calendar']); //только преподавателю
Route::post('teacher_account/date_create', ['as' => 'library_date_create', 'uses' => 'BooksController@create_date']); // только преподавателю
Route::get('teacher_account/library_order_list', ['as' => 'library_order_list', 'uses' => 'BooksController@library_order_list']); // только преподавателю
Route::post('teacher_account/library_order_list_elem_delete', ['as' => 'order_list_delete', 'uses' => 'BooksController@order_list_delete']); // только преподавателю
Route::get('student_lib_account', ['as' => 'student_lib_account', 'uses' => 'BooksController@student_lib_account']); //только студенту
Route::post('student_lib_account/student_order_delete', ['as' => 'student_order_delete', 'uses' => 'BooksController@student_order_delete']); //только студенту
Route::get('student_lib_account2', ['as' => 'student_lib_account2', 'uses' => 'BooksController@student_lib_account2']); //только студенту
Route::get('teacher_account/library_order_list/{order_id}/edit_order_status0', ['as' => 'edit_order_status0', 'uses' => 'BooksController@edit_order_status0']); // только преподавателю
Route::get('teacher_account/library_order_list/{order_id}/edit_order_status1', ['as' => 'edit_order_status1', 'uses' => 'BooksController@edit_order_status1']); // только преподавателю

//модуль маркова - задачи и работа с ними
Route::get('emulator/administration', ['as' => 'main_menu', 'uses' => 'TasksController@main']);

Route::get('alltasks', ['as' => 'alltasks', 'uses' => 'TasksController@index']);
//Route::get('alltasksmt', ['as' => 'alltasks_MT', 'uses' => 'TasksController@index']);
Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'TasksController@deleteTask']);
Route::get('algorithm/addtask', ['as' => 'addtask', 'uses' => 'TasksController@addtask']);
Route::get('algorithm/{sequense_id}/edit', ['as' => 'edit', 'uses' => 'TasksController@edit']);
Route::post('algorithm/{sequense_id}/editTask', ['as' => 'editTask', 'uses' => 'TasksController@editTask']);
Route::post('algorithm/addind', ['as' => 'adding', 'uses' => 'TasksController@adding']);

// модуль МТ
Route::get('alltasksmt', ['as' => 'alltasksmt', 'uses' => 'TasksController@alltasksmt']);
Route::get('algorithm/addtaskmt', ['as' => 'addtaskmt', 'uses' => 'TasksController@addtaskmt']);
Route::post('algorithm/addingmt', ['as' => 'addingmt', 'uses' => 'TasksController@addingmt']);
Route::get('deletemt/{id}', ['as' => 'deletemt', 'uses' => 'TasksController@deletemtTask']);
Route::get('algorithm/{id_sequence}/editmt', ['as' => 'editmt', 'uses' => 'TasksController@editmt']);
Route::post('algorithm/{id_sequence}/editmtTask', ['as' => 'editmtTask', 'uses' => 'TasksController@editmtTask']);

//эмуляторы
Route::get('algorithm/MT', ['as' => 'MT', 'uses' => 'EmulatorController@MT']);
Route::get('algorithm/HAM', ['as' => 'HAM', 'uses' => 'EmulatorController@HAM']);
Route::post('get-MT', array('as'=>'get_MT', 'uses'=>'EmulatorController@MTPOST'));
Route::post('get-HAM', array('as'=>'get_HAM', 'uses'=>'EmulatorController@HAMPOST'));
Route::post('get_control_tasks', array('as'=>'get_control_tasks', 'uses'=>'EmulatorController@get_control_tasks'));
Route::post('get_control_tasks_HAM', array('as'=>'get_control_tasks_HAM', 'uses'=>'EmulatorController@get_control_tasks_nam'));

// новое для коэффициентов НАМ
Route::get('algorithm/edit_coef', ['as' => 'edit_coef', 'uses' => 'TasksController@editCoef']);
Route::post('algorithm/{id}edit_all_coef', ['as' => 'editAllCoef', 'uses' => 'TasksController@editAllCoef']);

// новое для коэффициентов МТ
Route::get('algorithm/edit_coef_mt', ['as' => 'edit_coef_mt', 'uses' => 'TasksController@editCoefMt']);
Route::post('algorithm/{id_task}edit_all_coef_mt', ['as' => 'editAllCoefMt', 'uses' => 'TasksController@editAllCoefMt']);
Route::post('get_MT_protocol', array('as'=>'get_MT_protocol', 'uses'=>'EmulatorController@get_MT_protocol'));

//контрольный режим эмуляторов
Route::get('algorithm/kontrMT', ['as' => 'kontrMT', 'uses' => 'EmulatorController@kontrMT']);

Route::get('algorithm/kontrHAM', ['as' => 'kontrHAM', 'uses' => 'EmulatorController@kontrHAM']);
Route::post('get-MT-kontr', array('as'=>'get_MT', 'uses'=>'EmulatorController@kontr_MTPOST'));

//модуль генерации вариантов
Route::get('generator', ['as' => 'generator_index', 'uses' => 'GeneratorController@index', 'middleware' => ['general_auth', 'admin']]);
Route::post('generator/pdf', ['as' => 'generator_pdf', 'uses' => 'GeneratorController@pdfTest', 'middleware' => ['general_auth', 'admin']]);
Route::get('generator/pdf', ['as' => 'generator_ex', 'uses' => 'GeneratorController@pdf', 'middleware' => ['general_auth', 'admin']]);

//личный кабинет
Route::get('personal_account', ['as' => 'personal_account', 'uses' => 'StatementsController@showPersonalAccount', 'middleware' => 'general_auth']);
Route::get('personal_account/student_info', ['as' => 'student_info', 'uses' => 'StatementsController@showStudentInfo', 'middleware' => 'general_auth']);
Route::get('personal_account/all_test_results', ['as' => 'all_test_results', 'uses' => 'PersonalAccount@showAllTests', 'middleware' => ['general_auth', 'admin']]);
Route::get('personal_account/tests_results', ['as' => 'test_results', 'uses' => 'PersonalAccount@showTestResults', 'middleware' => 'general_auth']);

//ведомости
Route::get('statements', ['as' => 'statements', 'uses' => 'StatementsController@statements', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-lectures', ['as' => 'get_lectures', 'uses' => 'StatementsController@get_lectures', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-seminars', ['as' => 'get_seminars', 'uses' => 'StatementsController@get_seminars', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-classwork', ['as' => 'get_classwork', 'uses' => 'StatementsController@get_classwork', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-controls', ['as' => 'get_controls', 'uses' => 'StatementsController@get_controls', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-resulting', ['as' => 'get_resulting', 'uses' => 'StatementsController@get_resulting', 'middleware' => ['general_auth', 'admin']]);

Route::post('statements/lecture/was', ['as' => 'lecture_was', 'uses' => 'StatementsController@lecture_was', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/lecture/wasnot', ['as' => 'lecture_wasnot', 'uses' => 'StatementsController@lecture_wasnot', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/seminar/was', ['as' => 'seminar_was', 'uses' => 'StatementsController@seminar_was', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/seminar/wasnot', ['as' => 'seminar_wasnot', 'uses' => 'StatementsController@seminar_wasnot', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/classwork/change', ['as' => 'classwork_change', 'uses' => 'StatementsController@classwork_change', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/controls/change', ['as' => 'controls_change', 'uses' => 'StatementsController@controls_change', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/change', ['as' => 'resulting_change', 'uses' => 'StatementsController@resulting_change', 'middleware' => ['general_auth', 'admin']]);

Route::post('statements/lecture/wasall', ['as' => 'lecture_wasall', 'uses' => 'StatementsController@lecture_was_all', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/seminar/wasall', ['as' => 'seminar_wasall', 'uses' => 'StatementsController@seminar_was_all', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/change_user_l_name', ['as' => 'change_l_name', 'uses' => 'AdministrationController@change_l_name', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/change_user_f_name', ['as' => 'change_f_name', 'uses' => 'AdministrationController@change_f_name', 'middleware' => ['general_auth', 'admin']]);

//верификация новых студентов
Route::get('verify_students', ['as' => 'verify_students', 'uses' => 'AdministrationController@verify', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/student', ['as' => 'add_student', 'uses' => 'AdministrationController@add_student', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/admin', ['as' => 'add_student', 'uses' => 'AdministrationController@add_admin', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/average', ['as' => 'add_student', 'uses' => 'AdministrationController@add_average', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/tutor', ['as' => 'add_tutor', 'uses' => 'AdministrationController@add_tutor', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/change_group', ['as' => 'change_group', 'uses' => 'AdministrationController@change_group', 'middleware' => ['general_auth', 'admin']]);
Route::get('change_role', ['as' => 'change_role', 'uses' => 'AdministrationController@change_role', 'middleware' => ['general_auth', 'admin']]);
Route::get('manage_groups', ['as' => 'manage_groups', 'uses' => 'AdministrationController@manage_groups', 'middleware' => ['general_auth','admin']]);
Route::post('manage_groups/add_group', ['as' => 'add_group', 'uses' => 'AdministrationController@add_group', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_groups/delete_group', ['as' => 'delete_group', 'uses' => 'AdministrationController@delete_group', 'middleware' => ['general_auth', 'admin']]);

Route::get('manage_news', ['as' => 'manage_news', 'uses' => 'AdministrationController@manage_news', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_news/add_news', ['as' => 'add_news', 'uses' => 'AdministrationController@add_news', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_news/delete', ['as' => 'delete_news', 'uses' => 'AdministrationController@delete_news', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_news/hide', ['as' => 'hide_news', 'uses' => 'AdministrationController@hide_news', 'middleware' => ['general_auth', 'admin']]);

Route::get('manage_plan', ['as' => 'manage_plan', 'uses' => 'StatementsController@manage_plan', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_plan/is', ['as' => 'change_plan', 'uses' => 'StatementsController@plan_is', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_plan/is_not', ['as' => 'change_plan', 'uses' => 'StatementsController@plan_is_not', 'middleware' => ['general_auth', 'admin']]);
Route::get('pashalka', ['as' => 'pashalka', 'uses' => 'AdministrationController@pashalka']);

Route::get('manage_groups/group_set', ['as' => 'group_set', 'uses' => 'AdministrationController@add_groups', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_groups/group_set/add', ['as' => 'add_group_to_set', 'uses' => 'AdministrationController@add_group_to_set', 'middleware' => ['general_auth', 'admin']]);
Route::post('manage_groups/group_set/delete', ['as' => 'delete_group_from_set', 'uses' => 'AdministrationController@delete_group_from_set', 'middleware' => ['general_auth', 'admin']]);

//модуль рекурсивных функций
Route::get('recursion', ['as' => 'recursion_index', 'uses' => 'RecursionController@index']); //всем пользователям
Route::get('recursion/kontrRec', ['as' => 'kontrRec', 'uses' => 'RecursionController@kontrRec']); //студентам
Route::get('recursion/kontrRec/{test_id}/{user_id}', ['as' => 'kontrRec', 'uses' => 'RecursionController@kontrRec']); //студентам
Route::post('recursion/kontrRec/{test_id}/{user_id}', ['as' => 'kontrRecSolving', 'uses' => 'RecursionController@solve']); //студентам
Route::get('alltasksrec', ['as' => 'alltasksrec', 'uses' => 'RecursionController@indexrec']); //только преподавателю
Route::get('recursion/addtaskrec', ['as' => 'addtaskrec', 'uses' => 'RecursionController@addtaskrec']); //только преподавателю
Route::post('recursion/addingrec', ['as' => 'addingrec', 'uses' => 'RecursionController@addingrec']); //только преподавателю
Route::get('recursion/alltasksrec/{id}/editrec', ['as' => 'editrec', 'uses' => 'RecursionController@editrec']); //только преподавателю
Route::post('recursion/{id}/editTaskrec', ['as' => 'editTaskrec', 'uses' => 'RecursionController@editTaskrec']); //только преподавателю
Route::get('deleterec/{id}', ['as' => 'deleterec', 'uses' => 'RecursionController@deleteTaskrec']); //только преподавателю

//архивный модуль
Route::get('storage', ['as' => 'archive_index', 'uses' => 'ArchiveController@index']);
Route::post('storage/{folder}', ['as' => 'archive_folder', 'uses' => 'ArchiveController@folder']);
Route::post('storage', ['as' => 'archive_download', 'uses' => 'ArchiveController@download']);
Route::post('storage/download-folder/folder', ['as' => 'archive_download_folder', 'uses' => 'ArchiveController@downloadFolder']);
Route::post('storage/delete/file', ['as' => 'archive_delete', 'uses' => 'ArchiveController@delete']);
