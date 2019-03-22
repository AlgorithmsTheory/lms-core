<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.03.2019
 * Time: 22:19
 */

namespace App\Statements;
use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Testing\Test;

class ControlWorkPlan extends Eloquent
{
    protected $table = 'control_work_plans';
    public $timestamps = false;
    protected $primaryKey = 'id_control_work_plan';
    protected $appends = ['tests'];

    /** в новое поле tests вставляется массив объектов Tests */
    public function getTestsAttribute(){

        $testArray = array();
        $tests = Test::select('id_test','test_name')->get();
        foreach ($tests as $test) {
            $testArray[$test->id_test] = $test->test_name;
        }
        return $testArray;
    }
}