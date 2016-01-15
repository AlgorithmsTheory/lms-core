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

class MultiChoice extends QuestionType {
    const type_code = 2;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){

    }

    public function add(Request $request, $code){
        $variants = $request->input('variants')[0];
        $answers = '';
        $flag = false;
        $j = 0;
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        while ($flag != true && $j<count($request->input('answers'))){
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
        Question::insert(array('code' => $code, 'title' => $request->input('title'), 'variants' => $variants, 'answer' => $answers, 'points' => $request->input('points')));
    }

    public function show($count){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = QuestionController::mixVariants($variants);
        $view = 'tests.show2';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }

    public function check($array){
        $choices = $array;
        $answers = explode(';', $this->answer);
        $score = 0;
        $step = $this->points/count($answers);
        for ($i=0; $i<count($answers); $i++ ){        //сравниваем каждый правильный ответ
            for ($j=0; $j<count($choices); $j++){      // с каждым выбранным
                if ($answers[$i] == $choices[$j]){
                    $buf = $choices[$j];
                    $choices[$j] = $choices[count($choices)-1];     //меняем местами правильный ответ с последним для удаления
                    $choices[count($choices)-1] =  $buf;
                    array_pop($choices);                         //удаляем правильный проверенный вариант из массива выбранных ответов
                    $score += $step;
                    break;
                }
            }
        }
        if (!(empty($choices))){                    //если выбраны лишние варианты
            for ($i=0; $i<count($choices); $i++){
                $score -= $step;
            }
        }
        if ($score > $this->points){                    //если при округлении получилось больше максимального числа баллов
            $score = $this->points;
        }
        if ($score < 0){                          //если ушел в минус
            $score = 0;
        }

        if ($score == $this->points){
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array);
        }
        else $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array);
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $fpdf->SetFont('TimesNewRomanPSMT','U',12);
        $fpdf->Cell(20,10,iconv('utf-8', 'windows-1251//TRANSLIT', 'Вопрос '.$count.'.'),0,0);
        $fpdf->Cell(7,10,iconv('utf-8', 'windows-1251//TRANSLIT', 'Выберите один или несколько вариантов ответа'),0,1);

        $fpdf->SetFont('TimesNewRomanPSMT','',12);
        $fpdf->MultiCell(0,5,iconv('utf-8', 'windows-1251//TRANSLIT', $this->text),0,1);
        $fpdf->Ln(2);
        $fpdf->SetWidths(array('10','170'));
        if ($answered){                                                                                                 // пдф с ответами
            $answers = explode(";", $this->answer);
            $new_variants = Session::get('saved_variants_order');
            for ($i = 0; $i < count($new_variants); $i++){                                                              // идем по всем вариантам
                for ($j = 0; $j < count($answers); $j++){                                                               // идем по всем ответам
                    if ($answers[$j] == $new_variants[$i]){                                                             // если вариант совпал с ответом
                        $fpdf->Row(array('   +',iconv('utf-8', 'windows-1251//TRANSLIT', $new_variants[$i])));
                        $fpdf->Ln(0);
                        break;
                    }
                    else{
                        if ($j == count($answers) - 1){                                                                 // проверяем, не все ли ответы просмотрены
                            $fpdf->Row(array(iconv('utf-8', 'windows-1251//TRANSLIT', ''),iconv('utf-8', 'windows-1251//TRANSLIT', $new_variants[$i]))); // если так, то выводим строку без "+"
                            $fpdf->Ln(0);
                        }
                        else continue;                                                                                  // иначе смотрим следующий ответ
                    }
                }
            }
            Session::forget('saved_variants_order');
        }
        else {                                                                                                          // без ответов
            $new_variants = QuestionController::mixVariants($variants);
            Session::put('saved_variants_order', $new_variants);
            foreach ($new_variants as $var){
                $fpdf->Row(array(iconv('utf-8', 'windows-1251', ''),iconv('utf-8', 'windows-1251', $var)));
                $fpdf->Ln(0);
            }
        }
    }
} 