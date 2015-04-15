<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 16:15
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use PDOStatement;
use Session;


class QuestionController extends Controller{
    private $question;

    function __construct(Question $question){
        $this->question=$question;
    }

    private function setCode(Codificator $codificator, Request $request){  //Установить код вопроса
        //получаем необходимые данные из формы
        $section = $request->input('section');
        $theme = $request->input('theme');
        $type = $request->input('type');

        //с помощью кодификаторов составляем трехразрядный код вопроса
        $query1 = $codificator->whereValue($section)->select('code')->first();
        $section_code = $query1->code;
        $query2 = $codificator->whereValue($theme)->select('code')->first();
        $theme_code = $query2->code;
        $query3 = $codificator->whereCodificator_type('Тип')->whereValue($type)->select('code')->first();
        $type_code = $query3->code;
        $code = $section_code.'.'.$theme_code.'.'.$type_code;

        return $code;
    }

    public function index(){
        //Дефолтная страница при разграничении прав
        /*if (Session::has('username')){
             return view('questions.student.index');
        }
        if (Session::has('teachername')){
            return view('questions.teacher.index');
        }*/
        $questions = $this->question->get();
        //dd($questions);
        return view('questions.teacher.index', compact('questions'));
    }

    public function create(){             //переход на страницу формы добавления
        return view('questions.teacher.create');
}

    public function add(Question $question, Codificator $codificator, Request $request){  //обработка формы добавления
       $code = $this->setCode($codificator, $request);

        //добавляем вопрос в таблицу
        $question->insert(array('code' => $code, 'title' => $request->input('title'), 'variants' => $request->input('variants'), 'answer' => $request->input('answer'), 'points' => $request->input('points')));
        return redirect()->route('question_index');
    }

    public function show($id, Question $question){  //показать вопрос
        //$typedef = $question->table('questions')->whereId_question($id)->select('title','variants')->first();

        $query = $question->whereId_question($id)->select('title','variants','answer')->first();
        $text = $query->title;
        $answer = $query->answer;
        $parse = $query->variants;
        $variants = explode(";", $parse);
        //$field = $question->whereId_question($id)->select('title')->first();
        return view('questions.student.show', compact('text','variants','answer'));
    }

    public function check(Request $request){   //обработать ответ на вопрос
        if ($request->input('choice') == $request->input('answer')){
            echo 'Верно';
        }
        else echo 'Неверно';
        }
} 