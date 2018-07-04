<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
class StudentCabinetLibrary
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
        if ((Auth::user()['role'] == 'Студент') ){
            $studentStatus = DB::select('SELECT groups.archived FROM users LEFT JOIN `groups`
 ON users.group = groups.group_id where users.id = ?', [Auth::user()['id']]);
            $studentStatus = $studentStatus[0]->archived;
            if ($studentStatus == 0){
                return $next($request);
            }else{
                return redirect()->route('no_access');
            }
        }
        else return redirect()->route('no_access');


    }
}
