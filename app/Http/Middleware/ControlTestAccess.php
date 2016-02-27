<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 27.02.16
 * Time: 20:51
 */

namespace App\Http\Middleware;


use App\Fine;
use App\Test;
use Auth;
use Closure;
use Illuminate\Http\Request;

/** Проверяет наличие попытки прохождения контрольного теста */
class ControlTestAccess {
    public function handle(Request $request, Closure $next)
    {
        $fine_class = new Fine();
        $id_test = strrev(explode('/',strrev($request->url()))[0]);
        $query_test = Test::whereId_test($id_test)->first();
        if ($query_test->test_type == 'Контрольный'){
            $query = Fine::whereId_test($id_test)->whereId_user(Auth::user()['id'])->select('fine','access')->first();
            if (!$query->access && !is_null($query)){                                                                                   // если попытки нет
                $fine = $query->fine;
                $factor = $fine_class->countFactor($fine);
                $max_test_points = $factor * $query_test->total;                                                        //наибольшее число баллов за этот тест при следующей попытке
                return view('tests.no_attempts', compact('max_test_points'));
            }
        }
        return $next($request);
    }
} 