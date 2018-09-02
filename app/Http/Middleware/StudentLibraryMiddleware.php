<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class StudentLibraryMiddleware
{

    public function handle($request, Closure $next)
    {
        if ((Auth::user()['role'] != 'Админ') and (Auth::user()['role'] != 'Преподаватель')){
            return $next($request);
        }
        else return redirect()->route('no_access');
    }
}
