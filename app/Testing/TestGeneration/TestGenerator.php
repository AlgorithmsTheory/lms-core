<?php
namespace App\Testing\TestGeneration;

use App\Testing\Test;

/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:27
 */
interface TestGenerator {

    /**
     *  Choose one question from list
     */
    public function chooseQuestion();

    /**
     * Create list of questions for follow choice
     * @param Test $test
     */
    public function generate(Test $test);
}