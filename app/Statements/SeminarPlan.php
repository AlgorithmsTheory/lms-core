<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.03.2019
 * Time: 22:10
 */

namespace App\Statements;
use Illuminate\Database\Eloquent\Model as Eloquent;

class SeminarPlan extends Eloquent
{
    protected $table = 'seminar_plans';
    public $timestamps = false;
    protected $primaryKey = 'id_seminar_plan';
}