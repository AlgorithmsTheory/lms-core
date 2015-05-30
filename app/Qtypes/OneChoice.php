<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 13:49
 */

namespace App\Qtypes;
use App\Http\Controllers\QuestionController;


class OneChoice extends QuestionType {
    const type_code = 1;
    function __construct($id_question){
       parent::__construct($id_question);
    }
    public function  create(){

    }

    public function show($count){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = QuestionController::mixVariants($variants);
        $view = 'tests.show1';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array){
        if ($array[0] == $this->answer){
            $score = $this->points;
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        }
        else {
            $score = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        }
        //echo $score.'<br>';
        if ($score != $this->points){
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        }
        //echo $score.'<br>';
        return $data;
    }

} 