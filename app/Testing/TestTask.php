<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 29.04.16
 * Time: 19:42
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestTask  whereId_task($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestTask  whereId_question($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestTask  whereId_result($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestTask  wherePoints($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  on()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  toSql()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestTask  insert($array)
 *
 */

class TestTask extends  Eloquent{
    protected $table = 'test_tasks';
    public $timestamps = false;
    protected $fillable = [];
} 