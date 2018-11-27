<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 14:45
 */

namespace App\Testing\Adaptive;


use App\Testing\Question;

class AdaptiveQuestion {

    private $id;

    private $difficulty;

    private $class;

    private $right_factor;

    public function __construct($id, $student_knowledge_level) {
        $this->id = $id;
        $question = Question::whereId_question($id)->first();
        $this->difficulty = $question->difficulty;
        $this->right_factor = -1;
        $this->class = QuestionClass::getQuestionClass(
            1 - $this->evalProbabilityToBeCorrect($question->difficulty,
                                                                        $question->discriminant,
                                                                        $question->guess,
                                                                        $student_knowledge_level)
        );
    }

    public function evalProbabilityToBeCorrect($difficulty, $discriminant, $guess, $student_knowledge_level) {
        $exp = exp(1.7 + $discriminant * ($student_knowledge_level - $difficulty));
        return $guess + (1 - $guess) * $exp / (1 + $exp);
    }

    public function setRightFactor($right_factor) {
        $this->right_factor = $right_factor;
    }

    public function getId() {
        return $this->id;
    }

    public function getDifficulty() {
        return $this->difficulty;
    }

    public function getClass() {
        return $this->class;
    }

    public function getRightFactor() {
        return $this->right_factor;
    }
}