<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set_date_calendar extends Model
{
    protected $table = 'set_date_calendar';
    public $timestamps = false;
    protected $fillable = ['id','start_date', 'end_date', 'days'];

}
