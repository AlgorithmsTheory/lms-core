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

    public static function getQuestionClass($probability_to_be_incorrect) {
        if ($probability_to_be_incorrect <= 1.0 && $probability_to_be_incorrect >= 0.8) return self::HIGH;
        if ($probability_to_be_incorrect < 0.8 && $probability_to_be_incorrect >= 0.6) return self::PRE_HIGH;
        if ($probability_to_be_incorrect < 0.6 && $probability_to_be_incorrect >= 0.4) return self::MIDDLE;
        if ($probability_to_be_incorrect < 0.4 && $probability_to_be_incorrect >= 0.2) return self::PRE_LOW;
        else return self::LOW;
    }

    public static function getNextClass($current_class, $points_for_prev_question) {
        if ($points_for_prev_question >= 0.8) return $current_class - 1;
        if ($points_for_prev_question >= 0.6) return $current_class;
        else return $current_class;
     }

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