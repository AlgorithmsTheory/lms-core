<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 10:43
 */

namespace App\Testing\TestGeneration;


use App\Classwork;
use App\Lectures;
use App\Seminars;
use App\Testing\Adaptive\AdaptiveQuestion;
use App\Testing\Adaptive\BolognaMark;
use App\Testing\Adaptive\KnowledgeLevel;
use App\Testing\Adaptive\QuestionClass;
use App\Testing\Adaptive\Weights;
use App\Testing\Question;
use App\Testing\Result;
use App\Testing\StructuralRecord;
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
     * @var QuestionClass[] student visited
     */
    private $visited_classes = [];

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

    public function __construct($mark_expected_by_student, $id_test) {
        $student_id = Auth::user()['id'];
        $student = User::whereId($student_id)->select('group', 'knowledge_level')->first();
        $this->student_knowledge_level = $student['knowledge_level'];
        $group_id = $student['group'];
        $this->student_expected_mark = $this->evalStudentExpectedMark($mark_expected_by_student, $student_id, $group_id);
        $this->question_pool = new AdaptiveQuestionPool();
        $this->mean_difficulty = $this->evalMeanDifficultyAndSetCommonPool($id_test);
        $this->current_question_number = 0;
        $this->current_difficulty_sum = 0;
        array_push($this->visited_classes, QuestionClass::MIDDLE);
        $this->current_phase = 0;
    }

    public function generate(Test $test) {

    }

    public function chooseQuestion() {

    }

    private function evalStudentExpectedMark($mark_expected_by_student, $student_id, $group_id) {
        $mark_expected_by_system = $this->evalExpectedBySystemMark($student_id, $group_id);
        if ($mark_expected_by_student == 'Нет') return $mark_expected_by_system;
        return Weights::MARK_EXPECTED_BY_STUDENT_FACTOR * $mark_expected_by_student +
               Weights::MARK_EXPECTED_BY_SYSTEM_FACTOR * $mark_expected_by_system;
    }

    private function evalExpectedBySystemMark($id_student, $group_id) {
        $remote_activity = $this->evalRemoteActivity($id_student);
        $classroom_activity = $this->evalClassroomActivity($id_student, $group_id);
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

    private function evalClassroomActivity($id_student, $group_id) {
        return $this->evalLecturesActivity($id_student, $group_id) + $this->evalSeminarsActivity($id_student, $group_id);
    }

    private function evalLecturesActivity($id_student, $group_id) {
        $lectures_group_attendance = Lectures::whereGroup($group_id)->get();
        $lectures_student_attendance = Lectures::whereUserID($id_student)->first();
        $attendance_percentage = $this->getAttendancePercentage($lectures_group_attendance, $lectures_student_attendance);
        if ($attendance_percentage > 0.8) return 0.05 * ($attendance_percentage + 1);
        if ($attendance_percentage >= 0.5) return $attendance_percentage / 3 - 2.4;
        return -0.1;
    }

    private function evalSeminarsActivity($id_student, $group_id) {
        return $this->evalSeminarsAttendanceActivity($id_student, $group_id) + $this->evalSeminarsWorkActivity($id_student, $group_id);
    }

    private function evalSeminarsAttendanceActivity($id_student, $group_id) {
        $seminars_group_attendance = Seminars::whereGroup($group_id)->get();
        $seminars_student_attendance = Seminars::whereUserID($id_student)->first();
        $attendance_percentage = $this->getAttendancePercentage($seminars_group_attendance, $seminars_student_attendance);
        if ($attendance_percentage >= 0.6) return 0.5 * ($attendance_percentage -1);
        return -0.2;
    }

    private function evalSeminarsWorkActivity($id_student, $group_id) {
        $seminars_group_attendance = Seminars::whereGroup($group_id)->get();
        $seminars_student_work = Classwork::whereUserID($id_student)->first();
        $work_percentage = $this->getAttendancePercentage($seminars_group_attendance, $seminars_student_work);
        return 0.2 * $work_percentage;
    }

    private function getAttendancePercentage($group_attendance, $student_attendance) {
        $column_name_prefix = 'col';
        $carried = 0;
        $visited = 0;
        for ($i = 1; $i <= 16; $i++) {
            $column_name = $column_name_prefix . $i;
            $is_carried = false;
            foreach ($group_attendance as $student) {
                if ((int)$student[$column_name] > 0) {
                    $is_carried = true;
                }
            }
            if ($is_carried) {
                $carried++;
                if ((int)$student_attendance[$column_name] > 0) $visited++;
            }
        }
        return $visited / $carried;
    }

    private function evalMeanDifficultyAndSetCommonPool($id_test) {
        $sections = StructuralRecord::whereId_test($id_test)->select('section_code')->distinct()->get();
        $difficult_sum = 0;
        $questions_counter = 0;
        $common_questions_pool = [];
        foreach ($sections as $section) {
            $questions = Question::whereSection_code($section['section_code'])
                ->join('types', 'questions.type_code', '=', 'types.type_code')
                ->where('types.only_fpr_print', '=', '0')
                ->select('id_question', 'difficulty')->get();
            foreach ($questions as $question) {
                $questions_counter++;
                $difficult_sum += $question['difficulty'];
                $adaptive_question = new AdaptiveQuestion($question['id'], $this->student_knowledge_level);
                array_push($common_questions_pool, $adaptive_question);
            }
        }
        $this->question_pool->setCommonPool($common_questions_pool);
        return $difficult_sum / $questions_counter;
    }

    private function getCurrentExpectedPointsSum() {
        return $this->mean_difficulty * $this->current_question_number;
    }

    private function getCurrentTrajectoryDistance() {
        return $this->current_difficulty_sum - $this->getCurrentExpectedPointsSum();
    }

    private function isReadyToFinish() {
        $trajectory_finish_factor = $this->evalTrajectoryFinishFactor();
        $knowledge_finish_factor = $this->evalKnowledgeFinishFactor();
        $probability_to_fininsh = min(max(0, $trajectory_finish_factor + $knowledge_finish_factor), 1);

    }

    private function evalTrajectoryFinishFactor() {

    }

    private function evalKnowledgeFinishFactor() {

    }
}