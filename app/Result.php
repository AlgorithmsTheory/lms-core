<?php

namespace App;

/**
* @method static \Illuminate\Database\Query\Builder|\App\Result whereId_result($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereId_user($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereId_test($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereTest_name($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereAmount($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereResult_date($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereResult($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereMark($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereMark_eu($value)
* @method static \Illuminate\Database\Query\Builder|\App\Result  whereMark_ru($value)
* @method static \Illuminate\Database\Eloquent|\App\Result  get()
* @method static \Illuminate\Database\Eloquent|\App\Result  where()
* @method static \Illuminate\Database\Eloquent|\App\Result  orWhere()
* @method static \Illuminate\Database\Eloquent|\App\Result  select()
* @method static \Illuminate\Database\Eloquent|\App\Result  first()
* @method static \Illuminate\Database\Eloquent|\App\Result  insert($array)
* @method static \Illuminate\Database\Eloquent|\App\Result  table($array)
* @method static \Illuminate\Database\Eloquent|\App\Result  max($array)
* @method static \Illuminate\Database\Eloquent|\App\Result  count()
* @method static \Illuminate\Database\Eloquent|\App\Result  orderBy($array)
* @method static \Illuminate\Database\Eloquent|\App\Result  limit($array)
* @method static \Illuminate\Database\Eloquent|\App\Result  take($array)
*
*/
class Result extends \Eloquent {
    protected $table = 'results';
    public $timestamps = false;
    protected $fillable = ['*'];
}