<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 16:07
 */

namespace App\Qtypes;
use App\Http\Controllers\QuestionController;

class FillGaps extends QuestionType {
    const type_code = 3;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){

    }

    public function show($count){
        $text_parts = explode("<>", $this->text);                         //части текста между селектами
        $parse = explode("%", $this->variants);
        $variants = explode("<>", $parse[0]);
        $num_slot = count($variants);
        $parse_group_variants = [];
        $group_variants = [];
        $num_var = [];
        for ($i=0; $i < count($variants); $i++){
            $parse_group_variants[$i] = explode(";",$variants[$i]);                //варинаты каждого селекта
            $group_variants[$i] = QuestionController::mixVariants($parse_group_variants[$i]);   //перемешиваем варианты
            $num_var[$i] = count($group_variants[$i]);
        }
        $view = 'tests.show3';
        $array = array('view' => $view, 'arguments' => array("variants" => $group_variants, "type" => self::type_code, "id" => $this->id_question, "text_parts" => $text_parts, "num_var" => $num_var, "num_slot" => $num_slot, "count" => $count));
        return $array;
    }

    public function check($array){
        $parse = explode("%", $this->variants);    //первый элемент - все варианты через <>, второй - стоимости через ;
        $variants = explode("<>", $parse[0]);
        $values = explode (";", $parse[1]);

        $parse_answer = $this->answer;
        $answer = explode(";", $parse_answer);
        $score = 0;
        $p = 0;                          //счетчик правильных ответов
        for ($i=0; $i < count($variants); $i++){
            $step = $this->points * $values[$i];
            if ($array[$i] == $answer[$i]){
                $score +=$step;
                $p++;
            }
        }
        if($p == count($variants))
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        //echo $score.'<br>';
        return $data;
    }
} 