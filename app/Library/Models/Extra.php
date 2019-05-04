<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 04.05.2019
 * Time: 18:26
 */

namespace App\Library\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Extra extends Eloquent
{
    protected $table = 'extras';
    protected $primaryKey = 'id_extra';
    public $timestamps = false;
}