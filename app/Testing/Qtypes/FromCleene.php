<?php
namespace App\Testing\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;
use Input;
use Session;
class FromCleene extends QuestionType {
    const type_code = 11;

    function __construct($id_question) {
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);
        $title = $this->getTitleWithImage($request);
        $answer = $request->input('answer');

        return ['title' => $title['ru_title'], 'answer' => $answer, 'points' => $options['points'],
            'difficulty' => $options['difficulty'],
            'discriminant' => $options['discriminant'], 'guess' => $options['guess'],
            'pass_time' => $options['pass_time'],
            'control' => $options['control'], 'translated' => $options['translated'],
            'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
            'title_eng' => $title['eng_title'], 'answer_eng' => $answer];
    }

    public function add(Request $request) {
        $data = $this->setAttributes($request);
        Question::insert(array('title' => $data['title'], 'variants' => $data['variants'],
            'answer' => $data['answer'], 'points' => $data['points'], 'difficulty' => $data['difficulty'],
            'discriminant' => $data['discriminant'], 'guess' => $data['guess'], 'pass_time' => $data['pass_time'],
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
        $eng_variants = explode("@", $question->eng_answer);
        return array('question' => $question, 'count' => $count, 'type_name' => $type_name,
            'images' => $images, 'variants' => $variants, 'eng_variants' => $eng_variants);
    }

    public function update(Request $request) {
        $data = $this->setAttributes($request);
        Question::whereId_question($this->id_question)->update(
            array('title' => $data['title'], 'variants' => $data['variants'],
                'answer' => $data['answer'], 'points' => $data['points'], 'difficulty' => $data['difficulty'],
                'discriminant' => $data['discriminant'], 'guess' => $data['guess'], 'pass_time' => $data['pass_time'],
                'control' => $data['control'], 'translated' => $data['translated'],
                'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
                'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng'])
        );
    }

    public function show($count) {
        $view = 'tests.show11';
        $array = array('view' => $view, 'arguments' => array('text' => explode('::',$this->text), "variants" => '', "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }
    public function check($array) {
        $score = 0;
        $right_percent = 0;

        $etalon = str_replace("-", " |-| ", $this->answer);
        $function = str_replace("-", " |-| ", $array[0]);

        $cmd = "/var/www/html/timelimit.sh '";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 0 0 == (\\x y ->" . $function . ") 0 0 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 1 1 == (\\x y ->" . $function . ") 1 1 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 2 2 == (\\x y ->" . $function . ") 2 2 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 3 3 == (\\x y ->" . $function . ") 3 3 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 5 8 == (\\x y ->" . $function . ") 5 8 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 1 3 == (\\x y ->" . $function . ") 1 3 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 0 5 == (\\x y ->" . $function . ") 0 5 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 11 0 == (\\x y ->" . $function . ") 11 0 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 14 25 == (\\x y ->" . $function . ") 14 25 \\n";
        $cmd = $cmd . "(\\x y ->" . $etalon . ") 10 10 == (\\x y ->" . $function . ") 10 10'";

        exec($cmd, $res);

        $countFalse = 0;
        $countTrue = 0;
        $pointsNumber = 10;
        foreach($res as $str){
            if(strstr($str,'False') !== false) $countFalse +=1;
            if(strstr($str,'True') !== false) $countTrue +=1;
        }

        if($countTrue == $pointsNumber) {
            $right_percent = 100;
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