<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 23.01.19
 * Time: 14:43
 */

namespace App\Testing\Qtypes;

/**
 * Questions that can be automatically checked
 */
interface Checkable {

    /**
     * Define estimate algorithm of student's answer
     */
    function check($array);

    /**
     * @return float guess parameter for question
     */
    function evalGuess();
}