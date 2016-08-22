<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 21.02.16
 * Time: 2:37
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Lecture whereId_Lecture($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Lecture  whereLecture_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Lecture  whereLecture_number($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Lecture  whereLecture_time($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Lecture  whereLecture_date($value)
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Lecture  whereNotIn($value)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Lecture  max($array)
 *
 */

class Lecture extends Eloquent{
    protected $table = 'lectures';
    public $timestamps = false;
} 