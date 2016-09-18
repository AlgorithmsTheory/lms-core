<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 16:15
 */
namespace App\Http\Controllers;
use App\Protocols\TestProtocol;
use App\Testing\Lecture;
use App\Qtypes\Theorem;
use App\Testing\Section;
use App\Testing\Type;
use Auth;
use Illuminate\Http\Response;
use Session;
use Illuminate\Http\Request;
use App\Testing\Question;
use App\Testing\Theme;
use App\Qtypes\OneChoice;
use App\Qtypes\MultiChoice;
use App\Qtypes\FillGaps;
use App\Qtypes\AccordanceTable;
use App\Qtypes\YesNo;
use App\Qtypes\Definition;
use App\Qtypes\JustAnswer;
use View;

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
        $protocol = new TestProtocol(161, 83, '');
        $protocol->create();
        $image = 'img/library/Pic/2.jpeg';
        return view('questions.teacher.index', compact('username', 'image'));
    }

    /** переход на страницу формы добавления */
    public function create(){
        $types = Type::all();
        return view('questions.teacher.create', compact('types'));
    }

    /** AJAX-метод: подгружает интерфейс создания нового вопроса в зависимости от выбранного типа вопроса */
    public function getType(Request $request){
        if ($request->ajax()){
            $type = $request->input('choice');
            $sections = Section::all();
            switch($type){
                case 'Выбор одного из списка':                      //Стас
                    return (String) view('questions.teacher.create1', compact('sections'));
                    break;
                case 'Выбор нескольких из списка':
                    return (String) view('questions.teacher.create2', compact('sections'));
                    break;
                case 'Текстовый вопрос':                            //Стас
                    return (String) view('questions.teacher.create3', compact('sections'));
                    break;
                case 'Таблица соответствий':                        //Миша
                    return (String) view('questions.teacher.create5', compact('sections'));
                    break;
                case 'Да/Нет':                                      //Миша
                    return (String) view('questions.teacher.create4', compact('sections'));
                    break;
                case 'Определение':
                    return (String) view('questions.teacher.create7', compact('sections'));
                    break;
                case 'Просто ответ':
                    return (String) view('questions.teacher.create8', compact('sections'));
                    break;
                case 'Теорема':
                    return (String) view('questions.teacher.create6', compact('sections'));
                    break;
            }
        }
    }

    /** Обработка формы добавления вопроса */
    public function add(Request $request){
        //$code = $this->question->setCode($request);
        $type = $request->input('type');
        $query = Question::max('id_question');                                                                          //пример использования агрегатных функций!!!
        $id = $query+1;
        switch($type){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id);
                $one_choice->add($request);
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id);
                $multi_choice->add($request);
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id);
                $fill_gaps->add($request);
                break;
            case 'Таблица соответствий':
                $fill_gaps = new AccordanceTable($id);
                $fill_gaps->add($request);
                break;
            case 'Да/Нет':
                $fill_gaps = new YesNo($id);
                $fill_gaps->add($request);
                break;
            case 'Определение':
                $definition = new Definition($id);
                $definition->add($request);
                break;
            case 'Просто ответ':
                $just = new JustAnswer($id);
                $just->add($request);
                break;
            case 'Теорема':
                $theorem = new Theorem($id);
                $theorem->add($request);
                break;
        }
        return redirect()->route('question_create');
    }

    /** AJAX-метод: Формирует список тем, соответствующих выбранному разделу */
    public function getTheme(Request $request){
        if ($request->ajax()) {
            $section = $request->input('choice');
            $section_code = Section::whereSection_name($section)->select('section_code')->first()->section_code;
            $themes_list = Theme::whereSection_code($section_code)->select('theme_name')->get();
            return (String) view('questions.student.getTheme', compact('themes_list'));
        }
    }

    /** Список всех доступных вопросов */
    public function editList(){
        $questions = Question::where('section_code', '>', 0)
                                ->where('section_code', '<', 10)
                                ->where('theme_code', '>', 0)
                                ->where('theme_code', '<', 23);
        $questions = $questions->paginate(10);
        $widgets = [];
        foreach ($questions as $question){
            $data = $this->question->show($question['id_question'], '');
            $widgets[] =  View::make($data['view'], $data['arguments']);
            $question['section'] = Section::whereSection_code($question['section_code'])->select('section_name')
                                    ->first()->section_name;
            $question['theme'] = Theme::whereTheme_code($question['theme_code'])->select('theme_name')
                                    ->first()->theme_name;
            $question['type'] = Type::whereType_code($question['type_code'])->select('type_name')
                                    ->first()->type_name;
        }
        $sections = Section::where('section_code', '>', 0)->select('section_name')->get();
        $themes = Theme::where('theme_code', '>', 0)->select('theme_name')->get();
        $types = Type::where('type_code', '>', 0)->select('type_name')->get();
        $widgetListView = View::make('questions.teacher.question_list', compact('questions', 'sections', 'themes', 'types'))->with('widgets', $widgets);
        $response = new Response($widgetListView);
        return $response;
    }

    /** Поиск вопроса по тексту, разделу, теме, типу */ 
    public function find(Request $request){
        $questions = new Question();
        $questions = $questions->where('section_code', '>', 0)
                        ->where('section_code', '<', 10)
                        ->where('theme_code', '>', 0)
                        ->where('theme_code', '<', 23);
        if ($request->input('section') != 'Все'){
            $section_code = Section::whereSection_name($request->input('section'))->select('section_code')->first()->section_code;
            $questions = $questions->whereSection_code($section_code);
            if ($request->input('theme') != '$nbsp'){
                $theme_code = Theme::whereTheme_name($request->input('theme'))->select('theme_code')->first()->theme_code;
                $questions = $questions->whereTheme_code($theme_code);
            }
        }
        if ($request->input('type') != 'Все'){
            $type_code = Type::whereType_name($request->input('type'))->select('type_code')->first()->type_code;
            $questions = $questions->whereType_code($type_code);
        }
        if ($request->input('title') != ""){
            $questions = $questions->whereRaw('(`title` LIKE "%'.$request->input("title").'%" 
                                              or `variants` LIKE "%'.$request->input("title").'%"
                                              or `answer` LIKE "%'.$request->input("title").'%")');
        }
        $questions = $questions->paginate(10);
        
        $widgets = [];
        foreach ($questions as $question){
            $data = $this->question->show($question['id_question'], '');
            $widgets[] =  View::make($data['view'], $data['arguments']);
            $question['section'] = Section::whereSection_code($question['section_code'])->select('section_name')
                                    ->first()->section_name;
            $question['theme'] = Theme::whereTheme_code($question['theme_code'])->select('theme_name')
                                    ->first()->theme_name;
            $question['type'] = Type::whereType_code($question['type_code'])->select('type_name')
                                    ->first()->type_name;
        }
        $sections = Section::where('section_code', '>', 0)->select('section_name')->get();
        $themes = Theme::where('theme_code', '>', 0)->select('theme_name')->get();
        $types = Type::where('type_code', '>', 0)->select('type_name')->get();
        $widgetListView = View::make('questions.teacher.question_list', compact('questions', 'sections', 'themes', 'types'))->with('widgets', $widgets);
        $response = new Response($widgetListView);
        return $response;
    }
    
    /** Фомирование страницы редактирования */
    public function edit($id_question){
        $question = Question::whereId_question($id_question)->select('type_code', 'section_code')->first();
        $type_code = $question->type_code;
        $type_name = Type::whereType_code($type_code)->select('type_name')->first()->type_name;
        $themes = Theme::whereSection_code($question->section_code)->get();
        $sections = Section::all();
        switch($type_name){
                case 'Выбор одного из списка':
                $one_choice = new OneChoice($id_question);
                $data = $one_choice->edit();
                return view('questions.teacher.edit1', compact('data', 'sections', 'themes'));
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id_question);
                $data = $multi_choice->edit();
                return view('questions.teacher.edit2', compact('data', 'sections', 'themes'));
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id_question);
                $fill_gaps->edit();
                break;
            case 'Таблица соответствий':
                $fill_gaps = new AccordanceTable($id_question);
                $fill_gaps->edit();
                break;
            case 'Да/Нет':
                $fill_gaps = new YesNo($id_question);
                $fill_gaps->edit();
                break;
            case 'Определение':
                $definition = new Definition($id_question);
                $definition->edit();
                break;
            case 'Просто ответ':
                $just = new JustAnswer($id_question);
                $just->edit();
                break;
            case 'Теорема':
                $theorem = new Theorem($id_question);
                $theorem->edit();
                break;
            }
    }

    public function update(Request $request) {
        $id_question = $request->input('id-question');
        $type_code = Question::whereId_question($id_question)->select('type_code')->first()->type_code;
        $type_name = Type::whereType_code($type_code)->select('type_name')->first()->type_name;
        switch($type_name){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id_question);
                $one_choice->update($request);
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id_question);
                $multi_choice->update($request);
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id_question);
                $fill_gaps->edit();
                break;
            case 'Таблица соответствий':
                $fill_gaps = new AccordanceTable($id_question);
                $fill_gaps->edit();
                break;
            case 'Да/Нет':
                $fill_gaps = new YesNo($id_question);
                $fill_gaps->edit();
                break;
            case 'Определение':
                $definition = new Definition($id_question);
                $definition->edit();
                break;
            case 'Просто ответ':
                $just = new JustAnswer($id_question);
                $just->edit();
                break;
            case 'Теорема':
                $theorem = new Theorem($id_question);
                $theorem->edit();
                break;
        }
        return redirect()->route('questions_list');
    }

    /** Удаление вопроса */
    public function delete(Request $request){
        if ($request->ajax()){
            Question::whereId_question($request->input('id_question'))->delete();
            return;
        }
    }
}