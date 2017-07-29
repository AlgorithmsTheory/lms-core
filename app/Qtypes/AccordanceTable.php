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
use App\Testing\Type;
use Illuminate\Http\Request;

class AccordanceTable extends QuestionType {
    const type_code = 4;
    function __construct($id_question){
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);

        $title = $request->input('title')[0];
        for ($i = 1; $i < count($request->input('title')); $i++){
            $title = $title.';'.$request->input('title')[$i];
        }
        $title_eng = $request->input('eng-title')[0];
        for ($i = 1; $i < count($request->input('eng-title')); $i++){
            $title_eng = $title_eng.';'.$request->input('eng-title')[$i];
        }

        $variants = $request->input('variants')[0];
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        $variants_eng = $request->input('eng-variants')[0];
        for ($i=1; $i<count($request->input('eng-variants')); $i++){
            $variants_eng = $variants_eng.';'.$request->input('eng-variants')[$i];
        }

        $answer = $request->input('answer')[0];
        for ($i=1; $i<count($request->input('answer')); $i++){
            $answer = $answer.';'.$request->input('answer')[$i];
        }
        $answer_eng = $request->input('eng-answer')[0];
        for ($i=1; $i<count($request->input('eng-answer')); $i++){
            $answer_eng = $answer_eng.';'.$request->input('eng-answer')[$i];
        }

        return ['title' => $title, 'variants' => $variants,
            'answer' => $answer, 'points' => $request->input('points'),
            'control' => $options['control'], 'translated' => $options['translated'],
            'section_code' => $options['section'],
            'theme_code' => $options['theme'], 'type_code' => $options['type'],
            'title_eng' => $title_eng, 'variants_eng' => $variants_eng, 'answer_eng' => $answer_eng];
    }

    public function add(Request $request) {
        $data = $this->setAttributes($request);

        Question::insert(array('title' => $data['title'], 'variants' => $data['variants'],
            'answer' => $data['answer'], 'points' => $data['points'],
            'control' => $data['control'], 'translated' => $data['translated'],
            'section_code' => $data['section_code'], 'theme_code' => $data['theme_code'], 'type_code' => $data['type_code'],
            'title_eng' => $data['title_eng'], 'variants_eng' => $data['variants_eng'], 'answer_eng' => $data['answer_eng']));

    }

    public function edit(){
        $question = Question::whereId_question($this->id_question)->first();
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;
        $title = explode(";", $question->title);
        $eng_title = explode(";", $question->title_eng);
        $variants = explode(";", $question->variants);
        $eng_variants = explode(";", $question->variants_eng);
        $answers = explode(";", $question->answer);
        $eng_answers = explode(";", $question->answer_eng);
        return array('question' => $question, 'type_name' => $type_name,
            'title' => $title, 'eng_title' => $eng_title,
            'variants' => $variants, 'eng_variants' => $eng_variants,
            'answers' => $answers, 'eng_answers' => $eng_answers);
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
        $max_errors = 2;    //TODO: должно зависеть от чилса столбцов
        $rows_number = count(explode(";", $this->text));
        $columns_number = count(explode(";", $this->variants));
        $answer_parse = explode(";" ,$this->answer);                                                                    //массив правильных ответов

        $temp_i = 0;
        $temp_j = 0;

        for ($r = 1; $r <= $rows_number; $r++) {
            $errors_in_row = 0;
            for ($c = 1; $c <= $columns_number; $c++) {
                $is_answer = false;
                $is_chosen = false;
                $cell = ($r-1)*$columns_number + $c;
                for ($i = $temp_i; $i < count($answer_parse); $i++) {
                    if ($answer_parse[$i] == $cell) {
                        $is_answer = true;
                        $temp_i++;
                        break;
                    }
                }
                for ($j = $temp_j; $j < count($array); $j++) {
                    if ($array[$j] == $cell) {
                        $is_chosen = true;
                        $temp_j++;
                        break;
                    }
                }
                if ($is_answer != $is_chosen) {
                    $errors_in_row++;
                }
                if ($errors_in_row == $max_errors) {
                    break;
                }
                if ($c == $columns_number) {
                    $score += $this->points / (($errors_in_row + 1) * $rows_number);
                }
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