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
 * @method static \Illuminate\Database\Query\Builder|\App\Group select($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereGroup_id($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group join($value)
 */

class Group extends Model
{
    protected $table = 'groups';
    public $timestamps = false;
    protected $fillable = ['*'];

}
