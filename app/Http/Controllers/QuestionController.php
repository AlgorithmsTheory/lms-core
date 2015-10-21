<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 16:15
 */
namespace App\Http\Controllers;
use Cookie;
use Session;
use View;
use App\Result;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use App\Test;
use App\Theme;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Bruser;
use App\Qtypes\OneChoice;
use App\Qtypes\MultiChoice;
use App\Qtypes\FillGaps;
use App\Qtypes\AccordanceTable;
use App\Qtypes\YesNo;
class QuestionController extends Controller{
    private $question;
    function __construct(Question $question){
        $this->question=$question;
    }
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
    private function getCode($id){        //декодирование вопроса в асс. массив
        $codificator = new Codificator();
        $question = $this->question;
        $query = $question->whereId_question($id)->select('code')->first();
        $code = $query->code;          //получили код вопроса
        $array = explode('.',$code);
        // print_r($array);
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
    private static function randomArray($array){
        $index = rand(0,count($array)-1);     //выбираем случайный вопрос
        $chosen = $array[$index];
        $array[$index]=$array[count($array)-1];
        $array[count($array)-1] = $chosen;
        return $array;                        //получаем тот же массив, где выбранный элемент стоит на последнем месте для удаления
    }
    public static function mixVariants($variants){
        $num_var = count($variants);
        $new_variants = [];
        for ($i=0; $i<$num_var; $i++){                        //варианты в случайном порядке
            $variants = QuestionController::randomArray($variants);
            $chosen = array_pop($variants);
            $new_variants[$i] = $chosen;
        }
        return $new_variants;
    }
    private function destruct($id_test){
        $test = new Test();
        $query = $test->whereId_test($id_test)->select('structure')->first();
        $structure = $query->structure;
        $destructured = explode(';', $structure);
        $array = [];
        for ($i=0; $i<count($destructured); $i++){
            $temp_array = explode('-', $destructured[$i]);
            for ($j=0; $j<=1; $j++){
                $array[$i][$j] = $temp_array[$j];
            }
        }
        return $array;
    }
    private function prepareTest($id_test){            //выборка вопросов
        $question = $this->question;
        $array = [];
        $k = 0;
        $temp_array = [];
        $destructured = $this->destruct($id_test);
        for ($i=0; $i<count($destructured); $i++){
            $temp = preg_replace('~A~', '[[:digit:]]+', $destructured[$i][1] );                                         //заменям все A (All) на регулярное выражение, соответствующее любому набору цифр
            $query = $question->where('code', 'regexp', $temp)->get();                                                  //ищем всевозможные коды вопросов
            //$query=$question->where('code', '=', $destructured[$i][1])->get();
            //$query=$question->where('code', '=', '1.1.1')->get();
            foreach ($query as $id){
                array_push($temp_array,$id->id_question);                                                               //для каждого кода создаем массив всех вопрососв с этим кодом
            }
            for ($j=0; $j<$destructured[$i][0]; $j++){                                                                  //и выбираем заданное количество случайных
                $temp_array = $this->randomArray($temp_array);
                $array[$k] = $temp_array[count($temp_array)-1];
                array_pop($temp_array);
                $k++;
            }
            $temp_array = [];
        }
        return $array;          //формируем массив из id вошедших в тест вопросов
    }
    private function chooseQuestion(&$array){
        if (empty($array)){               //если вопросы кончились, завершаем тест
            return -1;
        }
        else{
            $array = $this->randomArray($array);
            $choisen = $array[count($array)-1];
            array_pop($array);                   //удаляем его из списка
            return $choisen;
        }
    }
    private function showTest($id_question, $count){  //показать вопрос в тесте
        $decode = $this->getCode($id_question);
        $type = $decode['type'];
        switch($type){
            case 'Выбор одного из списка':                      //Стас
                $one_choice = new OneChoice($id_question);
                $array = $one_choice->show($count);
                return $array;
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id_question);
                $array = $multi_choice->show($count);
                return $array;
                break;
            case 'Текстовый вопрос':                            //Стас
                $fill_gaps = new FillGaps($id_question);
                $array = $fill_gaps->show($count);
                return $array;
                break;
            case 'Таблица соответствий':                        //Миша
                $accordance_table = new AccordanceTable($id_question);
                $array = $accordance_table->show($count);
                return $array;
                break;
            case 'Да/Нет':                                      //Миша
                $yes_no = new YesNo($id_question);
                $array = $yes_no->show($count);
                return $array;
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
    private function check($array){       //проверяет правильность вопроса и на выходе дает баллы за вопрос
        $question = $this->question;
        $id = $array[0];
        $query = $question->whereId_question($id)->select('answer','points')->first();
        $points = $query->points;
        $type = $this->getCode($id)['type'];
        if (count($array)==1){           //если не был отмечен ни один вариант
            $choice = [];
            $score = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $id, 'points' => $points, 'choice' => $choice);
            return $data;
        }
        for ($i=0; $i < count($array)-1; $i++){                                    //передвигаем массив, чтобы первый элемент оказался последним
            $array[$i] = $array[$i+1];
        }
        array_pop($array);                                             //убираем из входного массива id вопроса, чтобы остались лишь выбранные варианты ответа
        switch($type){
            case 'Выбор одного из списка':                      //Стас
                $one_choice = new OneChoice($id);
                $data = $one_choice->check($array);
                return $data;
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id);
                $data = $multi_choice->check($array);
                return $data;
                break;
            case 'Текстовый вопрос':                            //Стас
                $fill_gaps = new FillGaps($id);
                $data = $fill_gaps->check($array);
                return $data;
                break;
            case 'Таблица соответствий':                        //Миша
                $accordance_table = new AccordanceTable($id);
                $data = $accordance_table->check($array);
                return $data;
                break;
            case 'Да/Нет':                                      //Миша
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
    private function calcMarkBologna($max, $real){          //вычисляет оценку по Болонской системе
        if ($real < $max * 0.6){
            return 'F';
        }
        if ($real >= $max * 0.6 && $real < $max * 0.65){
            return 'E';
        }
        if ($real >= 0.65 && $real < $max * 0.75){
            return 'D';
        }
        if ($real >= 0.75 && $real < $max * 0.85){
            return 'C';
        }
        if ($real >= 0.85 && $real < $max * 0.9){
            return 'B';
        }
        if ($real >= 0.9){
            return 'A';
        }
    }
    private function calcMarkRus($max, $real){       //вычисляет оценку по обычной 5-тибалльной шкале
        if ($real < $max * 0.6){
            return '2';
        }
        if ($real >= $max * 0.6 && $real < $max * 0.7){
            return '3';
        }
        if ($real >= 0.7 && $real < $max * 0.9){
            return '4';
        }
        if ($real >= 0.9){
            return '5';
        }
    }
    /*public function result(){
        $score = Cookie::get('score');
        $total = Cookie::get('num');
        return view('welcome', compact('score', 'total'));
    }*/
    public function index(){
        //Дефолтная страница при разграничении прав
        /*if (Session::has('username')){
             return view('questions.student.index');
        }
        if (Session::has('teachername')){
            return view('questions.teacher.index');
        }*/
        //$questions = $this->question->get();
        //dd($questions);
        $username =  null;
        /*if (Cookie::has('username')){
            $username =  Session::get('username');
        }*/
        if (Session::has('username')){
            $username = Session::get('username');
        }
        return view('questions.teacher.index', compact('username'));
    }

    public function form(Request $request){
        $user = new Bruser();
        $username = $request->input('username');
        $query = $user->whereName($username)->select('password', 'id')->get();
        foreach ($query as $password){
            $pass = $password->password;
            if ($pass == $request->input('password')){
                Session::put('username',$username);
                return redirect()->route('question_index');
            }
            else  {
                echo 'Неверный пароль';
                return redirect()->route('question_index');
            }
        }
    }
    
    public function enter(){
        return view('questions.student.ty');
    }
    public function create(){             //переход на страницу формы добавления
        $codificator = new Codificator();
        $types = [];
        $query = $codificator->whereCodificator_type('Тип')->select('value')->get();
        foreach ($query as $type){
            array_push($types,$type->value);
        }
        return view('questions.teacher.create', compact('types'));
    }
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
    }
    public function add(Request $request){  //обработка формы добавления
        $code = $this->setCode($request);
        $type = $request->input('type');
        $query = Question::max('id_question');     //пример использования агрегатных функций!!!
        $id = $query+1;
        switch($type){
            case 'Выбор одного из списка':                      //Стас
                $one_choice = new OneChoice($id);
                $one_choice->add($request, $code);
                break;
            case 'Выбор нескольких из списка':
                $multi_choice = new MultiChoice($id);
                $multi_choice->add($request, $code);
                break;
            case 'Текстовый вопрос':                            //Стас
                $fill_gaps = new FillGaps($id);
                $fill_gaps->add($request, $code);
                break;
            case 'Таблица соответствий':                        //Миша
                $fill_gaps = new AccordanceTable($id);
                $fill_gaps->add($request, $code);
                break;
            case 'Да/Нет':                                      //Миша
                $fill_gaps = new YesNo($id);
                $fill_gaps->add($request, $code);
                break;
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
        return redirect()->route('question_create');
    }
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
    public function showViews($id_test){
        //создаем строку в таблице пройденных тестов
        $test = new Test();
        $result = new Result();
        $user = new Bruser();
        $query = Result::max('id_result');     //пример использования агрегатных функций!!!
        $current_result = $query+1;            //создаем новый результат
        $query = $test->whereId_test($id_test)->select('amount', 'test_name')->first();   //кол-во вопрососв в тесте
        $query2 = $user->whereName(Session::get('username'))->select('id')->first();
        $result->id_result = $current_result;
        $result->id_user = $query2->id;;        //пока без привзяки к таблице пользователей
        $result->id_test = $id_test;
        $result->test_name = $query->test_name;
        $amount = $query->amount;
        $result->amount = $amount;
        $result->save();
        $widgets = [];
        $saved_test = [];
        $ser_array = $this->prepareTest($id_test);
        for ($i=0; $i<$amount; $i++){
            $id = $this->chooseQuestion($ser_array);
            $data = $this->showTest($id, $i+1);                  //должны получать название view и необходимые параметры
            $saved_test[] = $data;
            $widgets[] = View::make($data['view'], $data['arguments']);
        }
        $saved_test = serialize($saved_test);
        Result::where('id_result', '=', $current_result)->update(['result' => $saved_test]);
        Cookie::queue('current_test', $current_result);
        $widgetListView = View::make('questions.student.widget_list',compact('amount', 'id_test'))->with('widgets', $widgets);
        $response = new Response($widgetListView);
        return $response;
    }
    public function checkTest(Request $request){   //обработать ответ на вопрос
        $amount = $request->input('amount');
        $id_test = $request->input('id_test');
        $test = new Test();
        $query = $test->whereId_test($id_test)->select('total', 'test_name', 'amount')->first();
        $total = $query->total;
        $test_name = explode(";", $query->test_name);
        $score_sum = 0;
        $points_sum = 0;
        $choice = [];
        $j = 1;
        for ($i=0; $i<$amount; $i++){        //обрабатываем каждый вопрос
            $data = $request->input($i);
            $array = json_decode($data);
            //print_r($array);
            $data = $this->check($array);
            /*if ($data['mark'] == 'Неверно'){
                $mark[$j]= $data['mark'];      //массив неверных вопросов
                $j++;
            }*/
            $right_or_wrong[$j] = $data['mark'];
            $choice[$j] = $data['choice'];
            $j++;
            $score_sum += $data['score'];     //сумма набранных баллов
            $points_sum += $data['points'];   //сумма максимально возможных баллов
        }
        if ($points_sum != 0){
            $score = $total*$score_sum/$points_sum;
            $score = round($score,1);
        }
        else $score = $total;
        $mark_bologna = $this->calcMarkBologna($total, $score);    //оценки
        $mark_rus = $this->calcMarkRus($total, $score);
        $mark = $mark_bologna.';'.$mark_rus;
        $result = new Result();
        $current_test = Cookie::get('current_test');
        $number_of_wrong = count($mark);
        if ($test_name[0] != 'Тренировочный'){
            $result->whereId_result($current_test)->update(['result' => $score, 'mark' => $mark]);
            return view('tests.ctrresults', compact('score', 'mark_bologna', 'mark_rus'));
        }
        else{
            $amount = $query->amount;
            $widgets = [];
            $query = $result->whereId_result($current_test)->first();
            $saved_test = $query->result;
            $saved_test = unserialize($saved_test);
            for ($i=0; $i<$amount; $i++){
                $widgets[] = View::make($saved_test[$i]['view'].'T', $saved_test[$i]['arguments'])->with('choice', $choice[$i+1]);
            }
            $result->whereId_result($current_test)->update(['result' => $score, 'mark' => $mark]);
            $widgetListView = View::make('questions.student.training_test',compact('amount', 'id_test','score','right_or_wrong','number_of_wrong', 'mark_bologna', 'mark_rus'))->with('widgets', $widgets);
            return $widgetListView;
        }
        /*print_r($data);
        echo '<br>';
        print_r($array);
        echo '<br><br>';*/
    }
}