<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 16:07
 */

namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Question;
use Illuminate\Http\Request;

class FillGaps extends QuestionType {
    const type_code = 3;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){

    }

    public function add(Request $request, $code){
        $variants = '';
        $arr_answers = [];
        $answers = explode('|',$request->input('variants-1')[1])[0];
        for ($i=0; $i<$request->input('number_of_blocks'); $i++){
            for ($j=1; $j<count($request->input('variants-'.($i+1))); $j++){
                if ($i == 0 && $j == 1){
                    $variants = explode('|',$request->input('variants-'.($i+1))[$j])[0];
                }
                if ($j == 1 && $i != 0){
                    $variants = $variants.'<>'.explode('|',$request->input('variants-'.($i+1))[$j])[0];
                }
                if ($j != 1 ){
                    $variants = $variants.';'.$request->input('variants-'.($i+1))[$j];
                }
            }
            if ($i != 0){
                $answers = $answers.';'.explode('|',$request->input('variants-'.($i+1))[1])[0];
            }
            $arr_answers[$i] = $request->input('variants-'.($i+1))[1];
            print_r($arr_answers);
        }
        $variants = $variants.'%'.$request->input('variants-1')[0];
        for ($i=2; $i<=$request->input('number_of_blocks'); $i++){
            $variants = $variants.';'.$request->input('variants-'.$i)[0];
        }
        $wet_text = $request->input('title');
        for ($i=0; $i<count($arr_answers); $i++){
            $wet_text = preg_replace('~'.explode('|',$arr_answers[$i])[0].'\|'.explode('|',$arr_answers[$i])[1].'~', '<>' , $wet_text);
        }
        Question::insert(array('code' => $code, 'title' => $wet_text, 'variants' => $variants, 'answer' => $answers, 'points' => $request->input('points')));
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