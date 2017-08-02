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
    private $type;
    private $node_from;
    private $node_to;
    private $capacity;
    private $flow;
    private $in_route;

    function __construct(Node $node_from, Node $node_to, $type, $test_type, $printable) {
        $this->type = $type;
        $this->node_from = $node_from;
        $this->node_to = $node_to;
        $this->setCapacity($test_type, $printable);
        $this->flow = 0;
        $this->in_route = false;
    }

    public function changeFlow() {
        // TODO: depends on next route node mark
    }

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
}