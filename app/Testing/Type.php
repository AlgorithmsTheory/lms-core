<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 28.04.16
 * Time: 17:48
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Type  whereType_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Type  whereType_name($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  on()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Type  toSql()
 *
 */

class Type extends Eloquent{
    protected $table = 'types';
    public $timestamps = false;
    protected $fillable = [];
} 