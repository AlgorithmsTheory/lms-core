<?php
use App\TestGeneration\TestGenerator;
use App\Testing\Test;


/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:38
 */
class UsualTestGenerator implements TestGenerator {
    private $test;
    private $graph;
    private $available_qurstions;
    private $chosen_questions;

    function __construct(Test $test) {
        $this->test = $test;
    }

    public function buildGraph() {
        // TODO: Implement buildGraph() method.
    }

    public function getAvailableQuestions() {
        // TODO: Implement getAvailableQuestions() method.
    }

    public function generate() {
        // TODO: Implement generate() method.
    }

    public function chooseQuestion() {
        // TODO: Implement chooseQuestion() method.
    }
}