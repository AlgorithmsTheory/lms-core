<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 16.03.2019
 * Time: 20:19
 */

namespace App\Statements\Passes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class SeminarPasses extends Eloquent {
    protected $table = 'seminar_passes';
    public $timestamps = false;
    protected $primaryKey = 'id_seminar_pass';

    public static function existPasses($id_user, $id_seminar_plan) {
        return SeminarPasses::where([
            ['id_seminar_plan', '=', $id_seminar_plan],
            ['id_user', '=', $id_user]
        ])->exists();
    }
}