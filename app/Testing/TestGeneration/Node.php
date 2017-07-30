<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:48
 */

namespace App\TestGeneration;


abstract Class Node {
    private $prev_nodes;
    private $next_nodes;
    private $mark;

    function __construct() {
        $this->mark = 0;
    }

    public function getPrevNodes() {
        return $this->prev_nodes;
    }

    public function setPrevNodes($prev_nodes) {
        $this->prev_nodes = $prev_nodes;
    }

    public function getNextNodes() {
        return $this->next_nodes;
    }

    public function setNextNodes($next_nodes) {
        $this->next_nodes = $next_nodes;
    }

    public function getMark() {
        return $this->mark;
    }

    public function changeMark($new_mark) {
        $this->mark = $new_mark;
    }

    public function isSource() {
        return count($this->prev_nodes) == 0 ? true : false;
    }

    public function isSink() {
        return count($this->next_nodes) == 0 ? true : false;
    }
}