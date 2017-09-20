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
     * @param $restrictions
     * @throws TestGenerationException
     * Build dicotyledonous graph (source - records - structures - sink) with capacities and flows from teacher's restrictions
     */
    public function buildGraphFromRestrictions($restrictions);

    /**
     * @param $test Test
     * @throws TestGenerationException
     * Build dicotyledonous graph (source - records - structures - sink) with capacities and flows from existence test
     */
    public function buildGraphFromTest(Test $test);

    /**
     *  Choose one question from final list
     */
    public function chooseQuestion();

    /**
     *  @throws TestGenerationException
     *  Create final list of questions for test
     */
    public function generate();
}