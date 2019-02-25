<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lectures extends Model
{
    protected $table = 'statements_lectures';
    public $timestamps = false;
    protected $fillable = ['*'];

}