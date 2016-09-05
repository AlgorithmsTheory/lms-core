<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 15:11
 */
namespace App\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Section;
use App\Testing\Theme;
use App\Testing\Type;
use Illuminate\Http\Request;
abstract class QuestionType {
    const PUBLIC_DIR = 'public/';
    public $question;
    public $id_question;
    public $text;
    public $variants;
    public $answer;
    public $points;
    public $control;
    public $theme_code;
    public $section_code;
    public $type_code;
    function __construct($id_question){
        if ($id_question != Question::max('id_question')+1){                                                            //проверка не является ли вопрос новым
            $this->question = new Question();
            $query = Question::whereId_question($id_question)->first();
            $this->text = $query->title;
            $this->variants = $query->variants;
            $this->answer = $query->answer;
            $this->points = $query->points;
            $this->control = $query->control;
            $this->section_code = $query->section_code;
            $this->theme_code = $query->theme_code;
            $this->type_code = $query->type_code;
        }
        $this->id_question = $id_question;
    }

    public function getOptions(Request $request){
        $section = Section::whereSection_name($request->input('section'))->select('section_code')->first()->section_code;
        $theme = Theme::whereTheme_name($request->input('theme'))->select('theme_code')->first()->theme_code;
        $type = Type::whereType_name($request->input('type'))->select('type_code')->first()->type_code;
        if ($request->input('control'))
            $control = 1;
        else
            $control = 0;
        return ['section' => $section, 'theme' => $theme, 'type' => $type, 'control' => $control];
    }
    /*public function toBladeImage($string){
        //return preg_replace("/#img1#/", "{!! HTML::image('img/symbols/all.png') !!}", $string);
        return $string;
    }*/

    abstract function add(Request $request);
    abstract function edit();
    abstract function show($count);
    abstract function check($array);
    abstract function pdf(Mypdf $fpdf, $count, $answered=false);
}