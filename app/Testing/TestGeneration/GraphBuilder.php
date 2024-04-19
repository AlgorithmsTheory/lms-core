<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 0:50
 */

namespace App\Testing\TestGeneration;


use App\Testing\StructuralRecord;
use App\Testing\Test;
use App\Testing\TestStructure;

class GraphBuilder {

    /**
     * @param $test Test
     * @return Graph
     * @throws TestGenerationException
     * Build dicotyledonous graph (source - records - structures - sink) with capacities and flows from existence test
     */
    public static function buildGraphFromTest(Test $test) {
        $id_test = $test->id_test;
        // Вершины "Записи Структур Теста".графа Исходят из Исходной вершины.
        $record_nodes = [];
        $struct_nodes = [];
        // Все Рёбра графа.
        $edges = [];
        $source_node = new Node();
        $source_node->setCapacity(1);
        $sink_node = new Node();
        $sink_node->setCapacity(-1);
        // Берём все Записи Теста
        // Запись (Структуры) = Раздел + ТемаРаздела + ТипВопроса
        $records = StructuralRecord::whereId_test($id_test)->distinct()->select('section_code', 'theme_code', 'type_code')->get();
        // Для каждой Записи Теста
        foreach ($records as $record) {
            // Создаём Вершину "Запись Структуры" в графе
            $node = new RecordNode($record->section_code, $record->theme_code, $record->type_code);
            // Проводим Ребро из Вершины-Источника в каждую Вершину "Запись Структуры"
            // Ребро хранит в capacity Число Вопросов, соответствующих Записи
            // (и параметрам теста: "Контрольный"/"Тренировочный", "Только для печати"/Нет).
            $source_edge = new DirectedEdge($source_node, $node, EdgeType::BEGIN, $test->test_type, $test->only_for_print);
            array_push($record_nodes, $node);
            array_push($edges, $source_edge);
        }
        // Загружаем все Структуры Теста
        $structures = TestStructure::whereId_test($id_test)->get();
        // Для каждой Структуры Теста
        foreach ($structures as $structure) {
            $node = new StructuralNode($structure->id_structure, $structure->amount);
            $sink_edge = new DirectedEdge($node, $sink_node, EdgeType::END, $test->test_type, $test->only_for_print);
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
                $edge = new DirectedEdge($node_from, $node_to, EdgeType::MIDDLE, $test->test_type, $test->only_for_print);
                array_push($edges, $edge);
            }
            else {
                throw new TestGenerationException("Failed to build test graph!");
            }
        }
        $graph = new Graph($nodes, $edges);

        $graph->putInfoForNodes();
        $graph->setSource();
        $graph->setSink();
        return $graph;
    }

    /**
     * @param $restrictions
     * @return Graph
     * @throws TestGenerationException
     * Build dicotyledonous graph (source - records - structures - sink) with capacities and flows from teacher's restrictions
     */
    public static function buildGraphFromRestrictions($restrictions) {
        $record_nodes = [];
        $struct_nodes = [];
        $edges = [];
        $source_node = new Node();
        $source_node->setCapacity(1);
        $sink_node = new Node();
        $sink_node->setCapacity(-1);
        $structures = $restrictions['structures'];
        foreach ($structures as $structure) {
            $struct_node = new StructuralNode($structure['id_structure'], $structure['amount']);
            $sink_edge = new DirectedEdge($struct_node, $sink_node, EdgeType::END,  $restrictions['test']->test_type, $restrictions['test']->only_for_print);
            array_push($struct_nodes, $struct_node);
            array_push($edges, $sink_edge);
            foreach ($structure['sections'] as $section) {
                foreach ($section['themes'] as $theme) {
                    foreach ($structure['types'] as $type) {
                        $record_node = new RecordNode($section['section_code'], $theme['theme_code'], $type['type_code']);
                        $in_array = false;
                        $exist_node = null;
                        foreach ($record_nodes as $exist_node) {
                            if ($exist_node->equalsForStructure($record_node)) {
                                $in_array = true;
                                break;
                            }
                        }
                        if (!$in_array) {
                            $source_edge = new DirectedEdge($source_node, $record_node, EdgeType::BEGIN, $restrictions['test']->test_type, $restrictions['test']->only_for_print);
                            array_push($record_nodes, $record_node);
                            array_push($edges, $source_edge);
                            $edge = new DirectedEdge($record_node, $struct_node, EdgeType::MIDDLE, $restrictions['test']->test_type, $restrictions['test']->only_for_print);
                            array_push($edges, $edge);
                        }
                        else {
                            $edge = new DirectedEdge($exist_node, $struct_node, EdgeType::MIDDLE, $restrictions['test']->test_type, $restrictions['test']->only_for_print);
                            array_push($edges, $edge);
                        }
                    }
                }
            }
        }
        $nodes = array_merge($record_nodes, $struct_nodes);
        array_push($nodes, $source_node);
        array_push($nodes, $sink_node);

        $graph = new Graph($nodes, $edges);

        $graph->putInfoForNodes();
        $graph->setSource();
        $graph->setSink();
        return $graph;
    }
}