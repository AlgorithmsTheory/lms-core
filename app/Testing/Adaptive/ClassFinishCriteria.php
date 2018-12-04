<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 04.12.18
 * Time: 17:00
 */

namespace App\Testing\Adaptive;


class ClassFinishCriteria {

    public static function getClassFinishFactor($number_of_steps_in_two_classes) {
        switch ($number_of_steps_in_two_classes) {
            case 1:  return 0.0;
            case 2:  return 0.0;
            case 3:  return 0.2;
            case 4:  return 0.5;
            default: return 1.0;
        }
    }
}