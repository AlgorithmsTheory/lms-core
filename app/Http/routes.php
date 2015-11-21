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

//модуль тестирования для студентов
Route::get('tests', ['as' => 'tests', 'uses' => 'TestController@index', 'middleware' => 'general_auth']);
Route::get('questions/show-test/{id_test}', ['as' => 'question_showtest', 'uses' => 'QuestionController@showViews', 'middleware' => ['general_auth', 'single_test']]);
Route::patch('questions/check-test', ['as' => 'question_checktest', 'uses' => 'QuestionController@checkTest']);
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


//электронная библиотека
Route::get('library', ['as' => 'library_index', 'uses' => 'LibraryController@index']);
Route::get('library/definitions', ['as' => 'library_definitions', 'uses' => 'LibraryController@definitions']);
Route::get('library/theorems', ['as' => 'library_theorems', 'uses' => 'LibraryController@theorems']);
Route::get('library/lecture/{index}', ['as' => 'lecture', 'uses' => 'LibraryController@lecture']);
Route::get('library/persons', ['as' => 'library_persons', 'uses' => 'LibraryController@persons']);
Route::get('library/persons/{person}', ['as' => 'person', 'uses' => 'LibraryController@person']);
Route::get('library/extra', ['as' => 'library_extra', 'uses' => 'LibraryController@extra']);





