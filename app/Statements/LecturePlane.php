<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.03.2019
 * Time: 20:34
 */

namespace App\Statements;
use Illuminate\Database\Eloquent\Model as Eloquent;

class LecturePlane extends Eloquent
{
    protected $table = 'lecture_plans';
    public $timestamps = false;
    protected $primaryKey = 'id_lecture_plan';
}