<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 16:07
 */
namespace App\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use Illuminate\Http\Request;

class FillGaps extends QuestionType {
    const type_code = 3;
    function __construct($id_question){
        parent::__construct($id_question);
    }

    public function add(Request $request){
        $options = $this->getOptions($request);
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
            //print_r($arr_answers);
        }
        $variants = $variants.'%'.$request->input('variants-1')[0];
        for ($i=2; $i<=$request->input('number_of_blocks'); $i++){
            $variants = $variants.';'.$request->input('variants-'.$i)[0];
        }
        $wet_text = $request->input('title');
        for ($i=0; $i<count($arr_answers); $i++){
            $wet_text = preg_replace('~'.explode('|',$arr_answers[$i])[0].'\|'.explode('|',$arr_answers[$i])[1].'~', '<>' , $wet_text);
        }
        Question::insert(array('title' => $wet_text, 'variants' => $variants,
            'answer' => $answers, 'points' => $request->input('points'),
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
    }
    public function show($count){
        $text_parts = explode("<>", $this->text);                                                                       //части текста между селектами
        $parse = explode("%", $this->variants);
        $variants = explode("<>", $parse[0]);
        $num_slot = count($variants);
        $parse_group_variants = [];
        $group_variants = [];
        $num_var = [];
        for ($i=0; $i < count($variants); $i++){
            $parse_group_variants[$i] = explode(";",$variants[$i]);                                                     //варинаты каждого селекта
            $group_variants[$i] = $this->question->mixVariants($parse_group_variants[$i]);                           //перемешиваем варианты
            $num_var[$i] = count($group_variants[$i]);
        }
        $view = 'tests.show3';
        $array = array('view' => $view, 'arguments' => array("variants" => $group_variants, "type" => self::type_code, "id" => $this->id_question, "text_parts" => $text_parts, "num_var" => $num_var, "num_slot" => $num_slot, "count" => $count));
        return $array;
    }
    public function check($array){
        $parse = explode("%", $this->variants);                                                                         //первый элемент - все варианты через <>, второй - стоимости через ;
        $variants = explode("<>", $parse[0]);
        $values = explode (";", $parse[1]);
        $parse_answer = $this->answer;
        $answer = explode(";", $parse_answer);
        $score = 0;
        $p = 0;                                                                                                         //счетчик правильных ответов
        for ($i=0; $i < count($variants); $i++){
            $step = $this->points * $values[$i];
            if ($array[$i] == $answer[$i]){
                $score +=$step;
                $p++;
            }
        }

        $right_percent = round($score/$this->points*100);
        if($p == count($variants))
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
               else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $text_parts = explode("<>", $this->text);                                                                       //части текста между селектами
        $parse = explode("%", $this->variants);
        $variants = explode("<>", $parse[0]);
        $num_slot = count($variants);
        $text = '';

        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Заполните пропуски в тексте так, чтобы получилось верное определение или утверждение</td></tr></table>';

        if ($answered){                                                                                                 // пдф с ответами
            $answers = explode(";", $this->answer);
            for ($i = 1; $i <= $num_slot; $i++){
                $text .= $text_parts[$i-1].'('.$i.' '.$answers[$i-1].') ';                                              //формируем текст вопроса без пропущенных слов
            }
            $text .= $text_parts[$num_slot];
            $html .= '<p>'.$text.'</p>';
            $html .= '<table>';
            for ($i = 1; $i <= $num_slot; $i++){                                                                        // вывод верных ответов
                $html .= '<tr><td>'.$i.': '.$answers[$i-1].'</td></tr>';
            }
            $html .= '</table>';
        }
        else{                                                                                                           // без ответов
            for ($i = 1; $i <= $num_slot; $i++){
                $text .= $text_parts[$i-1].$i.'_______________';                                                        //формируем текст вопроса
            }
            $text .= $text_parts[$num_slot];
            $parse_group_variants = [];
            $group_variants = [];
            $num_var = [];
            for ($i=0; $i < count($variants); $i++){
                $parse_group_variants[$i] = explode(";",$variants[$i]);                                                 //варинаты каждого селекта
                $group_variants[$i] = $this->question->mixVariants($parse_group_variants[$i]);                       //перемешиваем варианты
                $num_var[$i] = count($group_variants[$i]);
            }

            $html .= '<p>'.$text.'</p>';
            $html .= '<table>';
            for ($i = 1; $i <= $num_slot; $i++){                                                                        // вывод вариантов
                $html .= '<tr><td>'.$i.': ';
                for ($j = 0; $j < $num_var[$i-1] - 1; $j++){
                    $html .= $group_variants[$i-1][$j].', ';
                }
                $html .= $group_variants[$i-1][$j].'.</td></tr>';
            }
            $html .= '</table>';
        }
        $html .= '<br>';
        $fpdf->WriteHTML($html);
    }
} 