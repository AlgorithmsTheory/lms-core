<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserResultTur extends Eloquent {
    protected $table = 'user_result_tur';
    public $timestamps = false;
	protected $fillable = ['*'];
}
