<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 10:43
 */

namespace App\Testing\TestGeneration;


use App\Testing\Test;

class AdaptiveTestGenerator implements TestGenerator {

    private $student_knowledge_level;

    private $student_expected_mark;

    private $mean_difficulty;

    private $current_question_number;

    private $current_difficulty_sum;

    private $current_class;

    private $current_phase;

    public function generate(Test $test) {

    }

    public function chooseQuestion() {

    }

    private function getCurrentExpectedPointsSum() {
        return $this->mean_difficulty * $this->current_question_number;
    }

    private function getCurrentTrajectoryDistance() {
        return $this->current_difficulty_sum - $this->getCurrentExpectedPointsSum();
    }
}