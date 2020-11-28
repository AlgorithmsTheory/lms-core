<?php

namespace App\Http\Middleware;

use App\Testing\Result;
use Auth;
use Closure;

class SingleTest
{
    /**
     * Запрещает проходить более одного теста одновременно
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id_test_new = $request->route('id_test');
        $active_result = Result::whereId(Auth::user()['id'])->whereResult(null)->select('id_test')->first();
        if ($active_result){
            $id_test = $active_result->id_test;
            $current_test_id = $request->segment(3);
            if ($id_test != $current_test_id) {
                return redirect()->route('single_test', compact('id_test', 'id_test_new'));
            }
        }
        return $next($request);
    }
}
