<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 15:49
 */

namespace App\Testing\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Type;
use Illuminate\Http\Request;
use Session;
use Input;

class MultiChoice extends QuestionType {
    const type_code = 2;

    function __construct($id_question) {
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);
        $title = $this->getTitleWithImage($request);

        $variants = $request->input('variants')[0];                                                                     //формирование вариантов
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        $eng_variants = $request->input('eng-variants')[0];
        for ($i=1; $i<count($request->input('eng-variants')); $i++){
            $eng_variants = $eng_variants.';'.$request->input('eng-variants')[$i];
        }

        $answers = '';
        $eng_answers = '';
        $flag = false;
        $j = 0;
        while ($flag != true && $j<count($request->input('answers'))){                                                  //формирование ответов
            if (isset($request->input('answers')[$j])){
                $answers = $request->input('variants')[$request->input('answers')[$j]-1];
                $eng_answers = $request->input('eng-variants')[$request->input('answers')[$j]-1];
                $j++;
                break;
            }
            $j++;
        }
        for ($i=$j; $i<count($request->input('answers')); $i++){
            if (isset($request->input('answers')[$i])){
                $answers = $answers.';'.$request->input('variants')[$request->input('answers')[$i]-1];
                $eng_answers = $eng_answers.';'.$request->input('eng-variants')[$request->input('answers')[$i]-1];
            }
        }
        return ['title' => $title['ru_title'], 'variants' => $variants,
                'answer' => $answers, 'points' => $options['points'],
                'control' => $options['control'], 'translated' => $options['translated'],
                'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
                'title_eng' => $title['eng_title'], 'variants_eng' => $eng_variants, 'answer_eng' => $eng_answers];
    }

    public function add(Request $request) {
        $data = $this->setAttributes($request);
        Question::insert(array('title' => $data['title'], 'variants' => $data['variants'],
            'answer' => $data['answer'], 'points' => $data['points'],
            'control' => $data['control'], 'translated' => $data['translated'],
            'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
            'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng']));
    }

    public function edit() {
        $question = Question::whereId_question($this->id_question)->first();
        $count = count(explode(";", $question->variants));
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        $images = explode("::", $question->title);
        $variants = explode(";", $question->variants);

        $answers = explode(";", $question->answer);
        $j = 0;
        $num_answers = [];
        for ($i = 0; $i < count($variants); $i++) {
            if ($variants[$i] == $answers[$j]) {
                array_push($num_answers, $i);
                $j++;
            }
        }
        $eng_variants = explode(";", $question->variants_eng);
        return array('question' => $question, 'count' => $count, 'type_name' => $type_name,
            'images' => $images, 'variants' => $variants, 'eng_variants' => $eng_variants, 'num_answers' => $num_answers);
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
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = $this->question->mixVariants($variants);
        $view = 'tests.show2';
        $array = array('view' => $view, 'arguments' => array('text' => explode('::',$this->text), "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array) {
        $choices = $array;
        $answers = explode(';', $this->answer);
        $score = 0;
        $step = $this->points/count($answers);
        for ($i=0; $i<count($answers); $i++ ){                                                                          //сравниваем каждый правильный ответ
            for ($j=0; $j<count($choices); $j++){                                                                       // с каждым выбранным
                if ($answers[$i] == $choices[$j]){
                    $buf = $choices[$j];
                    $choices[$j] = $choices[count($choices)-1];                                                         //меняем местами правильный ответ с последним для удаления
                    $choices[count($choices)-1] =  $buf;
                    array_pop($choices);                                                                                //удаляем правильный проверенный вариант из массива выбранных ответов
                    $score += $step;
                    break;
                }
            }
        }
        if (!(empty($choices))){                                                                                        //если выбраны лишние варианты
            for ($i=0; $i<count($choices); $i++){
                $score -= $step;
            }
        }
        if ($score > $this->points){                                                                                    //если при округлении получилось больше максимального числа баллов
            $score = $this->points;
        }
        if ($score < 0){                                                                                                //если ушел в минус
            $score = 0;
        }
        $right_percent = round($score/$this->points*100);
        if (round($score,4) == $this->points){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false) {
        $text_parse = explode('::', $this->text);
        $text = "";
        for ($i=0; $i < count($text_parse); $i++){                                                                      //обработка картинки в тексте вопроса
            if ($i % 2 == 1){
                $text_parse[$i] = '<img src="'.$text_parse[$i].'">';
            }
            $text .= $text_parse[$i];
        }

        $parse = $this->variants;
        $variants = explode(";", $parse);
        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Выберите один или несколько вариантов ответа</td></tr>';
        $html .= '<tr><td>'.$text.'</td></tr></table>';

        $html .= '<table border="1" style="border-collapse: collapse;" width="100%">';
        if ($answered){                                                                                                 // пдф с ответами
            $answers = explode(";", $this->answer);
            $new_variants = Session::get('saved_variants_order');
            for ($i = 0; $i < count($new_variants); $i++){                                                              // идем по всем вариантам
                $html .= '<tr>';
                for ($j = 0; $j < count($answers); $j++){                                                               // идем по всем ответам
                    if ($answers[$j] == $new_variants[$i]){                                                             // если вариант совпал с ответом
                        $html .= '<td width="5%" align="center">+</td><td width="80%">'.$new_variants[$i].'</td>';
                        break;
                    }
                    else{
                        if ($j == count($answers) - 1){                                                                 // проверяем, не все ли ответы просмотрены
                            $html .= '<td width="5%"></td><td width="80%">'.$new_variants[$i].'</td>';
                        }
                        else continue;                                                                                  // иначе смотрим следующий ответ
                    }
                    $html .= '</tr>';
                }
            }
            Session::forget('saved_variants_order');
        }
        else {                                                                                                          // без ответов
            $question = new Question();
            $new_variants = $question->mixVariants($variants);
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