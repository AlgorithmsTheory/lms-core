<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 22.10.16
 * Time: 18:14
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestForGroup  whereId_test_for_group($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestForGroup  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestForGroup  whereId_group($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestForGroup  whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestForGroup  whereEnd($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  on()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  toSql()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  max($column)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestForGroup  insert($array)
 *
 */

class TestForGroup extends Eloquent{
    protected $table = 'test_for_group';
    public $timestamps = false;
    protected $fillable = ['id_test', 'id_group', 'start', 'end'];
} 