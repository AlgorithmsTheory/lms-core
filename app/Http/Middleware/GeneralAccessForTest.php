<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 17.09.2017
 * Time: 22:26
 */

namespace App\Http\Middleware;


use App\Testing\Test;
use App\Testing\TestForGroup;
use Auth;
use Closure;
use Illuminate\Http\Request;

class GeneralAccessForTest {
    public function handle(Request $request, Closure $next) {
        $id_test = strrev(explode('/',strrev($request->url()))[0]);
        $test = Test::whereId_test($id_test)->first();
        if (!$test->visibility) {
            $message = "Тест не доступен в данный момент";
            return redirect()->route('no_access', compact('message'));
        }
        if ($test->archived) {
            $message = "Тест удален";
            return redirect()->route('no_access', compact('message'));
        }
        if ($test->only_for_print) {
            $message = "Тест предназначен только для печатной версии";
            return redirect()->route('no_access', compact('message'));
        }
        $availability_for_group = TestForGroup::whereId_group(Auth::user()['group'])
            ->whereId_test($id_test)
            ->select('availability')->first()->availability;
        if (!$availability_for_group) {
            $message = "Тест не доступен для вашей группы";
            return redirect()->route('no_access', compact('message'));
        }
        return $next($request);
    }
}