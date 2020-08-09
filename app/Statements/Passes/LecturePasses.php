<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 16.03.2019
 * Time: 20:19
 */

namespace App\Statements\Passes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class LecturePasses extends Eloquent {
    protected $table = 'lecture_passes';
    public $timestamps = false;
    protected $primaryKey = 'id_lecture_pass';

    public static function existPasses($id_user, $id_lecture_plan) {
        return LecturePasses::where([
            ['id_lecture_plan', '=', $id_lecture_plan],
            ['id_user', '=', $id_user]
        ])->exists();
    }
}