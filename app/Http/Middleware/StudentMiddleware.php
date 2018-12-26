<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 26.05.16
 * Time: 12:35
 */

namespace App\Http\Middleware;


use Auth;
use Closure;

class StudentMiddleware {
    /**
     * Обеспечивает допуск только студентам
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Http\Middleware\Closure|callable $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()['role'] == 'Студент' || Auth::user()['role'] == 'Админ') {
            return $next($request);
        }
        else return redirect()->route('no_access');
    }
} 