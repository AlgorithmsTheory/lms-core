<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 14.04.15
 * Time: 23:35
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Theme  whereTheme_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Theme  whereTheme_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Theme  whereSection_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Theme  whereId_lecture($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  on()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  toSql()
 *
 */
class Theme extends Eloquent {
    protected $table = 'themes';
    public $timestamps = false;
    protected $fillable = ['section_code', 'theme_code'];
} 