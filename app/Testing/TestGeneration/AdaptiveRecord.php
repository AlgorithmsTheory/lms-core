<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 29.11.18
 * Time: 11:11
 */

namespace App\Testing\TestGeneration;


use App\Testing\Question;

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

    public function __construct(RecordNode $record, $amount) {
        $this->record = $record;
        $this->amount_left = $amount;
        $questions = Question::whereSection_code($record->section_code)
            ->whereTheme_code($record->theme_code)
            ->whereType_code($record->type_code)
            ->select('id_question')
            ->get();
        foreach ($questions as $question){
            array_push($this->question_ids, $question['id_question']);
        }
    }


}