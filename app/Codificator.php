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
 * @method static \Illuminate\Database\Query\Builder|\App\Codificator whereId_codificator($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Codificator  whereCodificator_type($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Codificator  whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Codificator  whereCode($value)
 * @method static \Illuminate\Database\Eloquent|\App\Codificator  get()
 * @method static \Illuminate\Database\Eloquent|\App\Codificator  where()
 * @method static \Illuminate\Database\Eloquent|\App\Codificator  select()
 * @method static \Illuminate\Database\Eloquent|\App\Codificator  first()
 * @method static \Illuminate\Database\Eloquent|\App\Codificator  join($value)
 *
 */
class Codificator extends Eloquent {
    protected $table = 'codificators';
    public $timestamps = false;
    protected $fillable = ['codificator_type', 'value', 'code'];
} 