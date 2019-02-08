<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserResultPost extends Eloquent {
    protected $table = 'user_result_post';
    public $timestamps = false;
	protected $fillable = ['*'];
}