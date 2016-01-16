<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 13:49
 */
namespace App\Qtypes;
use App\Http\Controllers\QuestionController;
use App\Mypdf;
use App\Question;
use Illuminate\Http\Request;
use Session;
class OneChoice extends QuestionType {
    const type_code = 1;
    function __construct($id_question){
        parent::__construct($id_question);
    }
    public function  create(){
    }
    public  function add(Request $request, $code){
        $variants = $request->input('variants')[0];
        for ($i=1; $i<count($request->input('variants')); $i++){
            $variants = $variants.';'.$request->input('variants')[$i];
        }
        $answer = $request->input('variants')[0];
        Question::insert(array('code' => $code, 'title' => $request->input('title'), 'variants' => $variants, 'answer' => $answer, 'points' => $request->input('points')));
    }
    public function show($count){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        $new_variants = QuestionController::mixVariants($variants);
        $view = 'tests.show1';
        $array = array('view' => $view, 'arguments' => array('text' => $this->text, "variants" => $new_variants, "type" => self::type_code, "id" => $this->id_question, "count" => $count));
        return $array;
    }
    public function check($array){
        if ($array[0] == $this->answer){
            $score = $this->points;
            $data = array('mark'=>'Верно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0]);
        }
        else {
            $score = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0]);
        }
        //echo $score.'<br>';
        if ($score != $this->points){
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $this->id_question, 'points' => $this->points, 'choice' => $array[0]);
        }
        //echo $score.'<br>';
        return $data;
    }

    public function pdf(Mypdf $fpdf, $count, $answered=false){
        $parse = $this->variants;
        $variants = explode(";", $parse);
        //$fpdf->SetFont('DejaVuSansMono','U',12);
        $html = '<p style="text-decoration: underline; font-size: 150%;">Вопрос '.$count.'</p>';
        $html .= '<p style="text-decoration: underline; font-size: 150%;">Выберите один вариант ответа</p>';

        $html .= '<br><table border="1" style="border-collapse: collapse;" width="100%">';
        if ($answered){                                                                                                 // пдф с ответами
            $answer = $this->answer;
            $new_variants = Session::get('saved_variants_order');
            foreach ($new_variants as $var){
                $html .= '<tr>';
                if ($answer == $var)
                    $html .= '<td width="5%">+</td><td width="80%">'.$var.'</td>';
                    //$fpdf->Row(array('   +',iconv('utf-8', 'windows-1251//TRANSLIT', $var)));
                else
                    //$fpdf->Row(array(iconv('utf-8', 'windows-1251//TRANSLIT', ''),iconv('utf-8', 'windows-1251', $var)));
                    $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
            Session::forget('saved_variants_order');
        }
        else {                                                                                                          // без ответов
            $new_variants = QuestionController::mixVariants($variants);
            Session::put('saved_variants_order', $new_variants);
            foreach ($new_variants as $var){
                $html .= '<tr>';
                $html .= '<td width="5%"></td><td width="80%">'.$var.'</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</table>';
        $fpdf->WriteHTML($html);
    }

} 