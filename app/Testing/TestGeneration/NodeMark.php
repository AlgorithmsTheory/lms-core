<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 04.08.2017
 * Time: 17:17
 */

namespace App\Testing\TestGeneration;


class NodeMark {
    /**
     * @var Node which generate this mark
     */
    private $node_from;

    /**
     * @var int
     */
    private $value;

    function __construct() {
        $this->node_from = null;
        $this->value = 0;
    }

    /**
     * @return Node
     */
    public function getNodeFrom() {
        return $this->node_from;
    }

    public function getValue() {
        return $this->value;
    }

    public function setNodeFrom($node_from) {
        $this->node_from = $node_from;
    }

    public function setValue($value) {
        $this->value = $value;
    }
}