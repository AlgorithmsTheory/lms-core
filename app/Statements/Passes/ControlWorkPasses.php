<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 16.03.2019
 * Time: 20:19
 */

namespace App\Statements\Passes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class ControlWorkPasses extends Eloquent {
    protected $table = 'control_work_passes';
    public $timestamps = false;
    protected $primaryKey = 'id_control_work_pass';

    public static function existPasses($id_user, $id_control_work_plan) {
        return ControlWorkPasses::where([
            ['id_control_work_plan', '=', $id_control_work_plan],
            ['id_user', '=', $id_user]
        ])->exists();
    }
}