<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 16:15
 */
namespace App\Http\Controllers;
use App\Lecture;
use App\Qtypes\Theorem;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use App\Theme;
use App\Qtypes\OneChoice;
use App\Qtypes\MultiChoice;
use App\Qtypes\FillGaps;
use App\Qtypes\AccordanceTable;
use App\Qtypes\YesNo;
use App\Qtypes\Definition;
use App\Qtypes\JustAnswer;

class QuestionController extends Controller{
    private $question;
    function __construct(Question $question){
        $this->question=$question;
    }

    /** главная страница модуля тестирования */
    public function index(){
        $username =  null;
        Session::forget('test');
        if (Auth::check()){
            $username = Auth::user()['first_name'];
        }
        $image = 'img/library/Pic/2.jpeg';
        return view('questions.teacher.index', compact('username', 'image'));
    }

    /** переход на страницу формы добавления */
    public function create(){
        $codificator = new Codificator();
        $types = [];
        $query = $codificator->whereCodificator_type('Тип')->select('value')->get();
        foreach ($query as $type){
            array_push($types,$type->value);
        }
        return view('questions.teacher.create', compact('types'));
    }

    /** AJAX-метод: подгружает интерфейс создания нового вопроса в зависимости от выбранного типа вопроса */
    public function getType(Request $request){
        if ($request->ajax()){
            $type = $request->input('choice');
            $query = $this->question->max('id_question');
            $id = $query + 1;
            switch($type){
                case 'Выбор одного из списка':                      //Стас
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create1', compact('sections'));
                    break;
                case 'Выбор нескольких из списка':
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create2', compact('sections'));
                    break;
                case 'Текстовый вопрос':                            //Стас
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create3', compact('sections'));
                    break;
                case 'Таблица соответствий':                        //Миша
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create5', compact('sections'));
                    break;
                case 'Да/Нет':                                      //Миша
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create4', compact('sections'));
                    break;
                case 'Определение':
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create7', compact('sections'));
                    break;
                case 'Просто ответ':
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create8', compact('sections'));
                    break;
                case 'Теорема':
                    $codificator = new Codificator();
                    $sections = [];
                    $query = $codificator->whereCodificator_type('Раздел')->select('value')->get();
                    foreach ($query as $section){
                        array_push($sections,$section->value);
                    }
                    return (String) view('questions.teacher.create6', compact('sections'));
                    break;
            }
        }
    }

    /** Обработка формы добавления вопроса */
    public function add(Request $request){
        $code = $this->question->setCode($request);
        $type = $request->input('type');
        $query = Question::max('id_question');                                                                          //пример использования агрегатных функций!!!
        $id = $query+1;
        switch($type){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id);
                $one_choice->add($request, $code);
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id);
                $multi_choice->add($request, $code);
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id);
                $fill_gaps->add($request, $code);
                break;
            case 'Таблица соответствий':
                $fill_gaps = new AccordanceTable($id);
                $fill_gaps->add($request, $code);
                break;
            case 'Да/Нет':
                $fill_gaps = new YesNo($id);
                $fill_gaps->add($request, $code);
                break;
            case 'Определение':
                $definition = new Definition($id);
                $definition->add($request, $code);
                break;
            case 'Просто ответ':
                $just = new JustAnswer($id);
                $just->add($request, $code);
                break;
            case 'Теорема':
                $theorem = new Theorem($id);
                $theorem->add($request, $code);
                break;
        }
        return redirect()->route('question_create');
    }

    /** AJAX-метод: Формирует список тем, соответствующих выбранному разделу */
    public function getTheme(Request $request){
        if ($request->ajax()) {
            $themes = new Theme();
            $themes_list = [];
            $query = $themes->whereSection($request->input('choice'))->select('theme')->get();
            foreach ($query as $str){
                array_push($themes_list,$str->theme);
            }
            return (String) view('questions.student.getTheme', compact('themes_list'));
        }
    }
}