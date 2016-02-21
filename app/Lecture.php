<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 21.02.16
 * Time: 2:37
 */

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * @method static \Illuminate\Database\Query\Builder|\App\Lecture whereId_Lecture($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lecture  whereLecture_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lecture  whereLecture_number($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Lecture  whereLecture_time($value)
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  get()
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  where()
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  select()
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  first()
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Lecture  max($array)
 *
 */

class Lecture extends Eloquent{
    protected $lectures = 'lectures';
    public $timestamps = false;
} 