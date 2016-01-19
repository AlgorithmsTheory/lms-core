<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 16:07
 */
namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Question;
use Illuminate\Http\Request;
class Definition extends QuestionType {
    const type_code = 7;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){
    }
    public function add(Request $request, $code){
        for ($i=0; $i<count($request->input('variants')); $i++){
            $title = $request->input('variants')[$i];
            $answer = $request->input('answers')[$i];
            Question::insert(array('code' => $code, 'title' => $title, 'variants' => '', 'answer' => $answer, 'points' => $request->input('points')));
        }
    }
    public function show($count){
        $view = 'tests.show7';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => '', "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }
    public function check($array){  //надо переделать
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
        $html .= '  Запишите определения</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%">';                                                          //чертим шапку
        $html .= '<tr><td width="20%" align="center">Термин</td>
                      <td width="80%" align="center">Определение</td></tr>';

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