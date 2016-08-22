<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 22:12
 */
namespace App\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use Illuminate\Http\Request;

class AccordanceTable extends QuestionType {
    const type_code = 4;
    function __construct($id_question){
        parent::__construct($id_question);
    }

    public function add(Request $request){
        $options = $this->getOptions($request);
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
        Question::insert(array('title' => $title, 'variants' => $variants,
            'answer' => $answer, 'points' => $request->input('points'),
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
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

        $right_percent = round($score/$this->points*100);
        if ($score == $this->points){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $buf_array, 'right_percent' => $right_percent);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $buf_array, 'right_percent' => $right_percent);
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $text_parse = $this->text;
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $num_var = count($variants);
        $text = explode(";" , $text_parse);
        $num_text = count($text);

        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Заполните таблицу соответствий</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%"><tr><td align="center">#</td>';
        for ($i = 0; $i < count($variants); $i++){                                                                      // формируем первую строку
            $html .= '<td>'.$variants[$i].'</td>';
        }
        $html .= '</tr>';

        if ($answered){                                                                                                 // пдф с ответами
            $answers = explode(";", $this->answer);
            $k = 0;
            for ($i = 0; $i < $num_text; $i++){                                                                         // формируем со второй по конечную строки
                $html .= '<tr><td>'.$text[$i].'</td>';                                                                               // в первом стобце всегда название объекта
                for ($j = 1; $j <= $num_var; $j++){                                                                     // идем по колонкам
                    if ($k < count($answers)){                                                                          // если еще не превысили размер массива ответов
                        if ($i*$num_var + $j == $answers[$k]){                                                          // если номер ячейки совпадает с ответом
                            $html .= '<td align="center">+</td>';
                            $k++;
                        }
                        else $html .= '<td></td>';
                    }
                    else $html .= '<td></td>';
                }
                $html .= '</tr>';
            }
        }
        else {                                                                                                          // без ответов
            for ($i = 0; $i < $num_text; $i++){                                                                         // формируем со второй по конечную строки
                $html .= '<tr><td>'.$text[$i].'</td>';
                for ($j = 1; $j <= $num_var; $j++){
                    $html .= '<td></td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
} 