<?php

namespace App\Http\Middleware;

use App\Result;
use Closure;
use Session;

class SingleTest
{
    /**
     * Запрещает проходить более одного тренировочного теста одновременно
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('test')){                                                                                      //если у пользователя есть открытый тест
            $id_result = Session::get('test');
            $query = Result::whereId_result($id_result)->select('saved_test', 'test_name', 'id_test')->first();
            $test_name = $query->test_name;
            $id_test = $query->id_test;
            $current_test_id = $request->segment(3);
            if ($id_test != $current_test_id) {                                                                         //если начатый тест и текущая страничка не совпадает
                return view('tests.single_test', compact('test_name', 'id_test'));
            }
        }
        return $next($request);
    }
}
