<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Kontr_work extends Eloquent {
    protected $table = 'kontr_rab';
    public $timestamps = false;
	protected $fillable = ['id', 'name', 'start_date', 'finish_date'];
}