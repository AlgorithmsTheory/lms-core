<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 21.10.2017
 * Time: 14:44
 */

namespace App\Http\Middleware;


use App\Testing\TestForGroup;
use App\User;
use Auth;
use Closure;

class AccessForLibrary {
    public function handle($request, Closure $next)
    {
        $group = Auth::user()['group'];
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $isAdmin = $role === 'Админ' || $role === 'Преподаватель';
        $available_control_tests_number = TestForGroup::whereId_group($group)
            ->whereAvailability(1)
            ->join('tests', 'test_for_group.id_test', '=', 'tests.id_test')
            ->where('tests.test_type', '=', 'Контрольный')
            ->count();
        if (!$isAdmin && $available_control_tests_number > 0) {
            $message = 'Лекции не доступны на время проведения контрольной';
            return redirect()->route('no_access', compact('message'));
        }
        return $next($request);
    }
}