<?php

namespace App\Emulators;
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserResultNam extends Eloquent {
    protected $table = 'user_result_nam';
    public $timestamps = false;
	protected $fillable = ['*'];
}
