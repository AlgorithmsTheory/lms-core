<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 16:07
 */
namespace App\Testing\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;

class Definition extends QuestionType {
    const type_code = 7;

    function __construct($id_question){
        parent::__construct($id_question);
    }

    public function add(Request $request) {
        $options = $this->getOptions($request);
        for ($i=0; $i<count($request->input('variants')); $i++){
            $title = $request->input('variants')[$i];
            $eng_title = $request->input('eng-variants')[$i];
            $answer = $request->input('answers')[$i];
            $eng_answer = $request->input('eng-answers')[$i];
            Question::insert(array('title' => $title, 'title_eng' => $eng_title,
                'answer' => $answer, 'answer_eng' => $eng_answer,
                'points' => $request->input('points'),
                'translated' => $options['translated'],
                'control' => $options['control'], 'section_code' => $options['section'],
                'theme_code' => $options['theme'], 'type_code' => $options['type']));
        }
    }

    public function edit() {
        $question = Question::whereId_question($this->id_question)->first();
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        return array('question' => $question, 'type_name' => $type_name);
    }

    public function update(Request $request) {
        $options = $this->getOptions($request);
        $title = $request->input('title');
        $eng_title = $request->input('eng-title');
        $answer = $request->input('answer');
        $eng_answer = $request->input('eng-answer');

        Question::whereId_question($this->id_question)->update(array('title' => $title, 'title_eng' => $eng_title,
            'answer' => $answer, 'answer_eng' => $eng_answer,
            'points' => $request->input('points'),
            'translated' => $options['translated'],
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
    }

    public function show($count) {
        $view = 'tests.show7';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => '', "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false, $paper_savings=false) {
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
                $html .= '<td height="85px"></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
} 