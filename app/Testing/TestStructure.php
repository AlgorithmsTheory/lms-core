<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 29.04.16
 * Time: 19:38
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestStructure  whereId_structure($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestStructure  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\TestStructure  whereAmount($value)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  on()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  toSql()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  max($column)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\TestStructure  insert($array)
 *
 */

class TestStructure extends Eloquent{
    protected $table = 'test_structures';
    public $timestamps = false;
    protected $fillable = [];

    public static function add($id_test, $amount, $section, $theme, $type){
        $id_structure = TestStructure::max('id_structure')+1;
        TestStructure::insert(array('id_structure' => $id_structure, 'id_test' => $id_test, 'amount' => $amount));
        StructuralRecord::add($id_structure, $section, $theme, $type);
    }
} 