<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 30.05.15
 * Time: 15:11
 */
namespace App\Testing\Qtypes;
use App\Mypdf;
use App\Testing\Question;
use App\Testing\Section;
use App\Testing\Theme;
use App\Testing\Type;
use Illuminate\Http\Request;
use Input;

abstract class QuestionType {
    const PUBLIC_DIR = 'public/';
    const IMAGES_IN_TITLE_DIR = 'img/questions/title/';
    const CREATE_VIEW_PREFIX = 'questions.teacher.create';
    const EDIT_VIEW_PREFIX = 'questions.teacher.edit';
    const PAPER_SAVING_HEIGHT_ANSWER = '50px';

    public $id_question;
    public $text;
    public $eng_text;
    public $variants;
    public $eng_variants;
    public $answer;
    public $eng_answer;
    public $points;
    public $control;
    public $theme_code;
    public $section_code;
    public $type_code;

    function __construct($id_question){
        $question = Question::whereId_question($id_question)->first();
        if ($question != null) {
            $this->text = $question->title;
            $this->eng_text = $question->title_eng;
            $this->variants = $question->variants;
            $this->eng_variants = $question->variants_eng;
            $this->answer = $question->answer;
            $this->eng_answer = $question->answer_eng;
            $this->points = $question->points;
            $this->control = $question->control;
            $this->section_code = $question->section_code;
            $this->theme_code = $question->theme_code;
            $this->type_code = $question->type_code;
        }
        $this->id_question = $id_question;
    }

    public function getAnswer() {
        return $this->answer;
    }

    protected function getOptions(Request $request){
        $section = Section::whereSection_name($request->input('section'))->select('section_code')->first()->section_code;
        $theme = Theme::whereTheme_name($request->input('theme'))->select('theme_code')->first()->theme_code;
        $type = Type::whereType_name($request->input('type'))->select('type_code')->first()->type_code;
        if ($request->input('control'))
            $control = 1;
        else
            $control = 0;
        $points = $request->input('points');
        $difficulty = $request->input('difficulty');
        $discriminant = $request->input('discriminant');
        $guess = $request->input('guess');
        $pass_time = $request->input('pass-time');

        if ($request->input('translated')) {
            $translated = 1;
        }
        else {
            $translated = 0;
        }

        return ['section' => $section, 'theme' => $theme, 'type' => $type,
                'control' => $control, 'points' => $points, 'difficulty' => $difficulty,
                'discriminant' => $discriminant, 'guess' => $guess,
                'pass_time' => $pass_time, 'translated' => $translated];
    }

    protected function getTitleWithImage(Request $request) {
        $parse_text = preg_split('/\[\[|\]\]/', $request->input('title'));                                              //части текста вопроса без [[ ]]
        $eng_parse_text = preg_split('/\[\[|\]\]/', $request->input('eng-title'));                                      //части текста вопроса на английском без [[ ]]

        $input_images = Input::file();
        for ($i = 1; $i < count($input_images['text-images']) + 1; $i++){
            $extension = $input_images['text-images'][$i-1]->getClientOriginalExtension();                              //получаем расширение файла
            $fileName = time() + rand(11111, 99999) . '.' . $extension;                                                          //случайное имя картинки
            $input_images['text-images'][$i-1]->move($this::IMAGES_IN_TITLE_DIR, $fileName);                                      //перемещаем картинку
            $parse_text[2*$i-1] = '::'.$this::IMAGES_IN_TITLE_DIR.$fileName.'::';                                                 //заменить каждуый старый файл на новый
            $eng_parse_text[2*$i-1] = '::'.$this::IMAGES_IN_TITLE_DIR.$fileName.'::';
        }
        $title = '';
        foreach ($parse_text as $part){                                                                                 //собираем все в строку
            $title .= $part;
        }
        $eng_title = '';
        foreach ($eng_parse_text as $eng_part){                                                                         //собираем все в строку для английского текста
            $eng_title .= $eng_part;
        }

        return ['ru_title' => $title, 'eng_title' => $eng_title];
    }

    /**
     * Add new question to questions table in DB
     */
    abstract function add(Request $request);

    /**
     * Generate page for editing question
     */
    abstract function edit();

    /**
     * Update question in DB
     */
    abstract function update(Request $request);

    /**
     * Provide the name of the view and necessary parameters for displaying question in test
     */
    abstract function show($count);

    /**
     * @param Mypdf $fpdf - Library for PDF
     * @param int $count - Ordered number of the question
     * @param bool $answered - true if needed to generate PDF with correct answers (for teachers), false - for students
     */
    abstract function pdf(Mypdf $fpdf, $count, $answered=false, $paper_savings=false);
}