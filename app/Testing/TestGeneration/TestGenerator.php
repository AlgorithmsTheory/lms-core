<?php
namespace App\Testing\TestGeneration;

/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:27
 */
interface TestGenerator {
    /**
     *  @throws TestGenerationException
     *  Create final list of questions for test
     */
    public function generate();

    /**
     *  Return list of all questions from available structural records
     */
    public function getAvailableQuestions();

    /**
     *  Choose one question from final list
     */
    public function chooseQuestion();

    /**
     *  Build dicotyledonous graph (source - records - structures - sink) with capacities and flows
     */
    public function buildGraph();
}