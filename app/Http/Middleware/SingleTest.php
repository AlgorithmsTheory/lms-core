<?php

namespace App\Http\Middleware;

use App\Testing\Result;
use App\Testing\Test;
use Closure;
use Session;

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
        if (Session::has('test')){                                                                                      //если у пользователя есть открытый тест
            $id_result = Session::get('test');
            $query = Result::whereId_result($id_result)->select('saved_test', 'id_test')->first();
            $id_test = $query->id_test;
            $test_name = Test::whereId_test($id_test)->select('test_name')->first()->test_name;
            $current_test_id = $request->segment(3);
            if ($id_test != $current_test_id) {                                                                         //если начатый тест и текущая страничка не совпадает
                return view('tests.single_test', compact('test_name', 'id_test'));
            }
        }
        return $next($request);
    }
}
