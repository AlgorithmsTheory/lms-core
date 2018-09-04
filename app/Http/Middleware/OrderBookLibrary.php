<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
class OrderBookLibrary
{

    public function handle($request, Closure $next)
    {
        $genre_book = DB::table('book')->leftJoin('genres_books', 'book.genre_id', '=','genres_books.id')
            ->where('book.id','=', $request->id)
            ->select('genres_books.name')->first();
        $genre_book = $genre_book->name;

        $studentStatus = DB::select('SELECT groups.archived FROM users LEFT JOIN `groups`
 ON users.group = groups.group_id where users.id = ?', [Auth::user()['id']]);
        $studentStatus = $studentStatus[0]->archived;
        if ((Auth::user()['role'] == 'Студент' and $studentStatus == 0) ){
                return $next($request);
        }elseif (Auth::user()['role'] == 'Студент' and $studentStatus != 0 and $genre_book != "Теория алгоритмов и сложности вычислений" and
                $genre_book != "Дискретная математика"){
            return $next($request);
        }elseif (Auth::user()['role'] != 'Студент' and Auth::user()['role'] != 'Админ' and $genre_book != "Теория алгоритмов и сложности вычислений" and
                $genre_book != "Дискретная математика"){
            return $next($request);
        }else return redirect()->route('no_access');

    }
}
