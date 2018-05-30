<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 29.05.2018
 * Time: 22:34
 */

namespace App\Http\Controllers;


use App\Testing\Question;
use App\Testing\TestTask;

class DataUpdateController extends Controller {
    public function initDifficulty() {
        $points_sum = 0;
        $points_quadratic_sum = 0;
        $student_level_sum = 0;
        $student_level_quadratic_sum = 0;
        $questions = Question::where('section_code', '>', 0)->get();
        foreach ($questions as $question) {
            $tasks = TestTask::whereId_question($question['id_question'])->get();
        }
    }
}