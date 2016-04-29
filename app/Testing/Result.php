<?php

namespace App\Testing;

/**
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result whereId_result($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereId($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereId_test($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereResult_date($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereResult($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereMark_eu($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereMark_ru($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereSaved_test($value)
 *
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  get()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  where()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  orWhere()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  select()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  first()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  insert($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  table($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  max($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  count()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  orderBy($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  limit($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  take($array)
*
*/
class Result extends \Eloquent {
    protected $table = 'results';
    public $timestamps = false;
    protected $fillable = ['*'];
}