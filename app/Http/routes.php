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

Route::get('/', 'WelcomeController@index');
Route::patch('questions/create', ['as' => 'question_add', 'uses' => 'QuestionController@add']);
Route::get('questions', ['as' => 'question_index', 'uses' => 'QuestionController@index']);
Route::get('questions/create', ['as' => 'question_create', 'uses' => 'QuestionController@create']);
Route::get('questions/kill-session', ['as' => 'question_kill_session', 'uses' => 'QuestionController@killSession']);
Route::get('questions/show/{id}', ['as' => 'question_show', 'uses' => 'QuestionController@show']);
Route::get('questions/show-test/{num}', ['as' => 'question_showtest', 'uses' => 'QuestionController@showTest']);
Route::get('questions/result', ['as' => 'question_result', 'uses' => 'QuestionController@result']);
Route::patch('questions/check', ['as' => 'question_check', 'uses' => 'QuestionController@check']);
Route::patch('questions/check-test', ['as' => 'question_checktest', 'uses' => 'QuestionController@checkTest']);
