<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 29.11.18
 * Time: 11:11
 */

namespace App\Testing\TestGeneration;


class AdaptiveRecord {

    /**
     * @var RecordNode
     */
    private $record;

    /**
     * @var int
     */
    private $amount_left;

    /**
     * @var int[]
     */
    private $question_ids = [];

    public function __construct(RecordNode $record, $amount, $questions) {
        $this->record = $record;
        $this->amount_left = $amount;
        foreach ($questions as $question) {
            array_push($this->question_ids, $question['id_question']);
        }
    }

    public function remove($id_question) {
        for ($i = 0; $i < count($this->question_ids); $i++) {
            if ($this->question_ids[$i] == $id_question) {
                unset($this->question_ids[$i]);
                array_values($this->question_ids);
                return true;
            }
        }
    }

    public function decreaseAmount() {
        $this->amount_left--;
    }

    public function getAmount() {
        return $this->amount_left;
    }

    public function getQuestionIds() {
        return $this->question_ids;
    }

    public function isEmpty() {
        return $this->amount_left <= 0;
    }
}