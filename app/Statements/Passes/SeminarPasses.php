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
}