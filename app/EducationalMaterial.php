<?php
/**
 * Created by PhpStorm.
 * User: oksana.sedova
 * Date: 27.02.2016
 * Time: 13:21
 */

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class EducationalMaterial extends Eloquent {
    protected $table = 'educational_material';
    public $timestamps = false;
}