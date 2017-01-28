<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 21.11.15
 * Time: 16:44
 */

namespace App\Http\Controllers;


use App\Testing\Test;
use Auth;
use App\Testing\TestForGroup;
use App\Testing\Fine;

class FishController extends Controller {
    /** генерирует страницу со списком доступных тестов */
    public function index(){
        $tr_tests = [];                                                                                                 //массив тренировочных тестов
        $ctr_tests = [];                                                                                                //массив контрольных тестов
        $current_date = date('U');
        $id_group = Auth::user()['group'];
        $query = Test::get();
        foreach ($query as $test){
            if ($test->test_course == 'Рыбина' && $test->visibility == 1 && $test->year == date("Y") && $test->archived == 0) {   //проверка, что тест не из Рыбинских, он видим, он текущего года и он не архивный
                if ($test->test_type == 'Тренировочный'){
                    array_push($tr_tests, $test);
                }
                else {
                    array_push($ctr_tests, $test);
                    $test['max_points'] = Fine::levelToPercent(Fine::whereId(Auth::user()['id'])->whereId_test($test['id_test'])->select('fine')->first()->fine)/100 * $test['total'];

                }
                $start = strtotime(TestForGroup::whereId_group($id_group)->whereId_test($test->id_test)->select('start')->first()->start);
                $end = strtotime(TestForGroup::whereId_group($id_group)->whereId_test($test->id_test)->select('end')->first()->end);
                $test['end'] = TestForGroup::whereId_group($id_group)->whereId_test($test->id_test)->select('end')->first()->end;

                if ($current_date >= $start && $current_date <= $end)                                                   //разделение на текущие и недоступные
                    $test['current'] = 1;
                else
                    $test['current'] = 0;
            }
            $test['amount'] = Test::getAmount($test['id_test']);
        }
        return view('tests.index', compact('tr_tests', 'ctr_tests'));
    }
} 