<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Person extends Eloquent {
    protected $table = 'person';
    public $timestamps = false;
}