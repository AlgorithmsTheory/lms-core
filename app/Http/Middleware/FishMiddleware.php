<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class FishMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()['role'] == 'Админ' || (Auth::user()['role'] == 'Рыбинец')){
            return $next($request);
        }
        else {
            $message = 'Страница не доступна пользователю с вашими правами';
            return view('no_access', compact('message'));
        }
    }
}
