<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGroup($value)
 */

class Lectures extends Model
{
    protected $table = 'statements_lectures';
    public $timestamps = false;
    protected $fillable = ['*'];

}