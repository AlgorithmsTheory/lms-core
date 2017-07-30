<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 17:21
 */
namespace App\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;

class YesNo extends QuestionType{
    const type_code = 5;
    public $single = false;

    function __construct($id_question){
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {

    }

    public function add(Request $request){
        $options = $this->getOptions($request);
        for ($i=0; $i<count($request->input('variants')); $i++){
            $title = $request->input('variants')[$i];
            $eng_title = $request->input('eng-variants')[$i];
            if (in_array($i+1, $request->input('answers'))){
                $answer = 'true';
            }
            else{
                $answer = 'false';
            }
            Question::insert(array('title' => $title, 'variants' => '', 'answer' => $answer,
                'title_eng' => $eng_title, 'variants_eng' => '', 'answer_eng' => $answer,
                'points' => $request->input('points'), 'translated' => $options['translated'],
                'control' => $options['control'], 'section_code' => $options['section'],
                'theme_code' => $options['theme'], 'type_code' => $options['type']));
        }
    }

    public function edit(){
        $question = Question::whereId_question($this->id_question)->first();
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        return array('question' => $question, 'type_name' => $type_name);
    }

    public function update(Request $request)
    {
        $options = $this->getOptions($request);
        $title = $request->input('title');
        $eng_title = $request->input('eng-title');
        $answer = empty($request->input('answer')) ? 'false' : 'true';

        Question::whereId_question($this->id_question)->update(array('title' => $title, 'variants' => '', 'answer' => $answer,
            'title_eng' => $eng_title, 'variants_eng' => '', 'answer_eng' => $answer,
            'points' => $request->input('points'), 'translated' => $options['translated'],
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
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

        $right_percent = round($score/$this->points*100);
        if ($score != $this->points) {
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        }
        else {
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        }
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $text_parse = $this->text;
        $text = explode(";" , $text_parse);
        $answers = explode(';', $this->answer);

        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Укажите истинно или ложно утверждение</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%">';                                  //чертим шапку
        $html .= '<tr><td width="80%">Утверждение</td>
                      <td width="10%">Верно</td>
                      <td width="10%">Неверно</td></tr>';

        for ($i = 0; $i < count($text); $i++){
            $html .= '<tr><td>'.$text[$i].'</td>';                                                                      //утверждение
            if ($answered){                                                                                             //пдф с ответами
                if ($answers[$i] == 'true'){                                                                            //если истинно
                    $html .= '<td>Да</td>
                          <td></td></tr>';
                }
                else {                                                                                                  //если ложно
                    $html .= '<td></td>
                          <td>Нет</td></tr>';
                }
            }
            else {                                                                                                      //пдф без ответов
                $html .= '<td>Да</td>
                          <td>Нет</td></tr>';
            }
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
} 