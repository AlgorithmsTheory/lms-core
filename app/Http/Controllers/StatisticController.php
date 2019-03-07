<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 11.06.2018
 * Time: 20:08
 */

namespace App\Http\Controllers;


use App\Group;
use App\Testing\Question;
use App\Testing\Result;
use App\Testing\TestTask;
use App\Testing\Type;

class StatisticController extends Controller {

    /** Успешность решения вопроса */
    public function getSuccess($id_question) {
        $right_answers_count = 0;
        $wrong_answers_count = 0;

        $question = Question::whereId_question($id_question)->select('points', 'difficulty')->first();
        $max_points = $question->points;
        $tasks = TestTask::whereId_question($id_question)->select('points')->get();
        foreach ($tasks as $task) {
            if (Question::isAnsweredRight($task->points, $max_points)) $right_answers_count++;
            else $wrong_answers_count++;
        }
        return json_encode(['right' => $right_answers_count, 'wrong' => $wrong_answers_count]);
    }

    /** Сложность и дискриминант вопроса */
    public function getDifficultyAndDiscriminant($id_question) {
        $difficulties = [];
        $discriminants = [];
        $current_difficulty = [];
        $current_discriminant = [];
        $questions = Question::where('section_code', '>', 0)
            ->where('id_question', '<>', $id_question)
            ->whereRaw("type_code in (select type_code from types where only_for_print = 0)")
            ->select('difficulty', 'discriminant')->get();
        foreach($questions as $question) {
            array_push($difficulties, $question->difficulty);
            array_push($discriminants, $question->discriminant);
        }

        $current_question = Question::whereId_question($id_question)->select('difficulty', 'discriminant')->first();
        array_push($current_difficulty, $current_question->difficulty);
        array_push($current_discriminant, $current_question->discriminant);

        return json_encode(['difficulties' => $difficulties,
                          'discriminants' => $discriminants,
                          'current_difficulty' => $current_difficulty,
                          'current_discriminant' => $current_discriminant]);
    }

    /** Частота выпадения конкретного вопроса по месяцам */
    public function getFrequencyByMonth($id_question) {
        $frequencies = ['september' => 0, 'october' => 0, 'november' => 0, 'december' => 0, 'january' => 0, 'february' => 0, 'others' => 0];
        $tasks = TestTask::whereId_question($id_question)->select('id_result')->get();
        foreach ($tasks as $task) {
            $result_date = Result::whereId_result($task->id_result)->select('result_date')->first()->result_date;
            $parsed_date = date_parse_from_format("Y-m-d H:i:s", $result_date);
            switch ($parsed_date['month']) {
                case '01':
                    $frequencies['january']++;
                    break;
                case '02':
                    $frequencies['february']++;
                    break;
                case '09':
                    $frequencies['september']++;
                    break;
                case '10':
                    $frequencies['october']++;
                    break;
                case '11':
                    $frequencies['november']++;
                    break;
                case '12':
                    $frequencies['december']++;
                    break;
                default:
                    $frequencies['others']++;
            }
        }
        return json_encode($frequencies);
    }

    /** Успешность решения вопроса по учебным группам  */
    public function getGroupSuccess($id_question) {
        $successes = [];
        $groups = Group::whereArchived(0)->whereAcademic(1)->select('group_id', 'group_name')->get();
        $i = 0;
        foreach ($groups as $group) {
            $right_answers_count = 0;
            $wrong_answers_count = 0;

            $question = Question::whereId_question($id_question)->select('points', 'difficulty')->first();
            $max_points = $question->points;
            $tasks = TestTask::whereId_question($id_question)
                ->join('results', 'test_tasks.id_result', 'results.id_result')
                ->whereRaw("results.id in (select id from users where `group` = " . $group->group_id . ")")
                ->select('test_tasks.points')->get();
            foreach ($tasks as $task) {
                if (Question::isAnsweredRight($task->points, $max_points)) $right_answers_count++;
                else $wrong_answers_count++;
            }
            $successes[$i]['group'] = $group->group_name;
            $successes[$i]['total'] = $right_answers_count + $wrong_answers_count;
            $successes[$i]['success'] = $right_answers_count;
            $i++;
        }
        return json_encode($successes);
    }

    /** Результаты за тест по Болонской системе */
    public function getResults($id_test) {
        $results = [];
        $test_results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)->select('mark_eu')->get();
        foreach ($test_results as $result) {
            $results[$result->mark_eu]++;
        }
        return json_encode($results);
    }

    /** Результаты за тест по Болонской системе для конкретной группы */
    public function getResultsForGroup($id_test, $id_group) {
        $results = [];
        $test_results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)
            ->join('users', 'users.id', 'results.id')
            ->whereRaw("users.`group` in (select group_id from groups where `group` = " . $id_group . ")")
            ->select('results.mark_eu')->get();
        foreach ($test_results as $result) {
            $results[$result->mark_eu]++;
        }
        return json_encode($results);
    }

    /** Частота выпадения разных типов вопросов в тесте */
    public function getQuestionTypeFrequencyInTest($id_test) {
        $type_freq = [];
        $types = Type::whereOnly_for_print(0)->select('type_name')->get();
        foreach ($types as $type) {
            $type_freq[$type->type_name] = 0;
        }

        $results = Result::whereId_test($id_test)->whereNotNull('result')->where('result', '<>', -1)->where('result', '<>', -2)->select('id_result')->get();
        foreach ($results as $result) {
            $tasks = TestTask::whereId_result($result->id_result)->select('id_question')->get();
            foreach ($tasks as $task) {
                $question_type = Question::whereId_question($task->id_question)
                    ->join('types', 'questions.type_code', 'types.type_code')
                    ->select('types.type_name')->first()->type_name;
                $type_freq[$question_type]++;
            }
        }
        return json_encode($type_freq);
    }
}