<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 04.12.18
 * Time: 17:00
 */

namespace App\Testing\Adaptive;


class FinishCriteria {

    public static function getClassFinishFactor($number_of_steps_in_two_classes) {
        switch ($number_of_steps_in_two_classes) {
            case 1:  return 0.0;
            case 2:  return 0.0;
            case 3:  return 0.2;
            case 4:  return 0.5;
            default: return 1.0;
        }
    }

    public static function getKnowledgeFinishFactor($level_difference) {
        switch ($level_difference) {
            case 0:  return 0.3;
            case 1:  return 0.2;
            case 2:  return 0.1;
            case 3:  return 0.0;
            case 4:  return -0.1;
            case 5:  return -0.2;
            default: return -0.3;
        }
    }
}