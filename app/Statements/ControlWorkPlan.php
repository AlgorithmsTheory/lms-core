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
    protected $appends = ['test'];

    /** в новое поле test вставляется объект типа Tests */
    public function getTestAttribute(){
        $test = Test::where('id_test','=', $this->attributes['id_test'])->first();
        return $test;
    }
}