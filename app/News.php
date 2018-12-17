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
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 */

class News extends Model
{
    protected $table = 'news';
    public $timestamps = false;
    protected $fillable = ['id', 'title', 'body', 'is_visible', 'type', 'file_path'];

}
