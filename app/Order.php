<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereId_question($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereControl($value)
 * @method static \Illuminate\Database\Eloquent|\App\Question  get()
 * @method static \Illuminate\Database\Eloquent|\App\Question  where()
 * @method static \Illuminate\Database\Eloquent|\App\Question  whereRaw()
 * @method static \Illuminate\Database\Eloquent|\App\Question  orWhere()
 * @method static \Illuminate\Database\Eloquent|\App\Question  select()
 * @method static \Illuminate\Database\Eloquent|\App\Question  first()
 * @method static \Illuminate\Database\Eloquent|\App\Question  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Question  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Question  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Question  count()
 * @method static \Illuminate\Database\Eloquent|\App\Question  toSql()
 *
 */
class Order extends Eloquent {
    protected $table = 'order';
    public $timestamps = false;
    protected $fillable = ['id', 'book_id', 'student_id', 'date'];
}