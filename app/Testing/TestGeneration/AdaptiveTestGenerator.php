<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 10:43
 */

namespace App\Testing\TestGeneration;


use App\Testing\Adaptive\BolognaMark;
use App\Testing\Adaptive\KnowledgeLevel;
use App\Testing\Adaptive\QuestionClass;
use App\Testing\Test;

class AdaptiveTestGenerator implements TestGenerator {

    /**
     * @var KnowledgeLevel from user info
     */
    private $student_knowledge_level;

    /**
     * @var BolognaMark that student expects
     */
    private $student_expected_mark;

    /**
     * @var int pre calculated value
     */
    private $mean_difficulty;

    /**
     * @var int
     */
    private $current_question_number;

    /**
     * @var int sum of difficulties of passed questions
     */
    private $current_difficulty_sum;

    /**
     * @var QuestionClass student belongs to
     */
    private $current_class;

    /**
     * @var int 0 if main phase is active, 1 if extra
     */
    private $current_phase;

    /**
     * @var AdaptiveQuestionPool
     */
    private $question_pool;

    /**
     * @var AdaptiveRecord[] formed by Ford-Fulkerson algorithm
     */
    private $chosen_records = [];

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