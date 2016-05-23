<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminMiddleware
{
    /**
     * Обеспечивает допуск только администраторам
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((Auth::user()['role'] == 'Админ') or (Auth::user()['role'] == 'Преподаватель')){
            return $next($request);
        }
        else return view('no_access');
    }
}
