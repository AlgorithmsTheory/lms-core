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

    public function setFlow($flow) {
        $this->flow = $flow;
    }

    /**
     * @param string $test_type
     * @param int $printable
     */
    private function setCapacity($test_type, $printable) {
        // TODO: count capacity using test's properties: print, lang, control
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

    /**
     * Fill the edge with @param int $flow
     * @return int filled flow
     */
    public function fill($flow) {
        if ($flow > $this->capacity) {
            if ($flow > $this->getNodeTo()->getLeftCapacity()) {
                $filled_flow = min($this->capacity, $this->getNodeTo()->getLeftCapacity());
            }
            else {
                $filled_flow = $this->capacity;
            }
        }
        else {
            if ($flow > $this->getNodeTo()->getLeftCapacity()) {
                $filled_flow = $this->getNodeTo()->getLeftCapacity();
            }
            else {
                $filled_flow = $flow;
            }
        }
        $this->flow += $filled_flow;
        $this->getNodeTo()->setFlow($this->getNodeTo()->getFlow() - $filled_flow);
        return $filled_flow;
    }

    public function isSaturated() {
        return $this->flow == $this->capacity;
    }
}