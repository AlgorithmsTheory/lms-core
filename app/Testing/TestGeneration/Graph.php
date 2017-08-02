<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:46
 */

namespace App\Testing\TestGeneration;


class Graph {
    /**
     * @var Node[]
     */
    private $nodes;

    /**
     * @var DirectedEdge[]
     */
    private $edges;

    function __construct($nodes, $edges) {
        $this->nodes = $nodes;
        $this->edges = $edges;
    }

    /**
     *  Set prev and next nodes for each node using edges
     */
    public function putInfoForNodes() {
        foreach ($this->nodes as $node) {
            foreach ($this->edges as $edge) {
                if ($edge->getNodeFrom() == $node) {
                    $array = $node->getNextNodes();
                    array_push($array, $edge->getNodeTo());
                    $node->setNextNodes($array);
                }
                if ($edge->getNodeTo() == $node) {
                    $array = $node->getPrevNodes();
                    array_push($array, $edge->getNodeFrom());
                    $node->setPrevNodes($array);
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function isSaturated() {
        // TODO: flow = capacity for all structure -> sink edges
    }

    /**
     * @return Node
     * @throws TestGenerationException
     */
    public function findSource() {
    foreach ($this->nodes as $node) {
        if ($node->isSource()) return $node;
    }
    throw new TestGenerationException("Source node not found");
    }

    public function putInitialFlows() {
        $begin_edges = [];
        foreach ($this->edges as $edge) {
            if ($edge->getType() == EdgeType::BEGIN) {
                array_push($begin_edges, $edge);
            }
        }
    }
}