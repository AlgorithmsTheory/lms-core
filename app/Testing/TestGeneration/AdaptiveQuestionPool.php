<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 29.11.18
 * Time: 10:51
 */

namespace App\Testing\TestGeneration;


use App\Testing\Adaptive\AdaptiveQuestion;
use App\Testing\Adaptive\QuestionClass;

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
}