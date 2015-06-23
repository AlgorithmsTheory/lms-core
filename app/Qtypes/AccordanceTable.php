<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 22:12
 */

namespace App\Qtypes;


class AccordanceTable extends QuestionType {
    const type_code = 4;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){

    }

    public function show($count){
        $text_parse = $this->text;
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $num_var = count($variants);
        $text = explode(";" , $text_parse);
        $view = 'tests.show4';
        $array = array('view' => $view, 'arguments' => array('text' => $text, 'variants' => $variants, 'num_var' => $num_var, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array){
        $score = 0;
        $answer_parse = explode(";" ,$this->answer);     //массив правильных ответов
        $step = $this->points/count($answer_parse);
        for($i=0; $i<count($answer_parse); $i++){                 //перебор всех правильных ответов
            for ($j=0; $j<count($array); $j++){
                if($answer_parse[$i] == $array[$j]){
                    $buf = $array[$j];
                    $array[$j] = $array[count($array)-1];     //меняем местами правильный ответ с последним для удаления
                    $array[count($array)-1] =  $buf;
                    array_pop($array);
                    $score+=$step;
                    break;
                }
            }
        }
        if (!(empty($array))){
            for($i = 0; $i < count($array) ; $i++) {
                $score-=$step;
            }
        }
        if ($score > $this->points){                    //если при округлении получилось больше максимального числа баллов
            $score = $this->points;
        }
        if ($score < 0){                                //если ушел в минус
            $score = 0;
        }

        if ($score == $this->points){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        //echo $score.'<br>';
        return $data;
    }
} 