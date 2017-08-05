<?php
namespace App\Testing\TestGeneration;

use App\Testing\Question;
use App\Testing\Test;
use App\Testing\StructuralRecord;
use App\Testing\TestStructure;


/**
 * Created by PhpStorm.
 * User: ssorokin
 * Date: 30.07.2017
 * Time: 23:38
 */
class UsualTestGenerator implements TestGenerator {
    /**
     * @var Test
     */
    private $test;

    /**
     * @var Graph
     */

    private $graph;
    /**
     * @var int[]
     */
    private $available_questions;

    /**
     * @var int[]
     */
    private $chosen_questions;

    function __construct(Test $test) {
        $this->test = $test;
    }

    public function buildGraph() {
        $id_test = $this->test->id_test;
        $record_nodes = [];
        $struct_nodes = [];
        $edges = [];
        $source_node = new Node();
        $sink_node = new Node();
        $records = StructuralRecord::whereId_test($id_test)->distinct()->select('section_code', 'theme_code', 'type_code')->get();
        foreach ($records as $record) {
            $node = new RecordNode($record->section_code, $record->theme_code, $record->type_code);
            $source_edge = new DirectedEdge($source_node, $node, EdgeType::BEGIN, $this->test->test_type, $this->test->only_for_print);
            array_push($record_nodes, $node);
            array_push($edges, $source_edge);
        }
        $structures = TestStructure::whereId_test($id_test)->get();
        foreach ($structures as $structure) {
            $node = new StructuralNode($structure->id_structure, $structure->amount);
            $sink_edge = new DirectedEdge($node, $sink_node, EdgeType::END, $this->test->test_type, $this->test->only_for_print);
            array_push($struct_nodes, $node);
            array_push($edges, $sink_edge);
        }
        $nodes = array_merge($record_nodes, $struct_nodes);
        array_push($nodes, $source_node);
        array_push($nodes, $sink_node);

        $all_records = StructuralRecord::whereId_test($id_test)->get();
        foreach ($all_records as $record) {
            foreach ($record_nodes as $record_node) {
                if ($record_node->equalsToRecord($record)) {
                    $node_from = $record_node;
                    break;
                }
            }
            foreach ($struct_nodes as $struct_node) {
                if ($record->id_structure == $struct_node->id_structure) {
                    $node_to = $struct_node;
                    break;
                }
            }
            if (isset($node_from) && isset($node_to)) {
                $edge = new DirectedEdge($node_from, $node_to, EdgeType::MIDDLE, $this->test->test_type, $this->test->only_for_print);
                array_push($edges, $edge);
            }
            else {
                throw new TestGenerationException("Failed to build test graph!");
            }
        }
        $this->graph = new Graph($nodes, $edges);

        $this->graph->putInfoForNodes();
    }

    public function getAvailableQuestions() {
        // TODO: Implement getAvailableQuestions() method.
    }

    public function generate() {
        $this->graph->fordFulkersonMaxFlow();
    }

    public function chooseQuestion() {
        // TODO: Implement chooseQuestion() method.
    }
}