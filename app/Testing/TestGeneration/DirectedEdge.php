<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:47
 */

namespace App\TestGeneration;


class DirectedEdge {
    private $node_from;
    private $node_to;
    private $capacity;
    private $flow;

    function __construct(Node $node_from, Node $node_to) {
        $this->node_from = $node_from;
        $this->node_to = $node_to;
        $this->flow = 0;
    }

    public function changeFlow() {
        // TODO: depends on next route node mark
    }

    public function setCapacity() {
        // TODO: depends on edge:
        // if source -> record: number of questions in record
        // if record -> structure: number in structure
        // if structure -> sink: number on structure
        $this->capacity = 0;
    }
}