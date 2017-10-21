<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 27.02.16
 * Time: 20:51
 */

namespace App\Http\Middleware;

use App\Testing\Fine;
use App\Testing\Test;
use Auth;
use Closure;
use Illuminate\Http\Request;

/** Проверяет наличие попытки прохождения контрольного теста */
class StudentAccessForTest {
    public function handle(Request $request, Closure $next)
    {
        $fine_class = new Fine();
        $id_test = strrev(explode('/',strrev($request->url()))[0]);
        $query_test = Test::whereId_test($id_test)->first();
        if ($query_test->test_type == 'Контрольный'){
            $query = Fine::whereId_test($id_test)->whereId(Auth::user()['id'])->select('fine','access')->first();
            $total = $query_test->total;
            if (!is_null($query) && !$query->access){                                                                                   // если попытки нет
                $fine = $query->fine;
                $factor = $fine_class->countFactor($fine);
                $max_test_points = $factor * $query_test->total;                                                        //наибольшее число баллов за этот тест при следующей попытке
                return redirect()->route('no_attempts', compact('max_test_points', 'total'));
            }
        }
        return $next($request);
    }
} 