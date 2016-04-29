<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 29.04.16
 * Time: 19:56
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord whereTheme_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereSection_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereType_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereId_structure($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  distinct()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  toSql()
 *
 */

class StructuralRecord extends Eloquent{
    protected $table = 'structural_records';
    public $timestamps = false;
    protected $fillable = [];
} 