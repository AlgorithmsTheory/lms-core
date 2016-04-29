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

class JustAnswer extends QuestionType {
    const type_code = 8;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){
    }
    public function add(Request $request){
        $options = $this->getOptions($request);
        for ($i=0; $i<count($request->input('variants')); $i++){
            $title = $request->input('variants')[$i];
            $answer = $request->input('answers')[$i];
            Question::insert(array('title' => $title, 'variants' => '',
                'answer' => $answer, 'points' => $request->input('points'),
                'control' => $options['control'], 'section_code' => $options['section'],
                'theme_code' => $options['theme'], 'type_code' => $options['type']));
        }
    }
    public function show($count){
        $view = 'tests.show8';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => '', "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }
    public function check($array){ //надо переделать
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
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array);
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array);
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $text_parse = $this->text;
        $text = explode(";" , $text_parse);
        $answers = explode(';', $this->answer);

        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Впишите ответы</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%">';                                                          //чертим шапку
        $html .= '<tr><td width="35%" align="center">Задание</td>
                      <td width="65%" align="center">Ответ</td></tr>';

        for ($i = 0; $i < count($text); $i++){
            $html .= '<tr><td>'.$text[$i].'</td>';                                                                      //утверждение
            if ($answered){                                                                                             //пдф с ответами                                                                         //если истинно
                $html .= '<td>'.$answers[$i].'</td>';
            }
            else {                                                                                                      //пдф без ответов
                $html .= '<td></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
} 