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
        echo json_encode(['right' => $right_answers_count, 'wrong' => $wrong_answers_count]);
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

        echo json_encode(['difficulties' => $difficulties,
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
        echo json_encode($frequencies);
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
        echo json_encode($successes);
    }
}