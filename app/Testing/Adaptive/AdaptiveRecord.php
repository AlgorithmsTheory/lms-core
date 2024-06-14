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
     * 
     * Осталось выдать Вопросов такого вида (Раздел-Тема-Тип) в Тесте
     */
    private $amount_left;

    /**
     * @var int[]
     * 
     * Идентификаторы всех Вопросов вида (Раздел-Тема-Тип) из которых
     * можно выбрать следующий Вопрос.
     */
    private $question_ids = [];

    /**
     * 
     * $amount - Сколько Вопросов в Тесте должно быть такого вида (Раздел-Тема-Тип)
     * $questions - Все Вопросы такого вида (Раздел-Тема-Тип). Их может быть >= $amount.
     */
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
                array_splice($this->question_ids, $i, 1);
                return true;
            }
        }
        return false;
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

    /**
     * Converts the current state of the AdaptiveRecord to a string.
     * This includes the record details, amount left, and question IDs.
     *
     * @return string
     */
    public function __toString() {
        $recordDetails = "Запись: " . $this->record .
            ' (осталось ' . $this->amount_left . ')';
        $questionIds = "Вопросы: " . implode(", ", $this->question_ids);
        
        return $recordDetails . "\n" . $questionIds;
    }
}