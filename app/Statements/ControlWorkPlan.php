<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.03.2019
 * Time: 22:19
 */

namespace App\Statements;
use Illuminate\Database\Eloquent\Model as Eloquent;

class ControlWorkPlan extends Eloquent {
    protected $table = 'control_work_plans';
    public $timestamps = false;
    protected $primaryKey = 'id_control_work_plan';
}