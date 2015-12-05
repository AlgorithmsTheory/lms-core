<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 15:11
 */
namespace App\Qtypes;
use App\Mypdf;
use App\Question;
use Illuminate\Http\Request;
abstract class QuestionType {
    public  $id_question;
    public  $text;
    public  $variants;
    public  $answer;
    public  $points;
    function __construct($id_question){
        if ($id_question != Question::max('id_question')+1){    //проверка не является ли вопрос новым
            $query = Question::whereId_question($id_question)->first();
            $this->text = $query->title;
            $this->variants = $query->variants;
            $this->answer = $query->answer;
            $this->points = $query->points;
        }
        $this->id_question = $id_question;
    }
    abstract function create();
    abstract function add(Request $request, $code);
    abstract function show($count);
    abstract function check($array);
    abstract function pdf(Mypdf $fpdf, $count);
}