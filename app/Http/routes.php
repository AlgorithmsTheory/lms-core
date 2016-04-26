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

/*Route::bind('questions', function($id_question){
    return \App\Question::whereId_question($id_question)->first();
});*/


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
Route::get('home', ['as' => 'home', function() {
    if(Auth::check()) {
        return view('main', ['first_name' => Auth::user()['first_name']]);
    }
    else {
        return view('welcome');
    }
}]);


Route::get('in-process', ['as' => 'in_process', function() {
    return view('in_process');
}]);

// Авторизация
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/login', ['as' => 'login', function(){
    return view('welcome');
}]);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

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
Route::get('tests/drop', ['as' => 'drop_test', 'uses' => 'TestController@dropTest', 'middleware' => 'general_auth']);

//модуль тестирования для курса ИнСист
Route::get('fish', ['as' => 'fish', 'uses' => 'FishController@index', 'middleware' => ['general_auth', 'fish']]);

//модуль тестирования для преподавателей
Route::get('questions', ['as' => 'question_index', 'uses' => 'QuestionController@index', 'middleware' => ['general_auth', 'admin']]);
Route::get('questions/create', ['as' => 'question_create', 'uses' => 'QuestionController@create', 'middleware' => ['general_auth','admin']]);
Route::post('get-theme', array('as'=>'get_theme', 'uses'=>'QuestionController@getTheme'));
Route::post('get-type', array('as'=>'get_type', 'uses'=>'QuestionController@getType'));
Route::post('questions/create', ['as' => 'question_add', 'uses' => 'QuestionController@add']);
Route::get('tests/create', ['as' => 'test_create', 'uses' => 'TestController@create', 'middleware' => ['general_auth', 'admin']]);
Route::post('get-theme-for-test', array('as'=>'get_theme_for_test', 'uses'=>'TestController@getTheme'));
Route::post('get-amount', array('as'=>'get_amount', 'uses'=>'TestController@getAmount'));
Route::post('tests/create', ['as' => 'test_add', 'uses' => 'TestController@add']);
Route::get('retest', ['as' => 'retest_index', 'uses' => 'TeacherRetestController@index']);
Route::post('retest', ['as' => 'retest_change', 'uses' => 'TeacherRetestController@change']);
Route::get('tests/edit', ['as' => 'tests_list', 'uses' => 'TestController@editList']);
Route::post('tests/dates/finish', ['as' => 'finish_test', 'uses' => 'TeacherRetestController@finishTest']);
Route::post('tests/dates/prolong', ['as' => 'prolong_test', 'uses' => 'TeacherRetestController@prolongTest']);

//электронная библиотека
Route::get('library', ['as' => 'library_index', 'uses' => 'LibraryController@index']);
Route::get('library/definitions', ['as' => 'library_definitions', 'uses' => 'LibraryController@definitions']);
Route::get('library/theorems', ['as' => 'library_theorems', 'uses' => 'LibraryController@theorems']);
Route::get('library/lecture/{index}{anchor?}', ['as' => 'lecture', 'uses' => 'LibraryController@lecture'])->where('anchor', '[a-z0-9-]+');
Route::get('library/persons', ['as' => 'library_persons', 'uses' => 'LibraryController@persons']);
Route::get('library/persons/{person}', ['as' => 'person', 'uses' => 'LibraryController@person']);
Route::get('library/extra', ['as' => 'library_extra', 'uses' => 'LibraryController@extra']);

//модуль books библиотеки
Route::get('library/books', ['as' => 'books', 'uses' => 'BooksController@index']);
Route::post('library/books/search', ['as' => 'library_search', 'uses' => 'BooksController@search']);
Route::get('library/book/{id}', ['as' => 'book', 'uses' => 'BooksController@getBook']);
Route::get('library/lection/{id}', ['as' => 'lection', 'uses' => 'BooksController@lection']);
Route::get('library/ebooks', ['as' => 'ebooks', 'uses' => 'BooksController@ebookindex']);
Route::post('library/ebooks/search', ['as' => 'library_esearch', 'uses' => 'BooksController@esearch']);
Route::post('library/book/{book_id}/order', ['as' => 'book_order', 'uses' => 'BooksController@order']);
// TODO: Мише и Стасу: Перенести в секцию админки и добавить авторизацию (админка библиотеки)
Route::get('teacher_account/library_calendar', ['as' => 'library_calendar', 'uses' => 'BooksController@library_calendar']);
Route::post('teacher_account/date_create', ['as' => 'library_date_create', 'uses' => 'BooksController@create_date']);
Route::get('teacher_account/library_order_list', ['as' => 'library_order_list', 'uses' => 'BooksController@library_order_list']);
Route::post('teacher_account/library_order_list_elem_delete', ['as' => 'order_list_delete', 'uses' => 'BooksController@order_list_delete']);

//модуль маркова - задачи и работа с ними
Route::get('main', ['as' => 'main_menu', 'uses' => 'TasksController@main']);
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

//модуль генерации вариантов
Route::get('generator', ['as' => 'generator_index', 'uses' => 'GeneratorController@index', 'middleware' => ['general_auth', 'admin']]);
Route::post('generator/pdf', ['as' => 'generator_pdf', 'uses' => 'GeneratorController@pdfTest', 'middleware' => ['general_auth', 'admin']]);
Route::get('generator/pdf', ['as' => 'generator_ex', 'uses' => 'GeneratorController@pdf', 'middleware' => ['general_auth', 'admin']]);

//личный кабинет
Route::get('personal_account', ['as' => 'personal_account', 'uses' => 'PersonalAccount@showPA', 'middleware' => 'general_auth']);
Route::get('teacher_account', ['as' => 'teacher_account', 'uses' => 'PersonalAccount@showTeacherPA', 'middleware' => 'general_auth']);

//ведомости
Route::get('statements', ['as' => 'statements', 'uses' => 'PersonalAccount@statements', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-lectures', ['as' => 'get_lectures', 'uses' => 'PersonalAccount@get_lectures', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-seminars', ['as' => 'get_seminars', 'uses' => 'PersonalAccount@get_seminars', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-classwork', ['as' => 'get_classwork', 'uses' => 'PersonalAccount@get_classwork', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-controls', ['as' => 'get_controls', 'uses' => 'PersonalAccount@get_controls', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/get-resulting', ['as' => 'get_resulting', 'uses' => 'PersonalAccount@get_resulting', 'middleware' => ['general_auth', 'admin']]);

Route::post('statements/lecture/was', ['as' => 'lecture_was', 'uses' => 'PersonalAccount@lecture_was', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/lecture/wasnot', ['as' => 'lecture_wasnot', 'uses' => 'PersonalAccount@lecture_wasnot', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/seminar/was', ['as' => 'seminar_was', 'uses' => 'PersonalAccount@seminar_was', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/seminar/wasnot', ['as' => 'seminar_wasnot', 'uses' => 'PersonalAccount@seminar_wasnot', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/classwork/change', ['as' => 'classwork_change', 'uses' => 'PersonalAccount@classwork_change', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/controls/change', ['as' => 'controls_change', 'uses' => 'PersonalAccount@controls_change', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/change', ['as' => 'resulting_change', 'uses' => 'PersonalAccount@resulting_change', 'middleware' => ['general_auth', 'admin']]);

//расчет итогов за раздел
Route::post('statements/resulting/calc_first', ['as' => 'resulting_calc_first', 'uses' => 'PersonalAccount@calc_first', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/calc_second', ['as' => 'resulting_calc_second', 'uses' => 'PersonalAccount@calc_second', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/calc_third', ['as' => 'resulting_calc_third', 'uses' => 'PersonalAccount@calc_third', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/calc_fourth', ['as' => 'resulting_calc_fourth', 'uses' => 'PersonalAccount@calc_fourth', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/calc_term', ['as' => 'resulting_calc_term', 'uses' => 'PersonalAccount@calc_term', 'middleware' => ['general_auth', 'admin']]);
Route::post('statements/resulting/calc_final', ['as' => 'resulting_calc_final', 'uses' => 'PersonalAccount@calc_final', 'middleware' => ['general_auth', 'admin']]);

//верификация новых студентов
Route::get('verify_students', ['as' => 'verify_students', 'uses' => 'PersonalAccount@verify', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/student', ['as' => 'add_student', 'uses' => 'PersonalAccount@add_student', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/admin', ['as' => 'add_student', 'uses' => 'PersonalAccount@add_admin', 'middleware' => ['general_auth', 'admin']]);
Route::post('verify_students/average', ['as' => 'add_student', 'uses' => 'PersonalAccount@add_average', 'middleware' => ['general_auth', 'admin']]);


