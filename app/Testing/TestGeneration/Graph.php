<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:46
 */

namespace App\Testing\TestGeneration;


class Graph {
    private $nodes;
    private $edges;

    function __construct($nodes, $edges) {
        $this->nodes = $nodes;
        $this->edges = $edges;
    }

    public function isSaturated() {
        // TODO: flow = capacity for all structure -> sink edges
    }
}