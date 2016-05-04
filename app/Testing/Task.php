<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 28.04.16
 * Time: 17:39
 */

namespace App\Testing;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Task  whereId_task($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Task  wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Task  whereId_question($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Task  whereId_result($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Task  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Task  whereId($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  on()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Task  toSql()
 *
 */
class Task extends Eloquent{
    protected $table = 'tasks';
    public $timestamps = false;
    protected $fillable = [];
} 