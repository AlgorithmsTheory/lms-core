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

class FillGaps extends QuestionType {
    const type_code = 3;

    function __construct($id_question){
        parent::__construct($id_question);
    }

    private function setAttributes(Request $request) {
        $options = $this->getOptions($request);
        // Для русской части
        $variants = '';
        $arr_answers = [];
        $answers = explode('|',$request->input('variants-1')[1])[0];
        for ($i=0; $i<$request->input('number_of_blocks'); $i++){
            for ($j=1; $j<count($request->input('variants-'.($i+1))); $j++){
                if ($i == 0 && $j == 1){
                    $variants = explode('|',$request->input('variants-'.($i+1))[$j])[0];
                }
                if ($j == 1 && $i != 0){
                    $variants = $variants.'<>'.explode('|',$request->input('variants-'.($i+1))[$j])[0];
                }
                if ($j != 1 ){
                    $variants = $variants.';'.$request->input('variants-'.($i+1))[$j];
                }
            }
            if ($i != 0){
                $answers = $answers.';'.explode('|',$request->input('variants-'.($i+1))[1])[0];
            }
            $arr_answers[$i] = $request->input('variants-'.($i+1))[1];
        }
        $variants = $variants.'%'.$request->input('variants-1')[0];
        for ($i=2; $i<=$request->input('number_of_blocks'); $i++){
            $variants = $variants.';'.$request->input('variants-'.$i)[0];
        }
        $wet_text = $request->input('title');
        for ($i=0; $i<count($arr_answers); $i++){
            $wet_text = preg_replace('~'.explode('|',$arr_answers[$i])[0].'\|'.explode('|',$arr_answers[$i])[1].'~', '<>' , $wet_text);
        }

        // Для английской части
        $eng_variants = '';
        $eng_arr_answers = [];
        $eng_answers = explode('|',$request->input('eng-variants-1')[1])[0];
        for ($i=0; $i<$request->input('eng_number_of_blocks'); $i++){
            for ($j=1; $j<count($request->input('eng-variants-'.($i+1))); $j++){
                if ($i == 0 && $j == 1){
                    $eng_variants = explode('|',$request->input('eng-variants-'.($i+1))[$j])[0];
                }
                if ($j == 1 && $i != 0){
                    $eng_variants = $eng_variants.'<>'.explode('|',$request->input('eng-variants-'.($i+1))[$j])[0];
                }
                if ($j != 1 ){
                    $eng_variants = $eng_variants.';'.$request->input('eng-variants-'.($i+1))[$j];
                }
            }
            if ($i != 0){
                $eng_answers = $eng_answers.';'.explode('|',$request->input('eng-variants-'.($i+1))[1])[0];
            }
            $eng_arr_answers[$i] = $request->input('eng-variants-'.($i+1))[1];
        }
        $eng_variants = $eng_variants.'%'.$request->input('eng-variants-1')[0];
        for ($i=2; $i<=$request->input('eng_number_of_blocks'); $i++){
            $eng_variants = $eng_variants.';'.$request->input('eng-variants-'.$i)[0];
        }
        $eng_wet_text = $request->input('eng-title');
        for ($i=0; $i<count($eng_arr_answers); $i++){
            $eng_wet_text = preg_replace('~'.explode('|',$eng_arr_answers[$i])[0].'\|'.explode('|',$eng_arr_answers[$i])[1].'~', '<>' , $eng_wet_text);
        }

        return ['title' => $wet_text, 'variants' => $variants,
            'answer' => $answers, 'points' => $options['points'], 'difficulty' => $options['difficulty'],
            'discriminant' => $options['discriminant'], 'guess' => $options['guess'],
            'pass_time' => $options['pass_time'],
            'control' => $options['control'], 'translated' => $options['translated'],
            'section_code' => $options['section'], 'theme_code' => $options['theme'], 'type_code' => $options['type'],
            'title_eng' => $eng_wet_text, 'variants_eng' => $eng_variants, 'answer_eng' => $eng_answers];
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
        $type_name = Type::whereType_code($question->type_code)->select('type_name')->first()->type_name;

        // русская часть
        $prepared_spans = "";
        $clear_text = "";
        $variants = [];
        $j = 1;
        $k = 0;

        $all_variants = preg_split("/%/", $this->variants, -1, PREG_SPLIT_NO_EMPTY);
        $costs = preg_split("/;/", $all_variants[1], -1, PREG_SPLIT_NO_EMPTY);
        $split_variants = preg_split("/<>/", $all_variants[0], -1, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($split_variants); $i++) {
            $variants[$i] = preg_split("/;/", $split_variants[$i], -1, PREG_SPLIT_NO_EMPTY);
        }


        $words_number = count(preg_split('/[\s,\.\?!-:"]+/', $this->text, -1, PREG_SPLIT_NO_EMPTY));
        $js_span_edge = $words_number;
        $answers = preg_split("/;/", $this->answer, -1, PREG_SPLIT_NO_EMPTY);

        $text_parts = preg_split('/([\s|,|\.|\?|!|-|:|"]+)/', $this->text, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_pop($text_parts);
        for ($i = 0; $i < count($text_parts); $i++) {                                                                   // идем по всем словам
            if (preg_match('/\s|,|\.|\?|!|-|:|"/', $text_parts[$i]) == 1) {                                             // если попали на разделитель
                $prepared_spans .= '<span>'.$text_parts[$i].'</span>';
                $clear_text .= $text_parts[$i];
            }
            else {
                if (preg_match('/<>/', $text_parts[$i]) == 1) {                                                         // если попали на пропущенное слово(а)
                    if (count(preg_split('/[\s,\.\?!-:"]+/', $answers[$k], -1, PREG_SPLIT_NO_EMPTY)) > 1) {             // если в ответе более одного слова
                        $prepared_spans .= '<span id="text-part-'.$words_number.'" style="cursor:pointer; background-color:lightgreen;">';    //создаем специальный оберточный спан
                        $variants[$k]['span'] = $words_number;
                        $words_number++;

                        $answer_parts = preg_split('/(\s|,|\.|\?|!|-|:|")/', $answers[$k], -1, PREG_SPLIT_DELIM_CAPTURE);
                        for ($l = 0; $l < count($answer_parts); $l++) {
                            if (preg_match('/\s|,|\.|\?|!|-|:|"/', $answer_parts[$l]) == 1) {                                             // если попали на разделитель
                                $prepared_spans .= '<span>'.$answer_parts[$l].'</span>';
                            }
                            else {
                                $prepared_spans .= '<span id="text-part-'.$j.'" class="text-part inside" style="cursor:pointer">'.$answer_parts[$l].'</span>';
                                $j++;
                            }
                            $clear_text .= $answer_parts[$l];
                        }
                        $prepared_spans .= '</span>';
                    }
                    else {                                                                                              // если в ответе одно слово
                        $prepared_spans .= '<span id="text-part-'.$j.'" class="text-part" style="cursor:pointer; background-color:lightgreen;">'.$answers[$k].'</span>';
                        $clear_text .= $answers[$k];
                        $variants[$k]['span'] = $j;
                        $j++;
                    }
                    $k++;
                }
                else {                                                                                                  //если попали на простое слово
                    $prepared_spans .= '<span id="text-part-'.$j.'" class="text-part" style="cursor:pointer">'.$text_parts[$i].'</span>';
                    $clear_text .= $text_parts[$i];
                    $j++;
                }
            }
        }

        // английская часть
        $eng_prepared_spans = "";
        $eng_clear_text = "";
        $eng_variants = [];
        $j = 1;
        $k = 0;

        $eng_all_variants = preg_split("/%/", $this->eng_variants, -1, PREG_SPLIT_NO_EMPTY);
        $eng_costs = preg_split("/;/", $eng_all_variants[1], -1, PREG_SPLIT_NO_EMPTY);
        $eng_split_variants = preg_split("/<>/", $eng_all_variants[0], -1, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($eng_split_variants); $i++) {
            $eng_variants[$i] = preg_split("/;/", $eng_split_variants[$i], -1, PREG_SPLIT_NO_EMPTY);
        }


        $eng_words_number = count(preg_split('/[\s,\.\?!-:"]+/', $this->eng_text, -1, PREG_SPLIT_NO_EMPTY));
        $eng_js_span_edge = $eng_words_number;
        $eng_answers = preg_split("/;/", $this->eng_answer, -1, PREG_SPLIT_NO_EMPTY);

        $eng_text_parts = preg_split('/([\s|,|\.|\?|!|-|:|"]+)/', $this->eng_text, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_pop($eng_text_parts);
        for ($i = 0; $i < count($eng_text_parts); $i++) {                                                                   // идем по всем словам
            if (preg_match('/\s|,|\.|\?|!|-|:|"/', $eng_text_parts[$i]) == 1) {                                             // если попали на разделитель
                $eng_prepared_spans .= '<span>'.$eng_text_parts[$i].'</span>';
                $eng_clear_text .= $eng_text_parts[$i];
            }
            else {
                if (preg_match('/<>/', $eng_text_parts[$i]) == 1) {                                                         // если попали на пропущенное слово(а)
                    if (count(preg_split('/[\s,\.\?!-:"]+/', $eng_answers[$k], -1, PREG_SPLIT_NO_EMPTY)) > 1) {             // если в ответе более одного слова
                        $eng_prepared_spans .= '<span id="eng-text-part-'.$eng_words_number.'" style="cursor:pointer; background-color:lightgreen;">';    //создаем специальный оберточный спан
                        $eng_variants[$k]['span'] = $eng_words_number;
                        $eng_words_number++;

                        $eng_answer_parts = preg_split('/(\s|,|\.|\?|!|-|:|")/', $eng_answers[$k], -1, PREG_SPLIT_DELIM_CAPTURE);
                        for ($l = 0; $l < count($eng_answer_parts); $l++) {
                            if (preg_match('/\s|,|\.|\?|!|-|:|"/', $eng_answer_parts[$l]) == 1) {                                             // если попали на разделитель
                                $eng_prepared_spans .= '<span>'.$eng_answer_parts[$l].'</span>';
                            }
                            else {
                                $eng_prepared_spans .= '<span id="eng-text-part-'.$j.'" class="eng-text-part eng-inside" style="cursor:pointer">'.$eng_answer_parts[$l].'</span>';
                                $j++;
                            }
                            $eng_clear_text .= $eng_answer_parts[$l];
                        }
                        $eng_prepared_spans .= '</span>';
                    }
                    else {                                                                                              // если в ответе одно слово
                        $eng_prepared_spans .= '<span id="eng-text-part-'.$j.'" class="eng-text-part" style="cursor:pointer; background-color:lightgreen;">'.$eng_answers[$k].'</span>';
                        $eng_clear_text .= $eng_answers[$k];
                        $eng_variants[$k]['span'] = $j;
                        $j++;
                    }
                    $k++;
                }
                else {                                                                                                  //если попали на простое слово
                    $eng_prepared_spans .= '<span id="eng-text-part-'.$j.'" class="eng-text-part" style="cursor:pointer">'.$eng_text_parts[$i].'</span>';
                    $eng_clear_text .= $eng_text_parts[$i];
                    $j++;
                }
            }
        }
        return array('question' => $question, 'type_name' => $type_name, 'text' => $prepared_spans, 'variants' => $variants,
                     'costs' => $costs, 'clear_text' => $clear_text,
                     'js_span_last' => $words_number, 'js_span_edge' => $js_span_edge, 'js_word_number' => count($answers)+1,
                     'eng_text' => $eng_prepared_spans, 'eng_variants' => $eng_variants,
                     'eng_costs' => $eng_costs, 'eng_clear_text' => $eng_clear_text,
                     'eng_js_span_last' => $eng_words_number, 'eng_js_span_edge' => $eng_js_span_edge, 'eng_js_word_number' => count($eng_answers)+1);
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
        $text_parts = explode("<>", $this->text);                                                                       //части текста между селектами
        $parse = explode("%", $this->variants);
        $variants = explode("<>", $parse[0]);
        $num_slot = count($variants);
        $parse_group_variants = [];
        $group_variants = [];
        $num_var = [];
        for ($i=0; $i < count($variants); $i++){
            $parse_group_variants[$i] = explode(";",$variants[$i]);                                                     //варинаты каждого селекта
            $group_variants[$i] = $this->question->mixVariants($parse_group_variants[$i]);                              //перемешиваем варианты
            $num_var[$i] = count($group_variants[$i]);
        }
        $view = 'tests.show3';
        $array = array('view' => $view, 'arguments' => array("variants" => $group_variants, "type" => self::type_code, "id" => $this->id_question, "text_parts" => $text_parts, "num_var" => $num_var, "num_slot" => $num_slot, "count" => $count));
        return $array;
    }

    public function check($array) {
        $parse = explode("%", $this->variants);                                                                         //первый элемент - все варианты через <>, второй - стоимости через ;
        $variants = explode("<>", $parse[0]);
        $values = explode (";", $parse[1]);
        $parse_answer = $this->answer;
        $answer = explode(";", $parse_answer);
        $score = 0;
        $p = 0;                                                                                                         //счетчик правильных ответов
        for ($i=0; $i < count($variants); $i++){
            $step = $this->points * $values[$i];
            if ($array[$i] == $answer[$i]){
                $score +=$step;
                $p++;
            }
        }

        $right_percent = round($score/$this->points*100);
        if($p == count($variants))
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
               else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false) {
        $text_parts = explode("<>", $this->text);                                                                       //части текста между селектами
        $parse = explode("%", $this->variants);
        $variants = explode("<>", $parse[0]);
        $num_slot = count($variants);
        $text = '';

        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Заполните пропуски в тексте так, чтобы получилось верное определение или утверждение</td></tr></table>';

        if ($answered){                                                                                                 // пдф с ответами
            $answers = explode(";", $this->answer);
            for ($i = 1; $i <= $num_slot; $i++){
                $text .= $text_parts[$i-1].'('.$i.' '.$answers[$i-1].') ';                                              //формируем текст вопроса без пропущенных слов
            }
            $text .= $text_parts[$num_slot];
            $html .= '<p>'.$text.'</p>';
            $html .= '<table>';
            for ($i = 1; $i <= $num_slot; $i++){                                                                        // вывод верных ответов
                $html .= '<tr><td>'.$i.': '.$answers[$i-1].'</td></tr>';
            }
            $html .= '</table>';
        }
        else{                                                                                                           // без ответов
            for ($i = 1; $i <= $num_slot; $i++){
                $text .= $text_parts[$i-1].$i.'_______________';                                                        //формируем текст вопроса
            }
            $text .= $text_parts[$num_slot];
            $parse_group_variants = [];
            $group_variants = [];
            $num_var = [];
            for ($i=0; $i < count($variants); $i++){
                $parse_group_variants[$i] = explode(";",$variants[$i]);                                                 //варинаты каждого селекта
                $group_variants[$i] = $this->question->mixVariants($parse_group_variants[$i]);                       //перемешиваем варианты
                $num_var[$i] = count($group_variants[$i]);
            }

            $html .= '<p>'.$text.'</p>';
            $html .= '<table>';
            for ($i = 1; $i <= $num_slot; $i++){                                                                        // вывод вариантов
                $html .= '<tr><td>'.$i.': ';
                for ($j = 0; $j < $num_var[$i-1] - 1; $j++){
                    $html .= $group_variants[$i-1][$j].', ';
                }
                $html .= $group_variants[$i-1][$j].'.</td></tr>';
            }
            $html .= '</table>';
        }
        $html .= '<br>';
        $fpdf->WriteHTML($html);
    }
} 