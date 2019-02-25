<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Person extends Eloquent {
    protected $table = 'persons';
    public $timestamps = false;
}