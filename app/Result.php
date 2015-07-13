<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
* @method static \Illuminate\Database\Query\Builder|\App\Question whereId_result($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereId_user($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereId_test($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereTest_name($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereAmount($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereResult_date($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereResult($value)
* @method static \Illuminate\Database\Query\Builder|\App\Question  whereMark($value)
* @method static \Illuminate\Database\Eloquent|\App\Question  get()
* @method static \Illuminate\Database\Eloquent|\App\Question  where()
* @method static \Illuminate\Database\Eloquent|\App\Question  orWhere()
* @method static \Illuminate\Database\Eloquent|\App\Question  select()
* @method static \Illuminate\Database\Eloquent|\App\Question  first()
* @method static \Illuminate\Database\Eloquent|\App\Question  insert($array)
* @method static \Illuminate\Database\Eloquent|\App\Question  table($array)
*
*/
class Result extends Eloquent {
protected $table = 'results';
public $timestamps = false;
protected $fillable = ['*'];
} 