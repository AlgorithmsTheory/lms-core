<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 15:49
 */

namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Question;
use Illuminate\Http\Request;

class MultiChoice extends QuestionType {
    const type_code = 2;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){

    }

    public function add(Request $request, $code){
        $variants = $request->input('variants')[0];
        $answers = '';
        $flag = false;
        $j = 0;
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        while ($flag != true && $j<count($request->input('answers'))){
            if (isset($request->input('answers')[$j])){
                $answers = $request->input('variants')[$request->input('answers')[$j]-1];
                $j++;
                break;
            }
            $j++;
        }
        for ($i=$j; $i<count($request->input('answers')); $i++){
            if (isset($request->input('answers')[$i])){
                $answers = $answers.';'.$request->input('variants')[$request->input('answers')[$i]-1];
            }
        }
        Question::insert(array('code' => $code, 'title' => $request->input('title'), 'variants' => $variants, 'answer' => $answers, 'points' => $request->input('points')));
    }

    public function show($count){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = QuestionController::mixVariants($variants);
        $view = 'tests.show2';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array){
        $choices = $array;
        $answers = explode(';', $this->answer);
        $score = 0;
        $step = $this->points/count($answers);
        for ($i=0; $i<count($answers); $i++ ){        //сравниваем каждый правильный ответ
            for ($j=0; $j<count($choices); $j++){      // с каждым выбранным
                if ($answers[$i] == $choices[$j]){
                    $buf = $choices[$j];
                    $choices[$j] = $choices[count($choices)-1];     //меняем местами правильный ответ с последним для удаления
                    $choices[count($choices)-1] =  $buf;
                    array_pop($choices);                         //удаляем правильный проверенный вариант из массива выбранных ответов
                    $score += $step;
                    break;
                }
            }
        }
        if (!(empty($choices))){                    //если выбраны лишние варианты
            for ($i=0; $i<count($choices); $i++){
                $score -= $step;
            }
        }
        if ($score > $this->points){                    //если при округлении получилось больше максимального числа баллов
            $score = $this->points;
        }
        if ($score < 0){                          //если ушел в минус
            $score = 0;
        }

        if ($score == $this->points){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array);
        //echo $score.'<br>';
        return $data;
    }
} 