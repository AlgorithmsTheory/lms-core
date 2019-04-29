<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 16:15
 */
namespace App\Http\Controllers;

use App\Testing\Qtypes\FromCleene;
use App\Testing\Qtypes\QuestionType;
use App\Testing\Qtypes\QuestionTypeFactory;
use App\Testing\Qtypes\Theorem;
use App\Testing\Qtypes\TheoremLike;
use App\Testing\Section;
use App\Testing\Test;
use App\Testing\TestTask;
use App\Testing\Type;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Testing\Question;
use App\Testing\Theme;
use App\Testing\Qtypes\OneChoice;
use App\Testing\Qtypes\MultiChoice;
use App\Testing\Qtypes\FillGaps;
use App\Testing\Qtypes\AccordanceTable;
use App\Testing\Qtypes\YesNo;
use App\Testing\Qtypes\Definition;
use App\Testing\Qtypes\JustAnswer;
use App\Testing\Qtypes\ThreePoints;
use App\Testing\Qtypes\Ram;
use App\Testing\TestGeneration\UsualTestGenerator;
use View;

class QuestionController extends Controller {
    private $question;
    function __construct(Question $question){
        $this->question=$question;
    }

    public function index(){
        return redirect()->route('questions_list');
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
            $type_code = Type::whereType_name($type)->select('type_code')->first()->type_code;
            $sections = Section::all();
            return (String) view(QuestionType::CREATE_VIEW_PREFIX . $type_code, compact('sections'));
        }
    }

    /** Обработка формы добавления вопроса */
    public function add(Request $request){
        $type = $request->input('type');
        $query = Question::max('id_question');                                                                          //пример использования агрегатных функций!!!
        $id = $query+1;
        $question = QuestionTypeFactory::getQuestionTypeByTypeName($id, $type);
        $question->add($request);
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
                                ->where('section_code', '<', 20)
                                ->where('theme_code', '>', 0)
                                ->where('theme_code', '<', 30);
        $questions = $questions->paginate(10);
        $widgets = [];
        foreach ($questions as $question){
            $data = $this->question->show($question['id_question'], '', false);
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
                        ->where('section_code', '<', 20)
                        ->where('theme_code', '>', 0)
                        ->where('theme_code', '<', 30);
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
            $data = $this->question->show($question['id_question'], '', false);
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

    public function profile($id_question) {
        $question = Question::whereId_question($id_question)->first();
        $data = $this->question->show($question['id_question'], '', false);
        $widget =  View::make($data['view'], $data['arguments']);
        $widgetListView = View::make('questions.teacher.profile', compact('question'))->with('widget', $widget);
        return new Response($widgetListView);
    }
    
    /** Фомирование страницы редактирования */
    public function edit($id_question){
        $question = Question::whereId_question($id_question)->select('type_code', 'section_code')->first();
        $type_code = $question->type_code;
        $type_name = Type::whereType_code($type_code)->select('type_name')->first()->type_name;
        $themes = Theme::whereSection_code($question->section_code)->get();
        $sections = Section::all();

        $question = QuestionTypeFactory::getQuestionTypeByTypeName($id_question, $type_name);
        $data = $question->edit();
        $view_name = QuestionType::EDIT_VIEW_PREFIX . $question->type_code;
        return view($view_name, compact('data', 'sections', 'themes'));
    }

    public function update(Request $request) {
        $id_question = $request->input('id-question');
        $type_code = Question::whereId_question($id_question)->select('type_code')->first()->type_code;
        $type_name = Type::whereType_code($type_code)->select('type_name')->first()->type_name;

        $question = QuestionTypeFactory::getQuestionTypeByTypeName($id_question, $type_name);
        $question->update($request);
        return redirect()->route('questions_list');
    }

    /** Удаление вопроса */
    public function delete(Request $request){
        if ($request->ajax()){
            TestTask::whereId_question($request->input('id_question'))->delete();
            Question::whereId_question($request->input('id_question'))->delete();
            return;
        }
    }
}