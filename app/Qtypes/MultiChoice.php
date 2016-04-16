<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 15:49
 */

namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Question;
use Illuminate\Http\Request;
use Session;
use Input;

class MultiChoice extends QuestionType {
    const type_code = 2;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){

    }

    public function add(Request $request, $code){
        $parse_text = preg_split('/\[\[|\]\]/', $request->input('title'));
        $destinationPath = 'img/questions/title/';
        $input_images = Input::file();
        for ($i = 1; $i < count($input_images['text-images']); $i++){
            $extension = $input_images['text-images'][$i-1]->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $input_images['text-images'][$i-1]->move($destinationPath, $fileName);
            $parse_text[2*$i-1] = '::'.$destinationPath.$fileName.'::';
        }
        $title = '';
        foreach ($parse_text as $part){
            $title .= $part;
        }

        $variants = $request->input('variants')[0];                                                                     //формирование вариантов
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }

        $answers = '';
        $flag = false;
        $j = 0;
        while ($flag != true && $j<count($request->input('answers'))){                                                  //формирование ответов
            if (isset($request->input('answers')[$j])){
                $answers = $request->input('variants')[$request->input('answers')[$j]-1];
                $j++;
                break;
            }
            $j++;
        }
        for ($i=$j; $i<count($request->input('answers')); $i++){
            if (isset($request->input('answers')[$i])){
                $answers = $answers.';'.$request->input('variants')[$request->input('answers')[$i]-1];
            }
        }
        Question::insert(array('code' => $code, 'title' => $title, 'variants' => $variants, 'answer' => $answers, 'points' => $request->input('points')));
    }

    public function show($count){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = $this->question->mixVariants($variants);
        $view = 'tests.show2';
        $array = array('view' => $view, 'arguments' => array('text' => explode('::',$this->text), "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array){
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
        if ($score == $this->points){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array, 'right_percent' => $right_percent);
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $html = '<table><tr><td style="text-decoration: underline; font-size: 130%;">Вопрос '.$count;
        $html .= '  Выберите один или несколько вариантов ответа</td></tr>';
        $html .= '<tr><td>'.$this->text.'</td></tr></table>';

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
                $var = 'A < B';
                $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</table><br>';
        $fpdf->WriteHTML($html);
    }
} 