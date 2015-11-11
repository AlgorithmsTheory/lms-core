<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 14.04.15
 * Time: 23:35
 */

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Theme  whereTheme($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Theme  whereSection($value)
 * @method static \Illuminate\Database\Eloquent|\App\Theme  get()
 * @method static \Illuminate\Database\Eloquent|\App\Theme  where()
 * @method static \Illuminate\Database\Eloquent|\App\Theme  select()
 * @method static \Illuminate\Database\Eloquent|\App\Theme  first()
 *
 */
class Theme extends Eloquent {
    protected $table = 'themes';
    public $timestamps = false;
    protected $fillable = ['section', 'theme'];
} 