<?php
namespace App\Testing\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;
use Input;
use Session;
class JustAnswer extends QuestionType {
    const type_code = 8;

    function __construct($id_question) {
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);
        $title = $this->getTitleWithImage($request);

        $variants = $request->input('variants')[0];
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.'@'.$request->input('variants')[$i];
        }

        $eng_variants = $request->input('eng-variants')[0];
        for ($i=1; $i<count($request->input('eng-variants')); $i++){
            $eng_variants = $eng_variants.'@'.$request->input('eng-variants')[$i];
        }

        return ['title' => $title['ru_title'], 'variants' => '',
            'answer' => $variants, 'points' => $options['points'],
            'control' => $options['control'], 'translated' => $options['translated'],
            'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
            'title_eng' => $title['eng_title'], 'variants_eng' => '', 'answer_eng' => $eng_variants];
    }

    public  function add(Request $request) {
        $data = $this->setAttributes($request);
        Question::insert(array('title' => $data['title'], 'variants' => $data['variants'],
            'answer' => $data['answer'], 'points' => $data['points'],
            'control' => $data['control'], 'translated' => $data['translated'],
            'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
            'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng']));
    }

    public function edit() {
        $question = Question::whereId_question($this->id_question)->first();
        $count = count(explode("@", $question->answer));
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        $images = explode("::", $question->title);
        $variants = explode("@", $question->answer);
        $eng_variants = explode("@", $question->answer_eng);
        return array('question' => $question, 'count' => $count, 'type_name' => $type_name,
            'images' => $images, 'variants' => $variants, 'eng_variants' => $eng_variants);
    }

    public function update(Request $request) {
        $data = $this->setAttributes($request);
        Question::whereId_question($this->id_question)->update(
            array('title' => $data['title'], 'variants' => $data['variants'],
                'answer' => $data['answer'], 'points' => $data['points'],
                'control' => $data['control'], 'translated' => $data['translated'],
                'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
                'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng'])
        );
    }

    public function show($count) {
        $view = 'tests.show8';
        $array = array('view' => $view, 'arguments' => array('text' => explode('::',$this->text), "variants" => '', "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array) {
        $answers = explode("@",  $this->answer);
        $score = 0;
        $right_percent = 0;

        foreach ($answers as $ans){
            $l = strtoupper($array[0]);
            if( strtolower($array[0]) == strtolower($ans)){
                $score = $this->points;
                $right_percent = 100;
            }
        }
        if ($right_percent == 100){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0], 'right_percent' => $right_percent);
        }
        else {
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0], 'right_percent' => $right_percent);
        }
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false) {
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Выберите один вариант ответа</td></tr>';
        $html .= '<tr><td>'.$this->text.'</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%">';
        if ($answered){                                                                                                 // пдф с ответами
            $answer = $this->answer;
            $new_variants = Session::get('saved_variants_order');
            foreach ($new_variants as $var){
                $html .= '<tr>';
                if ($answer == $var)
                    $html .= '<td width="5%" align="center">+</td><td width="80%">'.$var.'</td>';
                else
                    $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
            Session::forget('saved_variants_order');
        }
        else {                                                                                                          // без ответов
            $new_variants = $this->question->mixVariants($variants);
            Session::put('saved_variants_order', $new_variants);
            foreach ($new_variants as $var){
                $html .= '<tr>';
                $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
} 