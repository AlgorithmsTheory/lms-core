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
    const GROUP_AMOUNT = 3;

    /**
     * @var Graph
     */
    private $graph;

    /**
     * @var int[]
     */
    private $chosen_questions;

    public function buildGraphFromTest(Test $test) {
        $id_test = $test->id_test;
        $record_nodes = [];
        $struct_nodes = [];
        $edges = [];
        $source_node = new Node();
        $source_node->setCapacity(1);
        $sink_node = new Node();
        $sink_node->setCapacity(-1);
        $records = StructuralRecord::whereId_test($id_test)->distinct()->select('section_code', 'theme_code', 'type_code')->get();
        foreach ($records as $record) {
            $node = new RecordNode($record->section_code, $record->theme_code, $record->type_code);
            $source_edge = new DirectedEdge($source_node, $node, EdgeType::BEGIN, $test->test_type, $test->only_for_print);
            array_push($record_nodes, $node);
            array_push($edges, $source_edge);
        }
        $structures = TestStructure::whereId_test($id_test)->get();
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
        $this->graph = new Graph($nodes, $edges);

        $this->graph->putInfoForNodes();
        $this->graph->setSource();
        $this->graph->setSink();
    }

    public function buildGraphFromRestrictions($restrictions) {
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

        $this->graph = new Graph($nodes, $edges);

        $this->graph->putInfoForNodes();
        $this->graph->setSource();
        $this->graph->setSink();
    }

    public function generate() {
        $this->graph->fordFulkersonMaxFlow();
        if (!$this->graph->isSaturated())
            throw new TestGenerationException("Test has unacceptable structure!");

        $array = [];
        $k = 0;
        foreach ($this->graph->getSource()->getNextNodes() as $record) {
            $temp_array = [];
            $amount = 0;
            foreach ($record->getNextNodes() as $struct_node) {
                $amount += $this->graph->getEdge($record, $struct_node)->getFlow();
            }
            if ($amount > 0) {
                $questions = Question::whereSection_code($record->section_code)
                                     ->whereTheme_code($record->theme_code)
                                     ->whereType_code($record->type_code)
                                     ->get();
                foreach ($questions as $question){
                        array_push($temp_array, $question['id_question']);
                }

                while ($amount > 0){
                    $temp_array = Question::randomArray($temp_array);                                                       //выбираем случайный вопрос
                    $temp_question = $temp_array[count($temp_array)-1];

                    if (Question::getSingle($temp_question)){                                                               //если вопрос одиночный (то есть как и было ранее)
                        $array[$k] = $temp_question;                                                                        //добавляем вопрос в выходной массив
                        $k++;
                        $amount--;
                        array_pop($temp_array);
                    }
                    else {                                                                                                  //если вопрос может использоваться только в группе
                        $query = Question::whereId_question($temp_question)->first();
                        $base_question_type = $query->type_code;                                                            //получаем код типа базового вопроса, для которого будем создавать группу
                        $max_id = Question::max('id_question');
                        $new_id = $max_id+1;
                        $new_title = $query->title;                                                                         //берем данные текущего вопроса
                        $new_answer = $query->answer;
                        array_pop($temp_array);                                                                             //и убираем его из массива

                        $new_temp_array = [];
                        foreach ($temp_array as $temp_question){                                                            // создаем массив из подходящих групповых вопросов
                            if (Question::whereId_question($temp_question)->first()->type_code == $base_question_type){
                                array_push($new_temp_array, $temp_question);
                            }
                        }

                        if (count($new_temp_array) < $this::GROUP_AMOUNT - 1){                                              // если нужных вопросов заведомо не хватит для составления группового вопроса
                            foreach ($new_temp_array as $question_for_remove){                                              // удаляем их из temp_array
                                $index_in_old_array = array_search($question_for_remove, $temp_array);                      //ищем в базовом массиве индекс нашего вопроса
                                $chosen = $temp_array[$index_in_old_array];                                                 //и меняем его с последним элементом в этом массиве
                                $temp_array[$index_in_old_array]=$temp_array[count($temp_array)-1];
                                $temp_array[count($temp_array)-1] = $chosen;
                                array_pop($temp_array);
                            }
                            continue;                                                                                       // продолжаем выбирать вопросы для этой структуры
                        }

                        $l = 1;
                        while ($l < $this::GROUP_AMOUNT) {                                                                  //берем 3 вопроса
                            $new_temp_array = Question::randomArray($new_temp_array);
                            $temp_question_new = $new_temp_array[count($new_temp_array)-1];

                            $index_in_old_array = array_search($temp_question_new, $temp_array);                            //ищем в базовом массиве индекс нашего вопроса
                            $chosen = $temp_array[$index_in_old_array];                                                     //и меняем его с последним элементом в этом массиве
                            $temp_array[$index_in_old_array]=$temp_array[count($temp_array)-1];
                            $temp_array[count($temp_array)-1] = $chosen;

                            $query_new = Question::whereId_question($temp_question_new)->first();
                            $new_title .= ';'.$query_new->title;                                                            //составляем составной вопрос
                            $new_answer .= ';'.$query_new->answer;
                            array_pop($temp_array);                                                                         //удаляем и из базового массива
                            array_pop($new_temp_array);                                                                     //и из нового
                            $l++;
                        }
                        Question::insert(array('id_question' => $new_id,'title' => $new_title,                              //вопрос про код и баллы
                            'variants' => '', 'answer' => $new_answer,
                            'points' => 1, 'control' => 0, 'theme_code' => -1,
                            'section_code' => -1, 'type_code' => $base_question_type));
                        $array[$k] = $new_id;                                                                               //добавляем сформированный вопрос в выходной массив
                        $k++;
                        $amount--;
                    }
                }
            }
        }
        $this->chosen_questions = $array;
    }

    /**
     * @return int
     */
    public function chooseQuestion() {
        if (empty($this->chosen_questions)){                                                                                             //если вопросы кончились, завершаем тест
            return -1;
        }
        else{
            $this->chosen_questions = Question::randomArray($this->chosen_questions);
            $chosen = $this->chosen_questions[count($this->chosen_questions) - 1];
            array_pop($this->chosen_questions);                                                                                          //удаляем его из списка
            return $chosen;
        }
    }

    /**
     * @return Graph
     */
    public function getGraph() {
        return $this->graph;
    }
}