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

    /**
     * @var Node
     */
    private $source;

    /**
     * @var Node
     */
    private $sink;

    function __construct($nodes, $edges) {
        $this->nodes = $nodes;
        $this->edges = $edges;
    }

    /**
     *  Set prev nodes, next nodes and capacity for each node
     */
    public function putInfoForNodes() {
        foreach ($this->edges as $edge) {
            $node_from = $edge->getNodeFrom();
            $node_to = $edge->getNodeTo();
            foreach ($this->nodes as $node) {
                if ($node_from->equals($node)) {
                    $array = $node->getNextNodes();
                    array_push($array, $node_to);
                    $node->setNextNodes($array);
                    $node->setCapacity($node->getCapacity() + $edge->getCapacity());
                }
                if ($node_to->equals($node)) {
                    $array = $node->getPrevNodes();
                    array_push($array, $node_from);
                    $node->setPrevNodes($array);
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function isSaturated() {
        foreach ($this->sink->getPrevNodes() as $struct_node) {
            $edge = $this->getEdge($struct_node, $this->sink);
            if (!$edge->isSaturated()) {
                return false;
            }
        }
        return true;
    }
    
    public function setSource() {
        foreach ($this->nodes as $node) {
            if ($node->isSource()) {
                $this->source = $node;
                return;
            }
        }
        throw new TestGenerationException("Source node not found");
    }
    
    public function setSink() {
        foreach ($this->nodes as $node) {
            if ($node->isSink()) {
                $this->sink = $node;
                return;
            }
        }
        throw new TestGenerationException("Sink node not found");
    }

    /**
     * @return Node
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * @return Node
     */
    public function getSink() {
        return $this->sink;
    }

    public function putInitialFlows() {
        $this->flushMarks();
        while (!$this->allNodesMarked()) {
            $route = [];
            $route = $this->findWay($this->sink, $this->source, $route);
            $this->fillWay($route);
            $this->markNodes($this->source, $this->sink);
        }
        $this->flushMarks();
    }

    private function allNodesMarked() {
        foreach ($this->nodes as $node) {
            if (!$node->isMarked() && !$node->isSink()) {
                return false;
            }
        }
        return true;
    }

    private function findWay(Node $sink, Node $node, $route) {
        if ($node !== $sink) {
            $next_nodes = [];
            foreach ($node->getNextNodes() as $next_node) {
                $edge = $this->getEdge($node, $next_node);
                if ($edge->getFlow() < $edge->getCapacity() && !$next_node->isMarked()) {
                    array_push($next_nodes, $next_node);
                }
            }
            if (count($next_nodes) == 0) {
                throw new TestGenerationException("No available way for initial filling");
            }
            $next_node = $next_nodes[rand(0, count($next_nodes) - 1)];
            $edge = $this->getEdge($node, $next_node);
            array_push($route, $edge);
            $route = $this->findWay($sink, $next_node, $route);
        }
        return $route;
    }

    /**
     * @param $route DirectedEdge[]
     */
    private function fillWay($route) {
        $min_flow = 10000;
        foreach ($route as $edge) {
            if (($edge->getCapacity() - $edge->getFlow()) < $min_flow) {
                $min_flow = $edge->getCapacity() - $edge->getFlow();
            }
        }
        foreach ($route as $edge) {
            $edge->setFlow($edge->getFlow() + $min_flow);
        }
    }

    private function markNodes(Node $source, Node $sink) {
        foreach ($source->getNextNodes() as $record_node) {
            if(!$record_node->isMarked()) {
                $edge = $this->getEdge($source, $record_node);
                if ($edge->isSaturated()) {
                    $record_node->setMark(null, 1);
                }
            }
        }

        foreach ($sink->getPrevNodes() as $struct_node) {
            if (!$struct_node->isMarked()) {
                $edge = $this->getEdge($struct_node, $sink);
                if ($edge->isSaturated()) {
                    $struct_node->setMark(null, 1);
                }
                else {
                    $must_be_marked = true;
                    foreach ($struct_node->getPrevNodes() as $record_node) {
                        $edge = $this->getEdge($record_node, $struct_node);
                        if (!$edge->isSaturated() && !$record_node->isMarked()) {
                            $must_be_marked = false;
                            break;
                        }
                    }
                    if ($must_be_marked) {
                        $struct_node->setMark(null, 1);
                    }
                }
            }
        }

        foreach ($source->getNextNodes() as $record_node) {
            $must_be_marked = true;
            foreach ($record_node->getNextNodes() as $struct_node) {
                $edge = $this->getEdge($record_node, $struct_node);
                if (!$struct_node->isMarked() && !$edge->isSaturated()) {
                    $must_be_marked = false;
                    break;
                }
            }
            if ($must_be_marked) {
                $record_node->setMark(null, 1);
            }
        }

        $must_be_marked = true;
        foreach($source->getNextNodes() as $record_node) {
            if (!$record_node->isMarked()) {
                $must_be_marked = false;
                break;
            }
        }
        if ($must_be_marked) {
            $source->setMark(null, 1);
        }
    }

    public function fordFulkersonMaxFlow() {
        $this->putInitialFlows();

        while(1) {
            $this->source->setMark(null, -1000);
            $active_node = $this->findAndMarkUnmarkedNode($this->source);

            while ($active_node != null) {
                $active_node = $this->findAndMarkUnmarkedNode($active_node);
            }
            if (!$this->sink->isMarked()) {
                return;
            } else {
                $current_code = $this->sink;
                while ($current_code != $this->source) {
                    if ($current_code->getMark()->getValue() > 0) {
                        $edge = $this->getEdge($current_code->getMark()->getNodeFrom(), $current_code);
                        $edge->setFlow($edge->getFlow() + abs($current_code->getMark()->getValue()));
                        $current_code = $current_code->getMark()->getNodeFrom();
                    } else {
                        $edge = $this->getEdge($current_code, $current_code->getMark()->getNodeFrom());
                        $edge->setFlow($edge->getFlow() - abs($current_code->getMark()->getValue()));
                        $current_code = $current_code->getMark()->getNodeFrom();
                    }
                }
                $this->flushMarks();
            }
        }
    }

    /**
     * @param Node $node
     * @return Node|null
     */
    private function findAndMarkUnmarkedNode(Node $node) {
        $next_node = $this->findAndMarkNextUnmarkedNode($node);
        if ($next_node != null) {
            return $next_node;
        }
        else {
            $prev_node = $this->findAndMarkPrevUnmarkedNode($node);
            if ($prev_node != null) {
                return $prev_node;
            }
            else {
                return null;
            }
        }
    }

    /**
     * @param Node $node
     * @return Node|null
     */
    private function findAndMarkNextUnmarkedNode(Node $node) {
        $next_unmarked_node = $this->findNextUnmarkedNode($node);
        if ($next_unmarked_node != null) {
            $connected_edge = $this->getEdge($node, $next_unmarked_node);
            $next_unmarked_node->setMark($node, min(abs($node->getMark()->getValue()), $connected_edge->getCapacity() - $connected_edge->getFlow()));
            return $next_unmarked_node;
        }
        else return null;
    }

    /**
     * @param Node $node
     * @return Node|null
     */
    private function findNextUnmarkedNode(Node $node) {
        foreach ($node->getNextNodes() as $next_node) {
            if (!$next_node->isMarked()) {
                $connected_edge = $this->getEdge($node, $next_node);
                if ($connected_edge->getFlow() < $connected_edge->getCapacity()) {
                    return $next_node;
                }
            }
        }
        return null;
    }

    /**
     * @param Node $node
     * @return Node|null
     */
    private function findAndMarkPrevUnmarkedNode(Node $node) {
        $prev_unmarked_node = $this->findPrevUnmarkedNode($node);
        if ($prev_unmarked_node != null) {
            $connected_edge = $this->getEdge($prev_unmarked_node, $node);
            $prev_unmarked_node->setMark($node, (-1) * min(abs($node->getMark()->getValue()), $connected_edge->getFlow()));
            return $prev_unmarked_node;
        }
        else return null;
    }

    /**
     * @param Node $node
     * @return Node|null
     */
    private function findPrevUnmarkedNode(Node $node) {
        foreach ($node->getPrevNodes() as $prev_node) {
            if (!$prev_node->isMarked()) {
                $connected_edge = $this->getEdge($prev_node, $node);
                if ($connected_edge->getFlow() > 0) {
                    return $prev_node;
                }
            }
        }
        return null;
    }

    /**
     * @param Node $node_from
     * @param Node $node_to
     * @return DirectedEdge|null between two specified nodes
     */
    public function getEdge(Node $node_from, Node $node_to) {
        foreach ($this->edges as $edge) {
            if ($edge->getNodeFrom()->equals($node_from) && $edge->getNodeTo()->equals($node_to)) {
                return $edge;
            }
        }
        return null;
    }

    private function flushMarks() {
        foreach ($this->nodes as $node) {
            $node->setMark(null, 0);
        }
    }
}