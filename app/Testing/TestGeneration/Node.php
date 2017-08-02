<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:48
 */

namespace App\Testing\TestGeneration;


Class Node {
    private $mark;

    function __construct() {
        $this->mark = 0;
    }

    public function getMark() {
        return $this->mark;
    }

    public function changeMark($new_mark) {
        $this->mark = $new_mark;
    }

    public function getSection() {
        return null;
    }

    public function isSource(Graph $graph) {
        // TODO: implement
        return;
    }

    public function isSink(Graph $graph) {
        // TODO: implement
        return;
    }
}