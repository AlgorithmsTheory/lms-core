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
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirst_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLast_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRole($value)
 *
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNull($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User where($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User  join()
 * @method static \Illuminate\Database\Query\Builder|\App\User  leftJoin()
 * @method static \Illuminate\Database\Query\Builder|\App\User  on()
 * @method static \Illuminate\Database\Query\Builder|\App\User  distinct()
 * @method static \Illuminate\Database\Query\Builder|\App\User  orderBy($column, $sc)
*/

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'group', 'password', 'year'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}