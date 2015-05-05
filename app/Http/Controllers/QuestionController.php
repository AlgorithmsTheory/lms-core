<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 16:15
 */

namespace App\Http\Controllers;


use App\Test;
use App\Theme;
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
        $query1 = $codificator->whereCodificator_type('Раздел')->whereValue($section)->select('code')->first();
        $section_code = $query1->code;
        $query2 = $codificator->whereCodificator_type('Тема')->whereValue($theme)->select('code')->first();
        $theme_code = $query2->code;
        $query3 = $codificator->whereCodificator_type('Тип')->whereValue($type)->select('code')->first();
        $type_code = $query3->code;
        $code = $section_code.'.'.$theme_code.'.'.$type_code;

        return $code;
    }

    private function getCode($id, Codificator $codificator, Theme $tema){        //декодирование вопроса в асс. массив
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

    private function destruct(Test $test, $id_test){
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

    private function prepareTest(Test $test, $id_test){            //выборка вопросов
        $question = $this->question;
        $array = [];
        $k = 0;
        $temp_array = [];
        $destructured = $this->destruct($test, $id_test);

        for ($i=0; $i<count($destructured); $i++){
            //echo $destructured[$i][1].'<br>';
            $query=$question->where('code', '=', $destructured[$i][1])->get();          //ищем всевозможные коды вопросов
            //$query=$question->where('code', '=', '1.1.1')->get();
            foreach ($query as $id){
                array_push($temp_array,$id->id_question);                               //для каждого кода создаем массив всех вопрососв с этим кодом
            }
            for ($j=0; $j<$destructured[$i][0]; $j++){                                  //и выбираем заданное количество случайных
                $index = rand(0,count($temp_array)-1);
                $choisen = $temp_array[$index];
                $temp_array[$index]=$temp_array[count($temp_array)-1];
                $temp_array[count($temp_array)-1] = $choisen;
                array_pop($temp_array);
                $array[$k] = $choisen;
                $k++;
            }
            $temp_array = [];
        }
        return $array;          //формируем массив из id вошедших в тест вопросов
    }

    private function chooseQuestion(Test $test, $id_test){
        if (!Session::has('test')){                //генерируем тест, если еше не создан
            $array = $this->prepareTest($test, $id_test);
            $ser_array = serialize($array);
            Session::put('test', $ser_array);         //в сессии храним массив вопросов
            Session::put('score', 0);                 //количество правильных овтетов
            Session::put('num', count($array));       //всего вопросов
        }
        $ser_array = Session::get('test');
        $array = unserialize($ser_array);
        if (empty($array)){               //если вопросы кончились, завершаем тест
            Session::forget('test');
            return -1;
        }
        else{
            $index = rand(0,count($array)-1);     //выбираем случайный вопрос
            $choisen = $array[$index];
            $array[$index]=$array[count($array)-1];
            $array[count($array)-1] = $choisen;
            array_pop($array);                   //удаляем его из списка
            $ser_array = serialize($array);
            Session::put('test', $ser_array );
            return $choisen;
        }
    }

    public function result(){
        $score = Session::get('score');
        $total = Session::get('num');
        return view('welcome', compact('score', 'total'));
    }

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
        return view('questions.teacher.index'/*, compact('questions')*/);
    }

    public function create(){             //переход на страницу формы добавления
        return view('questions.teacher.create');
    }

    public function add(Codificator $codificator, Request $request){  //обработка формы добавления
       $code = $this->setCode($codificator, $request);

        //добавляем вопрос в таблицу
        $question = $this->question;
        $question->insert(array('code' => $code, 'title' => $request->input('title'), 'variants' => $request->input('variants'), 'answer' => $request->input('answer'), 'points' => $request->input('points')));
        return redirect()->route('question_index');
    }

    public function showTest($num, Codificator $codificator,  Theme $tema, Test $test){  //показать вопрос в тесте
        $id_test = 1;
        $id = $this->chooseQuestion($test, $id_test);          //получаем id случайного вопроса
        $score = Session::get('score');
        if ($id == -1)                                         //проверяем, не закончились ли вопросы
            return redirect()->route('question_result');
        //print_r (unserialize(Session::get('test')));
        $question = $this->question;
        //echo $id.'<br>';
        $decode = $this->getCode($id, $codificator, $tema);
        $type = $decode['type'];

        switch($type){
            case 'Выбор одного из списка':                      //Стас
                $query = $question->whereId_question($id)->select('title','variants','answer')->first();
                $text = $query->title;
                $answer = $query->answer;
                $parse = $query->variants;
                $variants = explode(";", $parse);
                //$field = $question->whereId_question($id)->select('title')->first();
                return view('tests.show1', compact('text','variants','answer','type','num', 'score'));
                break;

            case 'Выбор нескольких из списка':
                $query = $question->whereId_question($id)->select('title','variants','answer')->first();
                $text = $query->title;
                $answer = $query->answer;
                $parse = $query->variants;
                $variants = explode(";", $parse);
                //$field = $question->whereId_question($id)->select('title')->first();
                return view('tests.show2', compact('text','variants','answer','type','num', 'score'));
                break;

            case 'Текстовый вопрос':                            //Стас
                echo 'Вопрос на вставление слова';
                break;

            case 'Таблица соответствий':                        //Миша
                echo 'Вопрос на таблицу соответствий';
                break;

            case 'Да/Нет':                                      //Миша
                echo 'Вопрос выбора да или нет';
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

    public function checkTest(Request $request){   //обработать ответ на вопрос
        $num = $request->input('num');
        $num++;
        switch($request->input('type')){
            case 'Выбор одного из списка':                      //Стас
                if ($request->input('choice') == $request->input('answer')){
                    Session::put('score', Session::get('score')+1);
                    return redirect()->route('question_showtest', [$num]);
                    //header('Refresh: 3; URL=http://localhost/uir/public/questions');     //поменять время ожидания
                }
                else {
                    return redirect()->route('question_showtest', [$num]);
                }
                break;

            case 'Выбор нескольких из списка':
                $answer = $request->input('answer');
                $choices = ($request->input('choice'));
                $answers = explode(';', $answer);
                $counter = 0;
                $broken = 0;
                for ($i=0; $i<count($answers); $i++ ){        //сравниваем каждый правильный ответ
                    if ($counter == -1) break;
                    for ($j=0; $j<count($choices); $j++){      // с каждым выбранным
                        //echo $answers[$i].'=='.$choices[$j].'<br>';
                        if ($answers[$i] != $choices[$j]){
                            $broken++;                          //прибавляем счетчик непрвильных ответов
                        }
                        else {
                            $buf = $choices[$j];
                            $choices[$j] = $choices[count($choices)-1];     //меняем местами правильный ответ с последним для удаления
                            $choices[count($choices)-1] =  $buf;
                            array_pop($choices);                         //удаляем правильный проверенный вариант из массива выбранных ответов
                            $counter++;                                  // прибавляем счетчик правильных ответов
                            $broken = 0;
                            break;
                        }
                        if ($broken == count($answers)){                 //если на данной итерации все ответы неверные, то конец
                            $counter = -1;
                        }
                    }
                }
                /*echo $counter.'=='.count($answers).'<br>';
                echo $broken.'<br>';*/
                if ($counter == count($answers) && (empty($choices))){      //счетчик правильных ответов должен быть равен количеству
                    Session::put('score', Session::get('score')+1);         //правильных ответов и массив выбранных ответов д.б. пустым
                    return redirect()->route('question_showtest', [$num]);
                    //header('Refresh: 3; URL=http://localhost/uir/public/questions');         //поменять время ожидания
                }
                else {
                    return redirect()->route('question_showtest', [$num]);
                }
                break;

            case 'Текстовый вопрос':                            //Стас
                echo 'Вопрос на вставление слова';
                break;

            case 'Таблица соответствий':                        //Миша
                echo 'Вопрос на таблицу соответствий';
                break;

            case 'Да/Нет':                                      //Миша
                echo 'Вопрос выбора да или нет';
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

   /* public function show($id, Codificator $codificator,  Theme $tema){  //показать вопрос
        $question = $this->question;
        $decode = $this->getCode($id, $codificator, $tema);
        $type = $decode['type'];

        switch($type){
            case 'Выбор одного из списка':                      //Стас
                $query = $question->whereId_question($id)->select('title','variants','answer')->first();
                $text = $query->title;
                $answer = $query->answer;
                $parse = $query->variants;
                $variants = explode(";", $parse);
                //$field = $question->whereId_question($id)->select('title')->first();
                return view('questions.student.show1', compact('text','variants','answer','type','num'));
                break;

            case 'Выбор нескольких из списка':
                $query = $question->whereId_question($id)->select('title','variants','answer')->first();
                $text = $query->title;
                $answer = $query->answer;
                $parse = $query->variants;
                $variants = explode(";", $parse);
                //$field = $question->whereId_question($id)->select('title')->first();
                return view('questions.student.show2', compact('text','variants','answer','type'));
                break;

            case 'Текстовый вопрос':                            //Стас
                echo 'Вопрос на вставление слова';
                break;

            case 'Таблица соответствий':                        //Миша
                echo 'Вопрос на таблицу соответствий';
                break;

            case 'Да/Нет':                                      //Миша
                echo 'Вопрос выбора да или нет';
                break;

            case 'Вопрос на вычисление':
                echo 'Вопрос на вычисление';
                break;

            case 'Вопрос на соответствие':
                echo 'Вопрос на соответствие';
                break;

            case 'Вид фунции':
                echo 'Вопрос на определение аналитического вида функции';
                break;
        }
    }

    public function check(Request $request){   //обработать ответ на вопрос
        switch($request->input('type')){
            case 'Выбор одного из списка':                      //Стас
                if ($request->input('choice') == $request->input('answer')){
                    echo 'Верно <br><br>';
                    echo link_to_route('question_index', 'Вернуться к списку вопросов');
                    //header('Refresh: 3; URL=http://localhost/uir/public/questions');     //поменять время ожидания
                }
                else echo 'Неверно';
                break;

            case 'Выбор нескольких из списка':
                $answer = $request->input('answer');
                $choices = ($request->input('choice'));
                $answers = explode(';', $answer);
                $counter = 0;
                $broken = 0;
                for ($i=0; $i<count($answers); $i++ ){        //сравниваем каждый правильный ответ
                    if ($counter == -1) break;
                    for ($j=0; $j<count($choices); $j++){      // с каждым выбранным
                        //echo $answers[$i].'=='.$choices[$j].'<br>';
                        if ($answers[$i] != $choices[$j]){
                            $broken++;                          //прибавляем счетчик непрвильных ответов
                        }
                        else {
                            $buf = $choices[$j];
                            $choices[$j] = $choices[count($choices)-1];     //меняем местами правильный ответ с последним для удаления
                            $choices[count($choices)-1] =  $buf;
                            array_pop($choices);                         //удаляем правильный проверенный вариант из массива выбранных ответов
                            $counter++;                                  // прибавляем счетчик правильных ответов
                            $broken = 0;
                            break;
                        }
                        if ($broken == count($answers)){                 //если на данной итерации все ответы неверные, то конец
                            $counter = -1;
                        }
                    }
                }
                /*echo $counter.'=='.count($answers).'<br>';
                echo $broken.'<br>';
                if ($counter == count($answers) && (empty($choices))){      //счетчик правильных ответов должен быть равен количеству
                    echo 'Верно <br><br>';                                  //правильных ответов и массив выбранных ответов д.б. пустым
                    echo link_to_route('question_index', 'Вернуться к списку вопросов');
                    //header('Refresh: 3; URL=http://localhost/uir/public/questions');         //поменять время ожидания
                }
                else echo 'Неверно';
                break;

            case 'Текстовый вопрос':                            //Стас
                echo 'Вопрос на вставление слова';
                break;

            case 'Таблица соответствий':                        //Миша
                echo 'Вопрос на таблицу соответствий';
                break;

            case 'Да/Нет':                                      //Миша
                echo 'Вопрос выбора да или нет';
                break;

            case 'Вопрос на вычисление':
                echo 'Вопрос на вычисление';
                break;

            case 'Вопрос на соответствие':
                echo 'Вопрос на соответствие';
                break;

            case 'Вид фунции':
                echo 'Вопрос на определение аналитического вида функции';
                break;
        }
    }*/

    public function killSession(){
        Session::flush();
        return redirect()->route('question_index');
    }
} 