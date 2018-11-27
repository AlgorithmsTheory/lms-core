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
}