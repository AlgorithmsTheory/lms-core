<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 15:56
 */

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Test whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTest_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTest_time($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereStructure($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTotal($value)
 * @method static \Illuminate\Database\Eloquent|\App\Test  get()
 * @method static \Illuminate\Database\Eloquent|\App\Test  where()
 * @method static \Illuminate\Database\Eloquent|\App\Test  select()
 * @method static \Illuminate\Database\Eloquent|\App\Test  first()
 * @method static \Illuminate\Database\Eloquent|\App\Test  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Test  table($array)
 *
 */
class Test extends Eloquent {
    protected $tests = 'tests';
    public $timestamps = false;
    protected $fillable = ['test_name', 'amount', 'test_time', 'start', 'end', 'structure', 'total'];
} 