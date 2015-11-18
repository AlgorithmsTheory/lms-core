<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 22:12
 */
namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Question;
use Illuminate\Http\Request;

class AccordanceTable extends QuestionType {
    const type_code = 4;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){
    }

    public function add(Request $request, $code){ //были изменения
        $variants = $request->input('variants')[0];
        $answer = '';
        $flag = false;
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        $title = $request->input('title')[0];
        for ($i=1; $i<count($request->input('title')); $i++){
            $title = $title.';'.$request->input('title')[$i];
        }
// $j = 0;
// while ($flag != true && $j<count($request->input('answer'))){
// if (isset($request->input('answer')[$j])){
// $answer = $j + 1;
// $j++;
// break;
// }
// $j++;
// }
        $answer = $request->input('answer')[0];
        for ($i=1; $i<count($request->input('answer')); $i++){
            $answer = $answer.';'.$request->input('answer')[$i];
        }
        Question::insert(array('code' => $code, 'title' => $title, 'variants' => $variants, 'answer' => $answer, 'points' => $request->input('points')));
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
        $buf_array = $array;
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
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $buf_array);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $buf_array);
        //echo $score.'<br>';
        return $data;
    }
} 