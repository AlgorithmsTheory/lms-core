<?php
/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:47
 */

namespace App\Testing\TestGeneration;

use App\Testing\Question;
use App\Testing\Section;
use App\Testing\Theme;
use App\Testing\Type;

class DirectedEdge {
    /**
     * @var EdgeType
     */
    private $type;

    /**
     * @var Node
     */
    private $node_from;

    /**
     * @var Node
     */
    private $node_to;

    /**
     * @var int
     */
    private $capacity;

    /**
     * @var int
     */
    private $flow;

    /**
     * @var bool
     */
    private $in_route;

    function __construct(Node $node_from, Node $node_to, $type, $test_type, $printable) {
        $this->type = $type;
        $this->node_from = $node_from;
        $this->node_to = $node_to;
        $this->setCapacity($test_type, $printable);
        $this->flow = 0;
        $this->in_route = false;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Node
     */
    public function getNodeFrom()
    {
        return $this->node_from;
    }

    /**
     * @return Node
     */
    public function getNodeTo()
    {
        return $this->node_to;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @return int
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * @return bool
     */
    public function isInRoute()
    {
        return $this->in_route;
    }



    public function changeFlow() {
        // TODO: depends on next route node mark
    }

    /**
     * @param string $test_type
     * @param int $printable
     */
    private function setCapacity($test_type, $printable) {
        switch ($this->type) {
            case EdgeType::BEGIN :
                $section_name = Section::whereSection_code($this->node_to->section_code)->select('section_name')->first()->section_name;
                $theme_name = Theme::whereTheme_code($this->node_to->theme_code)->select('theme_name')->first()->theme_name;
                $type_name = Type::whereType_code($this->node_to->type_code)->select('type_name')->first()->type_name;
                $this->capacity = Question::getAmount($section_name, $theme_name, $type_name, $test_type, $printable);
                break;
            case EdgeType::MIDDLE :
                $this->capacity = $this->node_to->amount;
                break;
            case EdgeType::END :
                $this->capacity = $this->node_from->amount;
                break;
        }
    }

    public function saturate(){
        $this->flow = $this->capacity;
    }

    public function isSaturated() {
        return $this->flow == $this->capacity;
    }
}