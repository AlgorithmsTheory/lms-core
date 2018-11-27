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
     * @var Graph
     */
    private $graph;

    /**
     * @var int[]
     */
    private $chosen_questions;

    public function generate(Test $test) {
        $this->graph = GraphBuilder::buildGraphFromTest($test);
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

                    if (Question::isSingle($temp_question)){                                                               //если вопрос одиночный (то есть как и было ранее)
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

                        if (count($new_temp_array) < Question::GROUP_AMOUNT - 1){                                              // если нужных вопросов заведомо не хватит для составления группового вопроса
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
                        while ($l < Question::GROUP_AMOUNT) {                                                                  //берем 3 вопроса
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