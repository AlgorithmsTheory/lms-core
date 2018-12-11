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
use App\Testing\Adaptive\FinishCriteria;
use App\Testing\Adaptive\KnowledgeLevel;
use App\Testing\Adaptive\Phase;
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
     * @var int pre defined value by teacher
     */
    private $max_question_number;

    /**
     * @var int number of questions in the main phase
     */
    private $main_phase_amount;

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
     * @var AdaptiveQuestionPool
     */
    private $question_pool;

    /**
     * @var AdaptiveRecord[] formed by Ford-Fulkerson algorithm
     */
    private $chosen_records = [];

    /**
     * @var AdaptiveQuestion[] already passed by student
     */
    private $passed_questions = [];

    public function __construct($mark_expected_by_student, $id_test) {
        $student_id = Auth::user()['id'];
        $student = User::whereId($student_id)->select('group', 'knowledge_level')->first();
        $this->student_knowledge_level = $student['knowledge_level'];
        $group_id = $student['group'];
        $this->student_expected_mark = $this->evalStudentExpectedMark($mark_expected_by_student, $student_id, $group_id);
        $this->question_pool = new AdaptiveQuestionPool();
        $this->mean_difficulty = $this->evalMeanDifficultyAndSetCommonPool($id_test);
        $this->max_question_number = Test::whereId_test($id_test)->select('max_questions')->first()->max_questions;
        $this->current_question_number = 0;
        $this->current_difficulty_sum = 0;
        array_push($this->visited_classes, QuestionClass::MIDDLE);
        $this->main_phase_amount = 0;
    }

    public function generate(Test $test) {
        $graph = GraphBuilder::buildGraphFromTest($test);
        $graph->fordFulkersonMaxFlow();
        if (!$graph->isSaturated())
            throw new TestGenerationException("Test has unacceptable structure!");

        foreach ($graph->getSource()->getNextNodes() as $record) {
            $amount = 0;
            foreach ($record->getNextNodes() as $struct_node) {
                $amount += $graph->getEdge($record, $struct_node)->getFlow();
            }
            $this->main_phase_amount += $amount;
            if ($amount > 0) {
                $questions = Question::whereSection_code($record->section_code)
                    ->whereTheme_code($record->theme_code)
                    ->whereType_code($record->type_code)
                    ->select('id_question', 'difficulty', 'discriminant', 'guess')
                    ->get();
                $adaptive_record = new AdaptiveRecord($record, $amount, $questions);
                array_push($this->chosen_records, $adaptive_record);

                foreach ($questions as $question) {
                    $adaptive_question = new AdaptiveQuestion($question, $this->student_knowledge_level);
                    $this->question_pool->addQuestionToMainPhasePool($adaptive_question);
                }
            }
        }
    }

    public function chooseQuestion() {
        $this->current_question_number++;
        $phase = $this->getCurrentPhase();
        if ($phase == Phase::MAIN) {
            if ($this->current_question_number >= $this->max_question_number) {
                throw new TestGenerationException("Invalid test state: main phase contains more questions than test limit");
            }
            $possible_questions = $this->getPossibleQuestions($phase);
            $possible_questions_count = count($possible_questions);
            if ($possible_questions_count == 0) {
                throw new TestGenerationException("Can't find question in main phase!");
            }

            $rand_question_index = rand(0, $possible_questions_count - 1);
            $chosen_question = $possible_questions[$rand_question_index];
            $this->setStateAfterChooseQuestion($chosen_question, $phase);
            $this->handleGraphRecordsAfterChooseQuestion($chosen_question, $phase);
            return $chosen_question->getId();
        }
        else {
            if ($this->isReadyToFinish()) return -1;
            $possible_questions = $this->getPossibleQuestions($phase);
            $possible_questions_count = count($possible_questions);
            if ($possible_questions_count == 0) return -1;

            $rand_question_index = rand(0, $possible_questions_count - 1);
            $chosen_question = $possible_questions[$rand_question_index];
            $this->setStateAfterChooseQuestion($chosen_question, $phase);
            return $chosen_question->getId();
        }
    }

    public function setRightFactorAfterCheck($right_factor) {
        end($this->passed_questions)->setRightFactor($right_factor);
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
                $adaptive_question = new AdaptiveQuestion($question, $this->student_knowledge_level);
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
        if ($this->getCurrentPhase() == Phase::MAIN) return false;
        if ($this->current_question_number >= $this->max_question_number) return true;
        $trajectory_finish_factor = $this->evalTrajectoryFinishFactor();
        $knowledge_finish_factor = $this->evalKnowledgeFinishFactor();
        $probability_to_finish = min(max(0, $trajectory_finish_factor + $knowledge_finish_factor), 1);
        $rand_num = rand(0, 100);
        return $rand_num <= $probability_to_finish * 100;
    }

    private function evalTrajectoryFinishFactor() {
        $number_of_steps_in_two_classes = 1;
        $max_class = end($this->visited_classes);
        $min_class = $max_class;
        while($max_class - $min_class < 2 && $number_of_steps_in_two_classes < 5) {
            $number_of_steps_in_two_classes++;
            $current_class = prev($this->visited_classes);
            if ($current_class == false) break;
            if ($current_class > $max_class) $max_class = $current_class;
            if ($current_class < $min_class) $min_class = $current_class;
        }
        return FinishCriteria::getClassFinishFactor($number_of_steps_in_two_classes);
    }

    private function evalKnowledgeFinishFactor() {
        $expected_level = KnowledgeLevel::getKnowledgeLevelFromMark($this->student_expected_mark)->getLevel();
        $current_level = KnowledgeLevel::getKnowledgeLevelFromPoints($this->getCurrentPoints())->getLevel();
        return FinishCriteria::getKnowledgeFinishFactor(abs($expected_level - $current_level));
    }

    private function getCurrentPoints() {
        $current_clean_mark = $this->getCurrentCleanMark();
        $trajectory_distance = $this->getCurrentTrajectoryDistance();
        $normalized_mark = ($current_clean_mark + $trajectory_distance) / $this->current_difficulty_sum;
        return min(max(0, $normalized_mark), 1);
    }

    private function getCurrentCleanMark() {
        $points_sum = 0;
        foreach ($this->passed_questions as $question) {
            $points_sum += $question->getDifficulty() * $question->getRightFactor();
        }
        return $points_sum;
    }

    private function getCurrentPhase() {
        if ($this->current_question_number <= $this->main_phase_amount) return Phase::MAIN;
        else return Phase::EXTRA;
    }

    private function getCurrentClass() {
        $prev_class = end($this->visited_classes);
        $points_for_prev_question = end($this->passed_questions)->getRightFactor();
        return QuestionClass::getNextClass($prev_class, $points_for_prev_question);
    }

    /**
     * @return AdaptiveQuestion[]
     */
    private function getPossibleQuestions($phase) {
        $class = $this->getCurrentClass();
        $possible_questions_count = 0;
        $try = 0;
        $classes_questions = [];
        while ($possible_questions_count == 0  && $try < 3) {
            $classes_questions = [];
            $try++;
            $classes_for_choose[] = QuestionClass::getNearestClasses($class, $try);
            foreach ($classes_for_choose as $class_for_choose) {
                if ($phase == Phase::MAIN) {
                    $questions_in_class[] = $this->question_pool->getMainPhasePool()[$class_for_choose];
                }
                else {
                    $questions_in_class[] = $this->question_pool->getCommonPool()[$class_for_choose];
                }
                if (count($questions_in_class) != 0) {
                    $classes_questions = array_merge($classes_questions, $questions_in_class);
                }
                $possible_questions_count = count($classes_questions);
            }
        }
        if ($possible_questions_count == 0) {
            $classes_questions = [];
        }
        return $classes_questions;
    }

    private function setStateAfterChooseQuestion(AdaptiveQuestion $chosen_question, $phase) {
        $this->current_difficulty_sum += $chosen_question->getDifficulty();
        array_push($this->visited_classes, $chosen_question->getClass());
        $this->question_pool->remove($chosen_question->getId(), $phase);
        array_push($this->passed_questions, $chosen_question);
    }

    private function handleGraphRecordsAfterChooseQuestion(AdaptiveQuestion $chosen_question, $phase) {
        foreach ($this->chosen_records as $record) {
            if ($record->remove($chosen_question->getId())) {
                $record->decreaseAmount();
                if ($record->isEmpty()) {
                    foreach ($record->getQuestionIds() as $id) {
                        $this->question_pool->remove($id, $phase);
                    }
                }
            }
        }
    }
}