<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 21.02.16
 * Time: 2:37
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;



class Lecture extends Eloquent{
    protected $table = 'lectures';
    public $timestamps = false;
    protected $primaryKey = 'id_lecture';
} 