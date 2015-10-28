<?php

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

Route::get('/', 'WelcomeController@index');
Route::post('questions/create', ['as' => 'question_add', 'uses' => 'QuestionController@add']);
Route::get('questions', ['as' => 'question_index', 'uses' => 'QuestionController@index']);
Route::get('questions-enter', ['as' => 'question_enter', 'uses' => 'QuestionController@enter']);
Route::post('questions-form', ['as' => 'question_form', 'uses' => 'QuestionController@form']);
Route::get('questions/create', ['as' => 'question_create', 'uses' => 'QuestionController@create']);
Route::post('tests/create', ['as' => 'test_add', 'uses' => 'TestController@add']);
Route::get('tests/create', ['as' => 'test_create', 'uses' => 'TestController@create']);
Route::get('questions/kill-session', ['as' => 'question_kill_session', 'uses' => 'QuestionController@killSession']);
Route::get('questions/show/{id}', ['as' => 'question_show', 'uses' => 'QuestionController@show']);
//Route::get('questions/show-test/{num}', ['as' => 'question_showtest', 'uses' => 'QuestionController@showTest']);
Route::get('questions/show-test/{id_test}', ['as' => 'question_showtest', 'uses' => 'QuestionController@showViews']);
Route::get('questions/result', ['as' => 'question_result', 'uses' => 'QuestionController@result']);
Route::post('get-theme', array('as'=>'get_theme', 'uses'=>'QuestionController@getTheme'));
Route::post('get-type', array('as'=>'get_type', 'uses'=>'QuestionController@getType'));
Route::post('get-theme-for-test', array('as'=>'get_theme_for_test', 'uses'=>'TestController@getTheme'));
Route::post('get-amount', array('as'=>'get_amount', 'uses'=>'TestController@getAmount'));
Route::patch('questions/check', ['as' => 'question_checks', 'uses' => 'QuestionController@checks']);
Route::patch('questions/check-test', ['as' => 'question_checktest', 'uses' => 'QuestionController@checkTest']);
Route::get('tests', ['as' => 'tests', 'uses' => 'TestController@index']);

Route::get('home', function(){
    echo "Welcome Home!";
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);
