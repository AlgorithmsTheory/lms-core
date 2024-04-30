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

    private $pass_time;

    private $class;

    private $end_time;

    private $right_factor;

    public function __construct(Question $question, $student_knowledge_level) {
        $this->id = $question['id_question'];
        $this->pass_time = $question['pass_time'];
        $this->difficulty = $question['difficulty'] + 3;
        $this->right_factor = -1;
        $this->class = QuestionClass::getQuestionClass(
            1 - $this->evalProbabilityToBeCorrect($question['discriminant'],
                                                                        $question['guess'],
                                                                        $student_knowledge_level)
        );
    }

    public function evalProbabilityToBeCorrect($discriminant, $guess, $student_knowledge_level) {
        $exp = exp(1.7 + $discriminant * ($student_knowledge_level - $this->difficulty));
        return $guess + (1 - $guess) * $exp / (1 + $exp);
    }

    public function setEndTime() {
        $this->end_time = date('U') + $this->pass_time;
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

    public function getPassTime() {
        return $this->pass_time;
    }

    public function getClass() {
        return $this->class;
    }

    public function getEndTime() {
        return $this->end_time;
    }

    public function getRightFactor() {
        return $this->right_factor;
    }

    public function __toString() {
        $output = "Question ID: " . $this->id . "\n";
        $output .= "Difficulty: " . $this->difficulty . "\n";
        $output .= "Pass Time: " . $this->pass_time . " seconds\n";
        $output .= "Class: " . $this->class . "\n";
        $output .= "End Time: " . ($this->end_time ? date('Y-m-d H:i:s', $this->end_time) : "Not set") . "\n";
        $output .= "Right Factor: " . $this->right_factor . "\n";
    
        return $output;
    }
}