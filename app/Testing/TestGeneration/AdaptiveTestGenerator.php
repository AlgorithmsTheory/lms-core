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
use App\Testing\Adaptive\Weights;
use App\Testing\Result;
use App\Testing\Test;
use App\User;
use Auth;

class AdaptiveTestGenerator implements TestGenerator {

    /**
     * @var KnowledgeLevel from user info
     */
    private $student_knowledge_level;

    /**
     * @var BolognaMark expected student mark fot the test
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

    public function __construct($mark_expected_by_student) {
        $student_id = Auth::user()['id'];
        $this->student_knowledge_level = User::whereId($student_id)
            ->select('knowledge_level')->first()->knowledge_level;
        $this->student_expected_mark = $this->evalStudentExpectedMark($mark_expected_by_student, $student_id);


    }

    public function generate(Test $test) {

    }

    public function chooseQuestion() {

    }

    private function evalStudentExpectedMark($mark_expected_by_student, $student_id) {
        $mark_expected_by_system = $this->evalExpectedBySystemMark($student_id);
        if ($mark_expected_by_student == 'Нет') return $mark_expected_by_system;
        return Weights::MARK_EXPECTED_BY_STUDENT_FACTOR * $mark_expected_by_student +
               Weights::MARK_EXPECTED_BY_SYSTEM_FACTOR * $mark_expected_by_system;
    }

    private function evalExpectedBySystemMark($id_student) {
        $remote_activity = $this->evalRemoteActivity($id_student);
        $classroom_activity = $this->evalClassroomActivity();
        return min(max(0, $remote_activity + $classroom_activity), 1);
    }

    private function evalRemoteActivity($id_student) {
        // TODO: for section test we need tale t account only this section trained tests ?
        $results = Result::whereId($id_student)
            ->join('tests', 'results.id_test', '=', 'tests.id_test')
            ->where("tests,test_type", '=', 'Тренировочный')
            ->select('results.result as result', 'tests.total as total')
            ->orderBy('results.id_result');
        $remote_activity = 0;
        $counter = 0;
        $results_size = sizeof($results);
        $interval_length = $this->evalIntervalLength($results_size);
        $first_factor = $this->evalFirstFactor($results_size, $interval_length);
        foreach ($results as $result) {
            $normalized_result = $result['result'] / $result['total'];
            $test_factor = $this->evalTrainTestFactor($first_factor, $interval_length, ++$counter);
            $remote_activity += $normalized_result * $test_factor;
        }
        return $remote_activity;
    }

    private function evalIntervalLength($results_size) {
        $index_sum = 0;
        for ($i = 1; $i <= $results_size - 1; $i++) {
            $index_sum += $i;
        }
        return min(1 / $index_sum, Weights::MAX_TRAIN_TEST_INTERVAL_LENGTH);
    }

    private function evalFirstFactor($results_size, $interval_length) {
        $index_sum = 0;
        for ($i = 1; $i <= $results_size - 1; $i++) {
            $index_sum += $i;
        }
        return (1 - $interval_length * $index_sum) / $results_size;
    }

    private function evalTrainTestFactor($first_factor, $interval_length, $test_order) {
        return $first_factor + ($test_order - 1) * $interval_length;
    }

    private function evalClassroomActivity() {

    }

    private function getCurrentExpectedPointsSum() {
        return $this->mean_difficulty * $this->current_question_number;
    }

    private function getCurrentTrajectoryDistance() {
        return $this->current_difficulty_sum - $this->getCurrentExpectedPointsSum();
    }
}