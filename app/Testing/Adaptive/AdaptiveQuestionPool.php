<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 29.11.18
 * Time: 10:51
 */

namespace App\Testing\TestGeneration;


use App\Testing\Adaptive\AdaptiveQuestion;
use App\Testing\Adaptive\Phase;
use App\Testing\Adaptive\QuestionClass;
use Illuminate\Support\Facades\Log;

class AdaptiveQuestionPool {

    /**
     * @var AdaptiveQuestion[][]
     */
    private $main_phase_pool = [];

    /**
     * @var AdaptiveQuestion[][]
     */
    private $common_pool = [];

    public function __construct() {
        $this->main_phase_pool[QuestionClass::LOW] = [];
        $this->main_phase_pool[QuestionClass::PRE_LOW] = [];
        $this->main_phase_pool[QuestionClass::MIDDLE] = [];
        $this->main_phase_pool[QuestionClass::PRE_HIGH] = [];
        $this->main_phase_pool[QuestionClass::HIGH] = [];

        $this->common_pool[QuestionClass::LOW] = [];
        $this->common_pool[QuestionClass::PRE_LOW] = [];
        $this->common_pool[QuestionClass::MIDDLE] = [];
        $this->common_pool[QuestionClass::PRE_HIGH] = [];
        $this->common_pool[QuestionClass::HIGH] = [];
    }

    /**
     * @param AdaptiveQuestion[] $main_phase_pool
     */
    public function setMainPhasePool($main_phase_pool) {
        foreach ($main_phase_pool as $question) {
            array_push($this->main_phase_pool[$question->getClass()], $question);
        }
    }

    /**
     * @param AdaptiveQuestion[] $common_pool
     */
    public function setCommonPool($common_pool) {
        foreach ($common_pool as $question) {
            array_push($this->common_pool[$question->getClass()], $question);
        }
    }

    /**
     * @param AdaptiveQuestion $question
     */
    public function addQuestionToMainPhasePool(AdaptiveQuestion $question) {
        array_push($this->main_phase_pool[$question->getClass()], $question);
    }

    /**
     * @param AdaptiveQuestion $question
     */
    public function addQuestionToCommonPool(AdaptiveQuestion $question) {
        array_push($this->common_pool[$question->getClass()], $question);
    }

    /**
     * @return AdaptiveQuestion[][]
     */
    public function getMainPhasePool() {
        return $this->main_phase_pool;
    }

    /**
     * @return AdaptiveQuestion[][]
     */
    public function getCommonPool() {
        return $this->common_pool;
    }

    // Удаляет вопрос из обоих пулов при $phase === MAIN.
    // Удаляет вопрос из экстра пула при $phase === COMMON (т.к. из главного он уже тогда точно удалён).
    public function remove($question_id, $phase) {
        $removed_from_main_phase_pool = $phase !== Phase::MAIN;
        $removed_from_common_pool = false;
        for ($i = QuestionClass::HIGH; $i >= QuestionClass::LOW; $i--) {
            if ($removed_from_main_phase_pool && $removed_from_common_pool) return;
            if (!$removed_from_main_phase_pool) {
                for ($j = 0; $j < count($this->getMainPhasePool()[$i]); $j++) {
                    if ($this->getMainPhasePool()[$i][$j]->getId() == $question_id) {
                        array_splice($this->main_phase_pool[$i], $j, 1);
                        $removed_from_main_phase_pool = true;
                        break;
                    }
                }
            }
            if (!$removed_from_common_pool) {
                for ($j = 0; $j < count($this->getCommonPool()[$i]); $j++) {
                    if ($this->getCommonPool()[$i][$j]->getId() == $question_id) {
                        array_splice($this->common_pool[$i], $j, 1);
                        $removed_from_common_pool = true;
                        break;
                    }
                }
            }
        }
        if (!$removed_from_main_phase_pool || !$removed_from_common_pool) {
            throw new TestGenerationException("Question " . $question_id . " hasn't been removed from pool properly");
        }
    }

    public function questionsCountToString() {
        $result = "главный\n";
        $result .= "-------\n";
        foreach ($this->main_phase_pool as $class => $questions) {
            if (count($questions) <= 0) {
                continue;
            }
            $class_name = QuestionClass::getClassName($class);
            $ids = array_map(function($question) { return $question->getId(); }, $questions);
            $result .= count($questions) . " $class_name: " . implode(", ", $ids) . "\n";
        }
    
        $result .= "\nэкстра\n";
        $result .= "------\n";
        foreach ($this->common_pool as $class => $questions) {
            if (count($questions) <= 0) {
                continue;
            }
            $class_name = QuestionClass::getClassName($class);
            $ids = array_map(function($question) { return $question->getId(); }, $questions);
            $result .= count($questions) . " $class_name: " . implode(", ", $ids) . "\n";
        }
    
        return $result;
    }
}

