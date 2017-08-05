<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:48
 */

namespace App\Testing\TestGeneration;


use Illuminate\Support\Facades\Log;

Class Node {
    /**
     * @var Node[]
     */
    private $prev_nodes;

    /**
     * @var Node[]
     */
    private $next_nodes;

    /**
     * @var int Sum of output edges capacities
     */
    private $capacity;

    /**
     * @var int Sum of input edges flows
     */
    private $flow;

    /**
     * @var NodeMark
     */
    private $mark;

    function __construct() {
        $this->flow = 0;
        $this->mark = new NodeMark();
        $this->prev_nodes = [];
        $this->next_nodes = [];
    }

    public function getCapacity() {
        return $this->capacity;
    }

    public function setCapacity($capacity) {
        $this->capacity = $capacity;
    }

    public function getFlow() {
        return $this->flow;
    }

    public function setFlow($flow) {
        $this->flow = $flow;
    }

    public function getMark() {
        return $this->mark;
    }

    /**
     * @return Node[]
     */
    public function getPrevNodes() {
        return $this->prev_nodes;
    }

    public function setPrevNodes($prev_nodes) {
        $this->prev_nodes = $prev_nodes;
    }

    /**
     * @return Node[]
     */
    public function getNextNodes() {
        return $this->next_nodes;
    }

    public function setNextNodes($next_nodes) {
        $this->next_nodes = $next_nodes;
    }

    public function setMark($node_from, $value) {
        $this->mark->setNodeFrom($node_from);
        $this->mark->setValue($value);
//        Log::deubg("Set mark " . $value);
    }

    public function isMarked() {
        return $this->mark->getValue() != 0;
    }

    public function getLeftCapacity() {
        return $this->capacity - $this->flow;
    }

    public function isSource() {
        return count($this->prev_nodes) == 0 ? true : false;
    }

    public function isSink() {
        return count($this->next_nodes) == 0 ? true : false;
    }
}