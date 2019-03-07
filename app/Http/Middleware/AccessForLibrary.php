<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 21.10.2017
 * Time: 14:44
 */

namespace App\Http\Middleware;


use App\Emulators\EmrForGroup;
use App\Testing\TestForGroup;
use Auth;
use Closure;

class AccessForLibrary {
    public function handle($request, Closure $next)
    {
        $group = Auth::user()['group'];
        $available_control_tests_number = TestForGroup::whereId_group($group)
            ->whereAvailability(1)
            ->join('tests', 'test_for_group.id_test', '=', 'tests.id_test')
            ->where('tests.test_type', '=', 'Контрольный')
            ->count();
		$available_emulators = EmrForGroup::whereGroup_id($group)->whereAvailability(1)->count();
        if ($available_control_tests_number > 0 || $available_emulators > 0) {
            $message = 'Лекции не доступны на время проведения контрольной';
            return redirect()->route('no_access', compact('message'));
        }
        return $next($request);
    }
}