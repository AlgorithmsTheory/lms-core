<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGroup($value)
 */

class Seminars extends Model
{
    protected $table = 'seminars';
    public $timestamps = false;
    protected $fillable = ['*'];

}