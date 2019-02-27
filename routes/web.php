<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function() {
    return redirect('home');
});

Route::get('public', function() {
    return redirect('home');
});

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@get_home']);

Route::get('in-process', ['as' => 'in_process', function() {
    return view('in_process');
}]);

Route::get('no-access', ['as' => 'no_access', function(Request $request) {
    $message = $request->message;
    return view('no_access', compact('message'));
}]);

Route::get('tests/single-test/{id_test}', ['as' => 'single_test', function($id_test) {
    $test_name = App\Testing\Test::whereId_test($id_test)->select('test_name')->first()->test_name;
    return view('tests.single_test', compact('test_name', 'id_test'));
}]);

Route::get('tests/no-attempts/{max_test_points}/{total}', ['as' => 'no_attempts', function ($max_test_points, $total){
    return view('tests.no_attempts', compact('max_test_points', 'total'));
}]);

// Авторизация
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('auth/login', ['as' => 'login', 'uses' => 'HomeController@get_home']);

// Регистрация
Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);

// Восстановление пароля
Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('passEmailPost');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');

// Модуль тестирования - прохождение тестов
Route::get('tests', ['as' => 'tests', 'uses' => 'TestController@index', 'middleware' => 'general_auth']);
Route::get('questions/show-test/{id_test}', ['as' => 'question_showtest', 'uses' => 'TestController@showViews', 'middleware' => ['general_auth', 'single_test', 'have_attempts', 'test_is_available']]);
Route::patch('questions/check-test', ['as' => 'question_checktest', 'uses' => 'TestController@checkTest']);
Route::post('tests/drop', ['as' => 'drop_test', 'uses' => 'TestController@dropTest', 'middleware' => 'general_auth']);
Route::post('tests/get-protocol', ['as' => 'get_protocol', 'uses' => 'TestController@getProtocol', 'middleware' => 'general_auth']);


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
Route::get('tests/create/step1', ['as' => 'test_create', 'uses' => 'TestController@create', 'middleware' => ['general_auth', 'admin']]);
Route::post('tests/create/step1', ['as' => 'test_finish_first_creation_step', 'uses' => 'TestController@finishFstCreationStep']);
Route::get('tests/create/step2', ['as' => 'test_create_step2', 'uses' => 'TestController@createSndStep', 'middleware' => ['general_auth', 'admin']]);
Route::post('tests/create/step2', ['as' => 'test_add', 'uses' => 'TestController@add']);
Route::post('tests/validate-test-structure', ['as' => 'validate_test_structure', 'uses' => 'TestController@validateTestStructure']);
Route::post('get-theme-for-test', array('as'=>'get_theme_for_test', 'uses'=>'TestController@getTheme'));
Route::post('get-amount', array('as'=>'get_amount', 'uses'=>'TestController@getAmount'));
Route::get('retest', ['as' => 'retest_index', 'uses' => 'TeacherRetestController@index']);
Route::post('retest', ['as' => 'retest_change', 'uses' => 'TeacherRetestController@change']);
Route::get('tests/test-list', ['as' => 'tests_list', 'uses' => 'TestController@editList']);
Route::post('tests/update-general-settings', ['as' => 'update_general_settings', 'uses' => 'TestController@updateSettings']);
Route::post('tests/edit', ['as' => 'test_update', 'uses' => 'TestController@update']);
Route::get('tests/remove/{id_test}', ['as' => 'test_remove', 'uses' => 'TestController@remove']);
Route::get('tests/edit/{id_test}', ['as' => 'test_edit', 'uses' => 'TestController@edit']);
Route::get('tests/finish/{id_test}', ['as' => 'finish_test', 'uses' => 'TestController@finishTest']);
Route::get('tests/finish-for-group/{id_test}/{id_group}', ['as' => 'finish_test_for_group', 'uses' => 'TestController@finishTestForGroup']);
Route::get('tests/groups-for-tests', ['as' => 'choose_group', 'uses' => 'TestController@chooseGroup']);

//электронная библиотека
Route::get('library', ['as' => 'library_index', 'uses' => 'LibraryController@index', 'middleware' => ['general_auth', 'access_for_library']]);
//создание новой лекции
Route::get('library/lecture/create', ['as' => 'lecture_create', 'uses' => 'LibraryController@addNewLecture', 'middleware' => ['general_auth', 'access_for_library', 'admin']]);
//сохранение и валидация данных о новой лекции
Route::post('library/lecture/store', ['as' => 'lecture_store', 'uses' => 'LibraryController@storeLecture']);
// обновление данных о лекции
Route::patch('library/lecture/{id}', ['as' => 'lecture_update', 'uses' => 'LibraryController@updateLecture']);
// редактирование лекции
Route::get('library/lecture/{id}/edit', ['as' => 'lecture_edit', 'uses' => 'LibraryController@editLecture', 'middleware' => ['general_auth', 'admin']]);
// Удаление лекции
Route::delete('library/lecture/{id}/delete',['as' => 'lecture_delete', 'uses' => 'LibraryController@deleteLecture', 'middleware' => ['general_auth', 'admin']]);
// Вывод конкретной лекции
Route::get('library/lecture/{index?}{anchor?}', ['as' => 'lecture', 'uses' => 'LibraryController@lecture', 'middleware' => ['general_auth', 'access_for_library']])->where('anchor', '[a-z0-9-]+');
// Вывод определений
Route::get('library/definitions', ['as' => 'library_definitions', 'uses' => 'LibraryController@definitions', 'middleware' => ['general_auth', 'access_for_library']]);
//создание нового определения
Route::get('library/definitions/create', ['as' => 'definition_create', 'uses' => 'LibraryController@addNewDefinition', 'middleware' => ['general_auth', 'access_for_library', 'admin']]);
//сохранение и валидация данных о новом определении
Route::post('library/definitions/store', ['as' => 'definition_store', 'uses' => 'LibraryController@storeDefinition']);
// обновление данных об определении
Route::patch('library/definitions/{id}', ['as' => 'definition_update', 'uses' => 'LibraryController@updateDefinition']);
// редактирование определения
Route::get('library/definitions/{id}/edit', ['as' => 'definition_edit', 'uses' => 'LibraryController@editDefinition', 'middleware' => ['general_auth', 'admin']]);
// Удаление определения
Route::delete('library/definitions/{id}/delete',['as' => 'definition_delete', 'uses' => 'LibraryController@deleteDefinition', 'middleware' => ['general_auth', 'admin']]);
//Вывод теорем
Route::get('library/theorems', ['as' => 'library_theorems', 'uses' => 'LibraryController@theorems', 'middleware' => ['general_auth', 'access_for_library']]);
//создание нового определения
Route::get('library/theorems/create', ['as' => 'theorem_create', 'uses' => 'LibraryController@addNewTheorem', 'middleware' => ['general_auth', 'access_for_library', 'admin']]);
//сохранение и валидация данных о новой теореме
Route::post('library/theorems/store', ['as' => 'theorem_store', 'uses' => 'LibraryController@storeTheorem']);
// Удаление определения
Route::delete('library/theorems/{id}/delete',['as' => 'theorem_delete', 'uses' => 'LibraryController@deleteTheorem', 'middleware' => ['general_auth', 'admin']]);
// обновление данных о теореме
Route::patch('library/theorems/{id}', ['as' => 'theorem_update', 'uses' => 'LibraryController@updateTheorem']);
// редактирование теоремы
Route::get('library/theorems/{id}/edit', ['as' => 'theorem_edit', 'uses' => 'LibraryController@editTheorem', 'middleware' => ['general_auth', 'admin']]);
//вывод всех персоналий
Route::get('library/persons', ['as' => 'library_persons', 'uses' => 'LibraryController@persons', 'middleware' => ['general_auth', 'access_for_library']]);
//добавление новой персоналии
Route::get('library/persons/create', ['as' => 'person_create', 'uses' => 'LibraryController@addNewPerson', 'middleware' => ['general_auth', 'admin']]);
//вывод конкретного персоналия
Route::get('library/persons/{id}', ['as' => 'person', 'uses' => 'LibraryController@person', 'middleware' => ['general_auth', 'access_for_library']]);
//сохранение и валидация данных о новой персоналии
Route::post('library/persons', ['as' => 'person_store', 'uses' => 'LibraryController@storePerson']);
// обновление данных о персоналии
Route::patch('library/persons/{id}', ['as' => 'person_update', 'uses' => 'LibraryController@updatePerson']);
// редактирование персоналии
Route::get('library/persons/{id}/edit', ['as' => 'person_edit', 'uses' => 'LibraryController@editPerson', 'middleware' => ['general_auth', 'admin']]);
// Удаление персоналии
Route::delete('library/persons/{id}/delete',['as' => 'person_delete', 'uses' => 'LibraryController@deletePerson', 'middleware' => ['general_auth', 'admin']]);
// Скачивание doc файла
Route::get('library/persons/{id}/downloadDoc', ['as' => 'doc_download', 'uses' => 'LibraryController@docDownload', 'middleware' => ['general_auth']]);
// Скачивание ppt файла
Route::get('library/persons/{id}/downloadPpt', ['as' => 'ppt_download', 'uses' => 'LibraryController@pptDownload', 'middleware' => ['general_auth']]);

Route::get('library/extra', ['as' => 'library_extra', 'uses' => 'LibraryController@extra', 'middleware' => ['general_auth', 'access_for_library']]);
// Переход на страницу учебные материалы
Route::get('library/educationalMaterials', ['as' => 'educational_materials', 'uses' => 'LibraryController@educationalMaterials', 'middleware' => ['general_auth']]);
//добавление учебного материала
Route::get('library/educationalMaterials/create', ['as' => 'educational_materials_create', 'uses' => 'LibraryController@addEducationalMaterial', 'middleware' => ['general_auth', 'admin']]);
//сохранение и валидация данных о новой лекции
Route::post('library/educationalMaterials/store', ['as' => 'educational_materials_store', 'uses' => 'LibraryController@storeEducationalMaterial']);
// обновление данных о научном материале
Route::patch('library/educationalMaterials/{id}', ['as' => 'educationalMaterial_update', 'uses' => 'LibraryController@updateEducationalMaterial']);
// редактирование научных материалов
Route::get('library/educationalMaterials/{id}/edit', ['as' => 'educationalMaterial_edit', 'uses' => 'LibraryController@editEducationalMaterial', 'middleware' => ['general_auth', 'admin']]);
// Удаление научного материала
Route::delete('library/educationalMaterials/{id}/delete',['as' => 'educationalMaterial_delete', 'uses' => 'LibraryController@deleteEducationalMaterial', 'middleware' => ['general_auth', 'admin']]);
// Скачивание файл материала
Route::get('library/educationalMaterials/{id}/download', ['as' => 'educationalMaterials_download', 'uses' => 'LibraryController@educationalMaterialsDownload', 'middleware' => ['general_auth']]);


//библиотека для студентов и преподавателей
//каталог книг
Route::get('library/books', ['as' => 'books', 'uses' => 'BooksController@index']);
//поиск по каталогу
Route::post('library/books/search', ['as' => 'library_search', 'uses' => 'BooksController@search']);
//добавление новой книги
Route::get('library/books/create', ['as' => 'books_create', 'uses' => 'BooksController@add_new_book', 'middleware' => ['general_auth', 'admin']]);
//сохранение и валидация данных о новой книге
Route::post('library/books', ['as' => 'book_store', 'uses' => 'BooksController@store_book']);
// просмотр конкретной книги
Route::get('library/book/{id}', ['as' => 'book', 'uses' => 'BooksController@getBook']);
// обновление данных о книге
Route::patch('library/book/{id}', ['as' => 'book_update', 'uses' => 'BooksController@update_book']);
// редактирование книг
Route::get('library/book/{id}/edit', ['as' => 'book_edit', 'uses' => 'BooksController@editBook', 'middleware' => ['general_auth', 'admin']]);
// Удаление книг
Route::delete('library/book/{id}/delete',['as' => 'book_delete', 'uses' => 'BooksController@deleteBook', 'middleware' => ['general_auth', 'admin']]);
//Личный кабинет преподаватля
Route::get('library/books/teacherCabinet',['as' => 'teacher_сabinet', 'uses' => 'BooksController@teacherCabinet', 'middleware' => ['general_auth', 'admin']]);
//сохраняем настройки календаря в БД
Route::post('library/books/teacherCabinet',['as' => 'setDateCalendar', 'uses' => 'BooksController@setDateCalendar', 'middleware' => ['general_auth', 'admin']]);
//выбор даты заказа книги
Route::get('library/book/{id}/order', ['as' => 'book_order', 'uses' => 'BooksController@book_order',
    'middleware' => ['general_auth', 'OrderBookLibrary']]);
//зазаз книги и перенаправление в каталог
Route::post('library/book/{id}/order', ['as' => 'book_send_order', 'uses' => 'BooksController@book_send_order',
    'middleware' => ['general_auth']]);
//Личный кабинет студента
Route::get('library/books/studentCabinet',['as' => 'student_сabinet', 'uses' => 'BooksController@studentCabinet',
    'middleware' => ['general_auth', 'studentLibrary']]);
// отмена заказов пользователем
Route::delete('library/books/studentCabinet/{id}/delete',['as' => 'student_order_delete', 'uses' => 'BooksController@studentOrderDelete',
    'middleware' => ['general_auth']]);
// Удаление сообщений об отменённом заказе
Route::delete('library/books/studentCabinet/{id}/delete_message',['as' => 'student_message_delete', 'uses' => 'BooksController@studentMessageDelete',
    'middleware' => ['general_auth']]);
// получение настроек календаря
Route::get('library/books/studentCabinet/settingCalendar',['as' => 'student_setting_calendar', 'uses' => 'BooksController@studentSettingCalendar']);
// перенос даты возврата книги студентом
Route::post('library/books/studentCabinet/{id}/extendDate',['as' => 'student_extend_date', 'uses' => 'BooksController@studentExtendDate']);
// выдача книг студентам
Route::post('library/books/teacherCabinet/{id}/issureBook',['as' => 'teacher_issure_book', 'uses' => 'BooksController@teacherIssureBook', 'middleware' => ['general_auth', 'admin']]);
// отмена заказов Преподавателем
Route::delete('library/books/teacherCabinet/{id}/delete',['as' => 'teacher_order_delete', 'uses' => 'BooksController@teacherOrderDelete', 'middleware' => ['general_auth', 'admin']]);
// перенос заказа преподавателем
Route::post('library/books/teacherCabinet/{id}/extendDate',['as' => 'teacher_extend_date', 'uses' => 'BooksController@teacherExtendDate', 'middleware' => ['general_auth', 'admin']]);
// Возвращение книги
Route::delete('library/books/teacherCabinet/{id}/returnBook',['as' => 'teacher_return_book', 'uses' => 'BooksController@teacherReturnBook', 'middleware' => ['general_auth', 'admin']]);
// Отправка сообщения студенту о вовремя не сданной книге
Route::post('library/books/teacherCabinet/{id}/sendMessage',['as' => 'teacher_send_message', 'uses' => 'BooksController@teacherSendMessage', 'middleware' => ['general_auth', 'admin']]);
// переход на страницу управления и просмотра (для студента)библиотечными новостями
Route::get('library/books/manageNewsLibrary',['as' => 'manage_news_library', 'uses' => 'BooksController@manageNewsLibrary', 'middleware' => ['general_auth']]);
// добавление новой библиотечной новости и переход на страницу управления новостями
Route::post('library/books/manageNewsLibrary/add_news', ['as' => 'add_library_news', 'uses' => 'BooksController@addLibraryNews', 'middleware' => ['general_auth', 'admin']]);
// Удаление библиотечных новостей
Route::delete('library/books/manageNewsLibrary/{id}/delete',['as' => 'delete_library_news', 'uses' => 'BooksController@libraryNewsDelete',
    'middleware' => ['general_auth', 'admin']]);
// редактирование библиотечныз новостей
Route::get('library/manageNewsLibrary/{id}/edit', ['as' => 'library_news_edit', 'uses' => 'BooksController@editNewsLibrary', 'middleware' => ['general_auth', 'admin']]);
// Сохранение изменений библиотечной новости и редирект на страницу библиотечных новостей
Route::patch('library/manageNewsLibrary/{id}', ['as' => 'library_news_update', 'uses' => 'BooksController@updateLibraryNews', 'middleware' => ['general_auth', 'admin']]);


Route::get('library/lection/{id}', ['as' => 'lection', 'uses' => 'BooksController@lection', 'middleware' => ['general_auth', 'admin', 'access_for_library']]); //только студентам и преподавателям
Route::get('library/ebooks', ['as' => 'ebooks', 'uses' => 'BooksController@ebookindex']); // всем пользователям
Route::post('library/ebooks/search', ['as' => 'library_esearch', 'uses' => 'BooksController@esearch']); //всем пользователям
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
Route::get('emulator/administration', ['as' => 'main_menu', 'uses' => 'Emulators\TasksController@main']);

Route::get('alltasks', ['as' => 'alltasks', 'uses' => 'Emulators\TasksController@index']);
//Route::get('alltasksmt', ['as' => 'alltasks_MT', 'uses' => 'Emulators\TasksController@index']);
Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Emulators\TasksController@deleteTask']);
Route::get('algorithm/addtask', ['as' => 'addtask', 'uses' => 'Emulators\TasksController@addtask']);
Route::get('algorithm/{sequense_id}/edit', ['as' => 'edit', 'uses' => 'Emulators\TasksController@edit']);
Route::post('algorithm/{sequense_id}/editTask', ['as' => 'editTask', 'uses' => 'Emulators\TasksController@editTask']);
Route::post('algorithm/addind', ['as' => 'adding', 'uses' => 'Emulators\TasksController@adding']);

// модуль МТ
Route::get('alltasksmt', ['as' => 'alltasksmt', 'uses' => 'Emulators\TasksController@alltasksmt']);
Route::get('algorithm/addtaskmt', ['as' => 'addtaskmt', 'uses' => 'Emulators\TasksController@addtaskmt']);
Route::post('algorithm/addingmt', ['as' => 'addingmt', 'uses' => 'Emulators\TasksController@addingmt']);
Route::get('deletemt/{id}', ['as' => 'deletemt', 'uses' => 'Emulators\TasksController@deletemtTask']);
Route::get('algorithm/{id_sequence}/editmt', ['as' => 'editmt', 'uses' => 'Emulators\TasksController@editmt']);
Route::post('algorithm/{id_sequence}/editmtTask', ['as' => 'editmtTask', 'uses' => 'Emulators\TasksController@editmtTask']);

//эмуляторы
////Route::get('algorithm/MT', ['as' => 'MT', 'uses' => 'EmulatorController@MT']);
////Route::get('algorithm/HAM', ['as' => 'HAM', 'uses' => 'EmulatorController@HAM']);
Route::post('get-MT', array('as'=>'get_MT', 'uses'=>'EmulatorController@MTPOST'));
Route::post('get-HAM', array('as'=>'get_HAM', 'uses'=>'EmulatorController@HAMPOST'));
Route::post('get_control_tasks', array('as'=>'get_control_tasks', 'uses'=>'EmulatorController@get_control_tasks'));
Route::post('get_control_tasks_nam', array('as'=>'get_control_tasks_nam', 'uses'=>'EmulatorController@get_control_tasks_nam'));

// новое для коэффициентов НАМ
Route::get('algorithm/edit_coef', ['as' => 'edit_coef', 'uses' => 'Emulators\TasksController@editCoef']);
Route::post('algorithm/{id}edit_all_coef', ['as' => 'editAllCoef', 'uses' => 'Emulators\TasksController@editAllCoef']);

// новое для коэффициентов МТ
Route::get('algorithm/edit_coef_mt', ['as' => 'edit_coef_mt', 'uses' => 'Emulators\TasksController@editCoefMt']);
Route::post('algorithm/{id_task}edit_all_coef_mt', ['as' => 'editAllCoefMt', 'uses' => 'Emulators\TasksController@editAllCoefMt']);
Route::post('get_MT_protocol', array('as'=>'get_MT_protocol', 'uses'=>'EmulatorController@get_MT_protocol'));
Route::post('get_HAM_protocol', array('as'=>'get_HAM_protocol', 'uses'=>'EmulatorController@get_HAM_protocol'));


Route::get('algorithm/MT', ['as' => 'MT', 'uses' => 'EmulatorController@open_MT']);
Route::get('algorithm/MMT', ['as' => 'MMT', 'uses' => 'EmulatorController@open_MMT']);
Route::get('algorithm/HAM', ['as' => 'HAM', 'uses' => 'EmulatorController@open_HAM']);


Route::get('algorithm/kontrMT', ['as' => 'kontrMT', 'uses' => 'EmulatorController@open_MT']);
Route::get('algorithm/kontrHAM', ['as' => 'kontrHAM', 'uses' => 'EmulatorController@open_HAM']);


//контрольный режим эмуляторов

//Route::get('algorithm/kontrMT', ['as' => 'kontrMT', 'uses' => 'EmulatorController@kontrMT']);

//Route::get('algorithm/kontrHAM', ['as' => 'kontrHAM', 'uses' => 'EmulatorController@kontrHAM']);
Route::post('get-MT-kontr', array('as'=>'get_MT', 'uses'=>'EmulatorController@kontr_MTPOST'));

Route::post('get-HAM-kontr', array('as'=>'get_HAM_kontr', 'uses'=>'EmulatorController@kontr_HAMPOST'));

//доступ к контрольному режиму для кокретных студентов

Route::get('algorithm/edit_users_nam', ['as' => 'edit_users_nam', 'uses' => 'Emulators\TasksController@edit_users_nam']);
Route::post('algorithm/edit_users_nam_change', ['as' => 'edit_users_nam_change', 'uses' => 'Emulators\TasksController@edit_users_nam_change']);
Route::get('algorithm/edit_users_mt', ['as' => 'edit_users_mt', 'uses' => 'Emulators\TasksController@edit_users_mt']);
Route::post('algorithm/edit_users_mt', ['as' => 'edit_users_mt_change', 'uses' => 'Emulators\TasksController@edit_users_mt_change']);

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

//архивный модуль
Route::get('storage', ['as' => 'archive_index', 'uses' => 'ArchiveController@index']);
Route::post('storage/{folder}', ['as' => 'archive_folder', 'uses' => 'ArchiveController@folder']);
Route::post('storage', ['as' => 'archive_download', 'uses' => 'ArchiveController@download']);
Route::post('storage/download-folder/folder', ['as' => 'archive_download_folder', 'uses' => 'ArchiveController@downloadFolder']);
Route::post('storage/delete/file', ['as' => 'archive_delete', 'uses' => 'ArchiveController@delete']);


//новая рекурсия
Route::get('recursion_index', ['as' => 'recursion_index', 'uses' => 'RecursionController@get_recursion']);
Route::get('recursion_one', ['as' => 'recursion_one', 'uses' => 'RecursionController@get_recursion_one']);
Route::get('recursion_two', ['as' => 'recursion_two', 'uses' => 'RecursionController@get_recursion_two']);
Route::get('recursion_three', ['as' => 'recursion_three', 'uses' => 'RecursionController@get_recursion_three']);
Route::post('recursion/calculate_one', ['as' => 'calculate_one', 'uses' => 'RecursionController@calculate_one']);
Route::post('recursion/calculate_two', ['as' => 'calculate_two', 'uses' => 'RecursionController@calculate_two']);
Route::post('recursion/calculate_three', ['as' => 'calculate_three', 'uses' => 'RecursionController@calculate_three']);

//API for mobile app
Route::get('api/get/groups', ['uses' => 'APIController@getGroupList']);
Route::get('api/get/students/{group_id}', ['uses' => 'APIController@getStudentsFromGroup']);
Route::post('api/check', ['uses' => 'APIController@checkStudentsAtSeminar']);

//Login verification
Route::post('check/ifExists', ['uses' => 'AdministrationController@checkEmailIfExists']);

// ----------------------- Emulators -------------------- //
Route::prefix('algorithm')->group(function () {
	//RAM Emulator
	Route::prefix('RAM')->group(function () {
		Route::middleware(['general_auth'])->group(function () {
			Route::get('emulator',  ['as' => 'RAM', 	   'uses' => 'Emulators\RamEmulatorController@openRAM']);
			Route::post('set_mark', ['as' => 'ramSetMark', 'uses' => 'Emulators\RamEmulatorController@ramSetMark']);
		});
		Route::middleware(['general_auth', 'admin'])->group(function () {
			Route::get( 'manage_task', 				 ['as' => 'ramManageTask',  'uses' => 'Emulators\RamEmulatorController@ramManageTask']  );
			Route::get( 'add_task',	   				 ['as' => 'ramAddTask',	    'uses' => 'Emulators\RamEmulatorController@ramAddTask']     );
			Route::post('add_task',    				 ['as' => 'ramAddingTask',  'uses' => 'Emulators\RamEmulatorController@ramAddingTask']  );
			Route::get( '{sequence_id}/edit_task',   ['as' => 'ramEditTask',    'uses' => 'Emulators\RamEmulatorController@ramEditTask']    );
			Route::post('{sequence_id}/edit_task',   ['as' => 'ramEditingTask', 'uses' => 'Emulators\RamEmulatorController@ramEditingTask'] );
			Route::get( '{sequence_id}/delete_task', ['as' => 'ramDeleteTask',  'uses' => 'Emulators\RamEmulatorController@ramDeleteTask']  );
			Route::get( 'edit_users',                ['as' => 'ramEditUsers' ,  'uses' => 'Emulators\RamEmulatorController@ramEditUsers']   );
			Route::post('editing_users', 			 ['as' => 'ramEditingUsers','uses' => 'Emulators\RamEmulatorController@ramEditingUsers']);
		});
	});
	//Post Emulator
	Route::prefix('Post')->group(function () {
		Route::middleware(['general_auth'])->group(function () {
			Route::get('emulator',  ['as' => 'Post',        'uses' => 'Emulators\PostEmulatorController@openPost']);
			Route::post('set_mark', ['as' => 'postSetMark', 'uses' => 'Emulators\PostEmulatorController@postSetMark']);
		});
		Route::middleware(['general_auth', 'admin'])->group(function () {
			Route::get( 'manage_task', 				 ['as' => 'postManageTask',   'uses' => 'Emulators\PostEmulatorController@postManageTask'] );
			Route::get( 'add_task',	  				 ['as' => 'postAddTask',	  'uses' => 'Emulators\PostEmulatorController@postAddTask'] );
			Route::post('add_task', 				 ['as' => 'postAddingTask',   'uses' => 'Emulators\PostEmulatorController@postAddingTask'] );
			Route::get( '{sequence_id}/edit_task',   ['as' => 'postEditTask',     'uses' => 'Emulators\PostEmulatorController@postEditTask']);
			Route::post('{sequence_id}/edit_task',   ['as' => 'postEditingTask',  'uses' => 'Emulators\PostEmulatorController@postEditingTask']);
			Route::get( '{sequence_id}/delete_task', ['as' => 'postDeleteTask',   'uses' => 'Emulators\PostEmulatorController@postDeleteTask'] );
			Route::get( 'edit_users',  				 ['as' => 'postEditUsers' ,   'uses' => 'Emulators\PostEmulatorController@postEditUsers']);
			Route::post( 'editing_users',  		     ['as' => 'postEditingUsers', 'uses' => 'Emulators\PostEmulatorController@postEditingUsers']);
		});
	});
	// Emulators common
	Route::middleware(['general_auth', 'admin'])->group(function () {
		Route::get('edit_date',      ['as' => 'edit_date',   'uses' => 'Emulators\EmulatorController@editDate']);
		Route::post('edit_all_date', ['as' => 'editAllDate', 'uses' => 'Emulators\EmulatorController@editAllDate']);
	});
});
