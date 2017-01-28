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

class Theorem extends QuestionType {
    const type_code = 6;
    function __construct($id_question){
        parent::__construct($id_question);
    }

    public function add(Request $request){
        $options = $this->getOptions($request);
        Question::insert(array('title' => $request->input('title'), 'variants' => '',
            'answer' => '', 'points' => $request->input('points'),
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
    }

    public function edit(){

    }


    public function show($count){
        $view = 'tests.show6';
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
        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Напишите или продолжите формулировку и приведите доказательство теоремы</td></tr>';
        $html .= '<tr><td>'.$this->text.'</td></tr></table>';

        if ($answered){                                                                                                 // с ответами
            $html .= '<table border="1" style="border-collapse: collapse;" width="100%">                                                       //блок для формулировки
                            <tr><td height="80px">'.$this->variants.'</td></tr>
                      </table>';
            $html .= '<p>Доказательство:</p>';
            $html .= '<table border="1" style="border-collapse: collapse;" width="100%">                                                       //блок для доказательства
                        <tr><td height="250px">'.$this->answer.'</td></tr>
                      </table><br>';
            $fpdf->WriteHTML($html);
        }
        else{
            $html .= '<table border="1" style="border-collapse: collapse;" width="100%">                                                       //блок для формулировки
                            <tr><td height="80px"></td></tr>
                      </table>';
            $html .= '<p>Доказательство:</p>';
            $html .= '<table border="1" style="border-collapse: collapse;" width="100%">                                                       //блок для доказательства
                        <tr><td height="500px"></td></tr>
                      </table><br>';
            $fpdf->WriteHTML($html);
        }
    }
} 