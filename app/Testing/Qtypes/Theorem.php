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

class Theorem extends QuestionType {
    const type_code = 6;

    function __construct($id_question){
        parent::__construct($id_question);
    }

    public function add(Request $request) {
        $options = $this->getOptions($request);
        Question::insert(array('title' => $request->input('title'), 'title_eng' => $request->input('eng-title'),
            'answer' => $request->input('answer'), 'answer_eng' => $request->input('eng-answer'),
            'points' => $request->input('points'), 'translated' => $options['translated'],
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
    }

    public function edit() {
        $question = Question::whereId_question($this->id_question)->first();
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        return array('question' => $question, 'type_name' => $type_name);
    }

    public function update(Request $request) {
        $options = $this->getOptions($request);
        Question::whereId_question($this->id_question)->update(array('title' => $request->input('title'), 'title_eng' => $request->input('eng-title'),
            'answer' => $request->input('answer'), 'answer_eng' => $request->input('eng-answer'),
            'points' => $request->input('points'), 'translated' => $options['translated'],
            'control' => $options['control'], 'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type']));
    }

    public function show($count) {
        $view = 'tests.show6';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => '', "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false) {
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