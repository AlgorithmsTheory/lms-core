<?php
/**
 * Created by PhpStorm.
 * Bruser: Станислав
 * Date: 14.04.15
 * Time: 23:35
 */

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Bruser
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Bruser  whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bruser  wherePassword($value)
 * @method static \Illuminate\Database\Eloquent|\App\Bruser  get()
 * @method static \Illuminate\Database\Eloquent|\App\Bruser  where()
 * @method static \Illuminate\Database\Eloquent|\App\Bruser  select()
 * @method static \Illuminate\Database\Eloquent|\App\Bruser  first()
 */
class Bruser extends Eloquent {
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = ['name', 'password'];
}