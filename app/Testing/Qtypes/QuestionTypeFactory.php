<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 23.01.19
 * Time: 16:02
 */

namespace App\Testing\Qtypes;


class QuestionTypeFactory {

    /**
     * @param $question_id int
     * @param $type string
     * @return QuestionType | Checkable
     */
    public static function getQuestionTypeByTypeName($question_id, $type) {
        switch($type){
            case 'Выбор одного из списка':
                return new OneChoice($question_id);
            case 'Выбор нескольких из списка':
                return new MultiChoice($question_id);
            case 'Текстовый вопрос':
                return new FillGaps($question_id);
            case 'Таблица соответствий':
                return new AccordanceTable($question_id);
            case 'Да/Нет':
                return new YesNo($question_id);
            case 'Определение':
                return new Definition($question_id);
            case 'Открытый тип':
                return new JustAnswer($question_id);
            case 'Теорема':
                return new Theorem($question_id);
            case 'Три точки':
                return new ThreePoints($question_id);
            case 'Как теорема':
                return new TheoremLike($question_id);
            case 'Востановить арифметический вид':
                return new FromCleene($question_id);
            default:
                throw new \InvalidArgumentException("Question type " . $type . " is not supported");
        }
    }

    /**
     * @param $question_id int
     * @param $type_code int
     * @return QuestionType | Checkable
     */
    public static function getQuestionTypeByTypeCode($question_id, $type_code) {
        switch($type_code){
            case 1:
                return new OneChoice($question_id);
            case 2:
                return new MultiChoice($question_id);
            case 3:
                return new FillGaps($question_id);
            case 4:
                return new AccordanceTable($question_id);
            case 5:
                return new YesNo($question_id);
            case 6:
                return new Theorem($question_id);
            case 7:
                return new Definition($question_id);
            case 8:
                return new JustAnswer($question_id);
            case 9:
                return new ThreePoints($question_id);
            case 10:
                return new TheoremLike($question_id);
            case 11:
                return new FromCleene($question_id);
            default:
                throw new \InvalidArgumentException("Question type " . $type_code . " is not supported");
        }
    }
}