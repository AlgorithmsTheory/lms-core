<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 17:21
 */
namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Question;
use Illuminate\Http\Request;

class YesNo extends QuestionType{
    const type_code = 5;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){
    }

    public function add(Request $request, $code){
        for ($i=0; $i<count($request->input('variants')); $i++){
            $title = $request->input('variants')[$i];
            if (isset($request->input('answers')[$i])){
                $answer = 'true';
            }
            else{
                $answer = 'false';
            }
            Question::insert(array('code' => $code, 'title' => $title, 'variants' => '', 'answer' => $answer, 'points' => $request->input('points')));
        }
    }

    public function show($count){
        $text_parse = $this->text;
        $text = explode(";" , $text_parse);
        $view = 'tests.show5';
        $array = array('view' => $view, 'arguments' => array('text' => $text, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array){
        $score = 0;
        $text_parse = $this->text;
        $text = explode(";" , $text_parse);
        $answer_parse = explode(";" ,$this->answer);
        $step = $this->points/count($answer_parse);
        for ($i = 0; $i < count($text); $i++){
            if($answer_parse[$i] == $array[$i]) $score += $step;
        }
        if ($score > $this->points){                    //если при округлении получилось больше максимального числа баллов
            $score = $this->points;
        }
        if ($score < 0){                          //если ушел в минус
            $score = 0;
        }
        if ($score != $this->points) {
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        }
        else {
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points);
        }
        return $data;
    }
} 