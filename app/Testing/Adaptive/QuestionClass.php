<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 14:57
 */

namespace App\Testing\Adaptive;


abstract class QuestionClass {
    const HIGH = 1;
    const PRE_HIGH = 2;
    const MIDDLE = 3;
    const PRE_LOW = 4;
    const LOW = 5;

    // Возвращает Класс сложности на основе Вероятности неверности.
    // Чем выше Вероятность неверности, тем выше возвращаемый Класс сложности.
    public static function getQuestionClass($probability_to_be_incorrect) {
        if ($probability_to_be_incorrect >= 0.8) return self::HIGH;
        if ($probability_to_be_incorrect >= 0.6) return self::PRE_HIGH;
        if ($probability_to_be_incorrect >= 0.4) return self::MIDDLE;
        if ($probability_to_be_incorrect >= 0.2) return self::PRE_LOW;
        return self::LOW;
    }

    // Определить Класс сложности следующего Вопроса на основе
    // Класса сложности и Очков набранных для Предыдущего вопроса.
    public static function getNextClass($current_class, $points_for_prev_question) {
        // Очки за пред. Вопрос высокие?
        // Тогда возвращаем более Высокий класс сложности.
        // Здесь "- 1", т.к. HIGH == 1, LOW == 5.
        if ($points_for_prev_question >= 0.8) return $current_class - 1;

        // Очки за пред. Вопрос норм (60-80%%)?
        // Возвращаем тот же класс, что и класс пред. вопроса
        if ($points_for_prev_question >= 0.6) return $current_class;

        // Возвращаем тот же класс, что и класс пред. Вопроса.
        return $current_class;
    }

    // Возвращает массив Классов сложностей в Окрестности $try.
    //
    // $try, $current_class -> result
    // 1, LOW: [LOW]
    // 1, PRE_LOW: [PRE_LOW]
    // 1, MIDDLE: [MIDDLE]
    // 1, PRE_HIGH: [PRE_HIGH]
    // 1, HIGH: [HIGH]
    //
    // 2, LOW: [LOW, PRE_LOW]
    // 2, PRE_LOW: [PRE_LOW, MIDDLE, LOW]
    // 2, MIDDLE: [MIDDLE, PRE_HIGH, PRE_LOW]
    // 2, PRE_HIGH: [PRE_HIGH, HIGH, MIDDLE]
    // 2, HIGH: [HIGH, PRE_HIGH]
    //
    // 3, LOW: [LOW, PRE_LOW, MIDDLE]
    // 3, PRE_LOW: [PRE_LOW, MIDDLE, PRE_HIGH, LOW]
    // 3, MIDDLE: [MIDDLE, PRE_HIGH, HIGH, PRE_LOW, LOW]
    // 3, PRE_HIGH: [PRE_HIGH, MIDDLE, PRE_LOW, HIGH]
    // 3, HIGH: [HIGH, PRE_HIGH, MIDDLE]
    public static function getNearestClasses($current_class, $try) {
        $classes = [];
        array_push($classes, $current_class);
        if ($try == 2) {
            switch ($current_class) {
                case QuestionClass::LOW:
                    array_push($classes, $current_class - 1);
                    break;
                case QuestionClass::HIGH:
                    array_push($classes, $current_class + 1);
                    break;
                default:
                    array_push($classes, $current_class - 1);
                    array_push($classes, $current_class + 1);
            }
        }
        else if ($try == 3) {
            switch ($current_class) {
                case QuestionClass::LOW:
                    array_push($classes, $current_class - 1);
                    array_push($classes, $current_class - 2);
                    break;
                case QuestionClass::PRE_LOW:
                    array_push($classes, $current_class - 1);
                    array_push($classes, $current_class - 2);
                    array_push($classes, $current_class + 1);
                    break;
                case QuestionClass::PRE_HIGH:
                    array_push($classes, $current_class + 1);
                    array_push($classes, $current_class + 2);
                    array_push($classes, $current_class - 1);
                    break;
                case QuestionClass::HIGH:
                    array_push($classes, $current_class + 1);
                    array_push($classes, $current_class + 2);
                    break;
                default:
                    array_push($classes, $current_class - 1);
                    array_push($classes, $current_class - 2);
                    array_push($classes, $current_class + 1);
                    array_push($classes, $current_class + 2);
            }
        }
        return $classes;
    }
}