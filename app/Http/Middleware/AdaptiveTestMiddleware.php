<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 17.12.18
 * Time: 12:27
 */

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdaptiveTestMiddleware {
    /**
     * Check adaptive test has been initialized
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $student_id = Auth::user()['id'];
        if (!$request->session()->has('adaptive_test_'.$student_id)) {
            return redirect()->route('prepare_adaptive_test');
        }
        return $next($request);
    }
}