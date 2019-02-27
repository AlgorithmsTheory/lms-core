<?php

namespace App\Emulators;
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserResultRam extends Eloquent {
    protected $table = 'user_result_ram';
    public $timestamps = false;
	protected $fillable = ['*'];
}