<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 15:56
 */

namespace App\Testing;
use App\Control_test_dictionary;
use App\Controls;
use App\Group;
use App\Totalresults;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_course($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_type($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_time($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereVisibility($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereMultilanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereOnly_for_print($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereIs_adaptive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereMax_questions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  where($column, $operator, $value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  distinct()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  toSql()
 *
 */
class Test extends Eloquent {
    const GROUP_AMOUNT = 3;                                                                                             // число вопросов в групповых вопросах
    protected $tests = 'tests';
    protected $fillable = ['test_name', 'amount', 'test_time', 'start', 'end', 'structure', 'total'];
    public $timestamps = false;

    public static function getAmount($id_test){
        return TestStructure::whereId_test($id_test)->sum('amount');
    }


    public static function isFinishedForGroup($id_test, $id_group){
        $users_not_pass_test = User::whereRole('Студент')
        ->whereGroup($id_group)
            ->whereRaw("not exists (select `id` from `fines`
                                        where `fines`.id = `users`.id
                                        and `fines`.`id_test` = ".$id_test. "
                                        and `fines`.access = 0)")
            ->distinct()
            ->select()
            ->get();
        if (sizeof($users_not_pass_test) == 0)
            return true;
        else
            return false;
    }


    public static function isFinished($id_test) {
        $groups = Group::where('group_name', '<>', 'Админы')
            ->where('archived', '=', 0)
            ->get();
        foreach ($groups as $group) {
            if (!Test::isFinishedForGroup($id_test, $group['id_group'])) {
                return false;
            }
        }
        return true;
    }


    public static function finishTestForGroup($id_test, $id_group){
        $fine = new Fine();
        $absents = User::whereRole('Студент')                                                                      //пример сырого запроса
            ->whereGroup($id_group)
            ->whereRaw("not exists (select `id` from `fines`
                                        where `fines`.id = `users`.id
                                        and `fines`.`id_test` = ".$id_test. "
                                        and `fines`.access = 0)")
            ->distinct()
            ->select()
            ->get();

        foreach ($absents as $user){
            //добавить их в таблицу штрафов, записав им первый уровень штрафа
            //в таблице штрафов присвоить всем по этому тесту досутп 0, у кого досутп есть
            $fine_query = Fine::whereId($user->id)->whereId_test($id_test)->get();
            if (count($fine_query) == 0) {
                Fine::insert(['id' => $user->id, 'id_test' => $id_test,
                    'fine' => 1, 'access' => 0]);
            }
            else {
                Fine::whereId($user->id)->whereId_test($id_test)
                    ->update(['fine' => $fine->maxFine($fine_query[0]->fine + 1), 'access' => 0]);
            }
            //добавить их в таблицу результатов, записав в качестве результатов -2 -2 absence
            $result_date = date("Y-m-d H:i:s");
            Result::insert(['id' => $user->id, 'id_test' => $id_test,
                'result_date' => $result_date,
                'result' => -2, 'mark_ru' => -2, 'mark_eu' => 'absent', 'saved_test' => null]);
            Test::addToStatements($id_test, $user->id, 0);

        }
        TestForGroup::whereId_test($id_test)->whereId_group($id_group)->update(['availability' => 0]);
    }


    public static function finishTest($id_test) {
        $groups = Group::where('group_name', '<>', 'Админы')
            ->where('archived', '=', 0)
            ->get();
        foreach ($groups as $group){
            Test::finishTestForGroup($id_test, $group['id_group']);
        }
    }


    /** Возвращает 1, если тест уже был пройден хотя бы один раз, 0 - иначе */
    public static function isResolved($id_test){
        $result = 0;
        $rows = Result::whereId_test($id_test)->count();
        if ($rows != 0 ){
            $result = 1;
        }
        return $result;
    }


    /** вычисляет оценку по Болонской системе, если дан максимально возможный балл и реальный */
    public static function calcMarkBologna($max, $real){
        if ($real < $max * 0.6){
            return 'F';
        }
        if ($real >= $max * 0.6 && $real < $max * 0.65){
            return 'E';
        }
        if ($real >= 0.65 && $real < $max * 0.75){
            return 'D';
        }
        if ($real >= 0.75 && $real < $max * 0.85){
            return 'C';
        }
        if ($real >= 0.85 && $real < $max * 0.9){
            return 'B';
        }
        if ($real >= 0.9){
            return 'A';
        }
    }

    /** вычисляет оценку по обычной 5-тибалльной шкале, если дан максимально возможный балл и реальный */
    public static function calcMarkRus($max, $real){
        if ($real < $max * 0.6){
            return '2';
        }
        if ($real >= $max * 0.6 && $real < $max * 0.7){
            return '3';
        }
        if ($real >= 0.7 && $real < $max * 0.9){
            return '4';
        }
        if ($real >= 0.9){
            return '5';
        }
    }


    /**  метод, проверяющий, является ли тест одним из контрольных. В случаи если является, добавляет его результат в ведомость. */
    public static function addToStatements($id_test, $id_user, $score){
        $dictionary = Control_test_dictionary::where('id', 1)->first();
        switch ($id_test) {
            case $dictionary['test1']:
                Controls::where('userID', $id_user)->update(['test1' => $score]);
                break;
            case $dictionary['test2']:
                Controls::where('userID', $id_user)->update(['test2' => $score]);
                break;
            case $dictionary['test3']:
                Controls::where('userID', $id_user)->update(['test3' => $score]);
                break;
            case $dictionary['exam']:
                Totalresults::where('userID', $id_user)->update(['exam' => $score]);
                break;
        }
        return 0;
    }

    /** Проверяет доступ к контрольному тесту исходя из роли пользователя */
    public static function isControlTestAccess($id_user){
        $role = User::whereId($id_user)->select('role')->first()->role;
        if ($role == '' || $role == 'Обычный'){
            return false;
        }
        else
            return true;
    }

    public static function getMean($id_test) {
        $results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)->select('result')->get();
        $sum_results = 0;
        foreach ($results as $result) {
            $sum_results += $result['result'];
        }
        if (count($results) > 0) return $sum_results / count($results);
        else return -1;
    }

    public static function getMedian($id_test) {
        $results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)->select('result')->orderBy('result')->get()->all();
        $median_index = count($results) / 2;
        return $results[$median_index]->result;
    }

    public static function getVariance($id_test) {
        $results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)->select('result')->get();
        $mean = Test::getMean($id_test);
        $sum_results = 0;
        foreach ($results as $result) {
            $sum_results += ($result['result'] - $mean) * ($result['result'] - $mean);
        }
        if (count($results) > 0) return $sum_results / count($results);
        else return -1;
    }

    public static function getReliability($id_test) {
        $odd_points = [];
        $even_points = [];
        $results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)->select('id_result', 'result')->get();
        foreach ($results as $result) {
            $tasks = TestTask::whereId_result($result->id_result)->select('points', 'id_question')->get()->all();
            $real_odd_points_sum = 0;
            $max_odd_points_sum = 0;
            $real_even_points_sum = 0;
            $max_even_points_sum = 0;
            for ($i = 0; $i < count($tasks) - 1; $i+=2) {
                $max_even_points_sum += Question::whereId_question($tasks[$i]->id_question)->select('points')->first()->points;
                $real_even_points_sum += $tasks[$i]->points;
                $max_odd_points_sum += Question::whereId_question($tasks[$i+1]->id_question)->select('points')->first()->points;
                $real_odd_points_sum += $tasks[$i+1]->points;
            }
            array_push($odd_points, $real_odd_points_sum * 100 / $max_odd_points_sum);
            array_push($even_points, $real_even_points_sum * 100 / $max_even_points_sum);
        }

        $number = count($odd_points);
        if ($number > 0) {

            $sum_odd_points = 0;
            $sum_even_points = 0;
            $sum_odd_and_even = 0;
            $sum_quadratic_odd_points = 0;
            $sum_quadratic_even_points = 0;
            for ($i = 0; $i < count($odd_points); $i++) {
                $sum_odd_points += $odd_points[$i];
                $sum_even_points += $even_points[$i];
                $sum_odd_and_even += $odd_points[$i] * $even_points[$i];
                $sum_quadratic_odd_points += $odd_points[$i] * $odd_points[$i];
                $sum_quadratic_even_points += $even_points[$i] * $even_points[$i];
            }

            $division = ($number * $sum_odd_and_even) - ($sum_odd_points * $sum_even_points);
            $divider = sqrt(($number * $sum_quadratic_odd_points - pow($sum_odd_points, 2)) *
                ($number * $sum_quadratic_even_points - pow($sum_even_points, 2)));

            if ($divider != 0) return $division / $divider;
        }
        return -2;
    }
} 