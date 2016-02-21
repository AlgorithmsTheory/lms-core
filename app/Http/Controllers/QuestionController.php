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

    /** По входным данным формы section, theme, type определяет код вопроса a.b.c */
    private function setCode(Request $request){  //Установить код вопроса
        $codificator = new Codificator();
        //получаем необходимые данные из формы
        $section = $request->input('section');
        $theme = $request->input('theme');
        $type = $request->input('type');
        //с помощью кодификаторов составляем трехразрядный код вопроса
        $query1 = $codificator->whereCodificator_type('Раздел')->whereValue($section)->select('code')->first();
        $section_code = $query1->code;
        $query2 = $codificator->whereCodificator_type('Тема')->whereValue($theme)->select('code')->first();
        $theme_code = $query2->code;
        $query3 = $codificator->whereCodificator_type('Тип')->whereValue($type)->select('code')->first();
        $type_code = $query3->code;
        $code = $section_code.'.'.$theme_code.'.'.$type_code;
        return $code;
    }

    /** по id вопроса формирует массив из кодов и названий */
    public function getCode($id){                                                                                       //декодирование вопроса в асс. массив
        $codificator = new Codificator();
        $question = $this->question;
        $query = $question->whereId_question($id)->select('code')->first();
        $code = $query->code;          //получили код вопроса
        $array = explode('.',$code);
        //print_r($array);
        $query1 = $codificator->whereCodificator_type('Раздел')->whereCode($array[0])->select('value')->first();
        $section = $query1->value;
        $query2 = $codificator->whereCodificator_type('Тема')->whereCode($array[1])->join('themes', 'themes.theme', '=', 'codificators.value')->where('themes.section', '=', $section)->select('value')->first();
        $theme = $query2->value;
        $query3 = $codificator->whereCodificator_type('Тип')->whereCode($array[2])->select('value')->first();
        $type = $query3->value;
        $decode = array('section' => $section, 'theme' => $theme, 'type' => $type,
            'section_code' => $array[0], 'theme_code' => $array[1], 'type_code' => $array[2]);
        return $decode;
    }

    /** Определяет одиночный вопрос (true) или может использоваться только в группе с такими же (false) */
    public function getSingle($id){
        $type = $this->getCode($id)['type'];
        if ($type == 'Да/Нет' || $type == 'Определение' || $type == 'Просто ответ'){
            return false;
        }
        else return true;
    }

    /** из массива выбирает случайный элемент и ставит его в конец массива, меняя местами с последним элементом */
    public static function randomArray($array){
        $index = rand(0,count($array)-1);                                                                               //выбираем случайный вопрос
        $chosen = $array[$index];
        $array[$index]=$array[count($array)-1];
        $array[count($array)-1] = $chosen;
        return $array;                                                                                                  //получаем тот же массив, где выбранный элемент стоит на последнем месте для удаления
    }

    /** перемешивает элементы массива */
    public static function mixVariants($variants){
        $num_var = count($variants);
        $new_variants = [];
        for ($i=0; $i<$num_var; $i++){                                                                                  //варианты в случайном порядке
            $variants = QuestionController::randomArray($variants);
            $chosen = array_pop($variants);
            $new_variants[$i] = $chosen;
        }
        return $new_variants;
    }

    /** Из выбранного массива вопросов теста выбирает один */
    public function chooseQuestion(&$array){
        if (empty($array)){                                                                                             //если вопросы кончились, завершаем тест
            return -1;
        }
        else{
            $array = $this->randomArray($array);
            $choisen = $array[count($array)-1];
            array_pop($array);                                                                                          //удаляем его из списка
            return $choisen;
        }
    }

    /** Показывает вопрос согласно типу */
    public function show($id_question, $count){
        $decode = $this->getCode($id_question);
        $type = $decode['type'];
        switch($type){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id_question);
                $array = $one_choice->show($count);
                return $array;
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id_question);
                $array = $multi_choice->show($count);
                return $array;
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id_question);
                $array = $fill_gaps->show($count);
                return $array;
                break;
            case 'Таблица соответствий':
                $accordance_table = new AccordanceTable($id_question);
                $array = $accordance_table->show($count);
                return $array;
                break;
            case 'Да/Нет':
                $yes_no = new YesNo($id_question);
                $array = $yes_no->show($count);
                return $array;
                break;
            case 'Определение':
                $def = new Definition($id_question);
                $array = $def->show($count);
                return $array;
                break;
            case 'Просто ответ':
                $just = new JustAnswer($id_question);
                $array = $just->show($count);
                return $array;
                break;
            case 'Теорема':
                $theorem = new Theorem($id_question);
                $array = $theorem->show($count);
                return $array;
                break;
        }
    }

    /** Проверяет вопрос согласно типу и на выходе дает баллы за него */
    public function check($array){
        $question = $this->question;
        $id = $array[0];
        $query = $question->whereId_question($id)->select('answer','points')->first();
        $points = $query->points;
        $type = $this->getCode($id)['type'];
        if (count($array)==1){                                                                                          //если не был отмечен ни один вариант
            $choice = [];
            $score = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $id, 'points' => $points, 'choice' => $choice, 'right_percent' => 0);
            return $data;
        }
        for ($i=0; $i < count($array)-1; $i++){                                                                         //передвигаем массив, чтобы первый элемент оказался последним
            $array[$i] = $array[$i+1];
        }
        array_pop($array);                                                                                              //убираем из входного массива id вопроса, чтобы остались лишь выбранные варианты ответа
        switch($type){
            case 'Выбор одного из списка':
                $one_choice = new OneChoice($id);
                $data = $one_choice->check($array);
                return $data;
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id);
                $data = $multi_choice->check($array);
                return $data;
                break;
            case 'Текстовый вопрос':
                $fill_gaps = new FillGaps($id);
                $data = $fill_gaps->check($array);
                return $data;
                break;
            case 'Таблица соответствий':
                $accordance_table = new AccordanceTable($id);
                $data = $accordance_table->check($array);
                return $data;
                break;
            case 'Да/Нет':
                $yes_no = new YesNo($id);
                $data = $yes_no->check($array);
                return $data;
                break;
            case 'Вопрос на вычисление':
                echo 'Вопрос на вычисление';
                break;
            case 'Вопрос на соответствие':
                echo 'Вопрос на соответствие';
                break;
            case 'Вид функции':
                echo 'Вопрос на определение аналитического вида функции';
                break;
        }
    }

    /** По id вопроса возвращает массив, где первый элемент - номер лекции, второй - <раздел.тема> */
    public function linkToLecture($id_question){
        $array = [];
        $theme = $this->getCode($id_question)['theme'];
        $query_theme = Theme::whereTheme($theme)
                        ->join('codificators', 'themes.theme', '=', 'codificators.value')
                        ->where('codificators.codificator_type', '=', 'Тема')
                        ->first();
        $lecture_id = $query_theme->lecture_id;
        $query_lec = Lecture::whereId_lecture($lecture_id)->first();
        $lection_number = $query_lec->lecture_number;
        array_push($array, $lection_number);
        array_push($array, '#'.$this->getCode($id_question)['section_code'].'.'.$this->getCode($id_question)['theme_code']);
        return $array;
    }

    /** главная страница модуля тестирования */
    public function index(){
        $username =  null;
        Session::forget('test');
        if (Auth::check()){
            $username = Auth::user()['first_name'];
        }
        return view('questions.teacher.index', compact('username'));
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
        $code = $this->setCode($request);
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