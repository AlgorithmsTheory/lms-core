<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 15:56
 */

namespace App\Testing;
use App\Qtypes\AccordanceTable;
use App\Qtypes\Definition;
use App\Qtypes\FillGaps;
use App\Qtypes\JustAnswer;
use App\Qtypes\MultiChoice;
use App\Qtypes\OneChoice;
use App\Qtypes\Theorem;
use App\Qtypes\YesNo;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question whereId_question($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereVariants($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereSection_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereTheme_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereType_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Question  whereControl($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  whereRaw()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  orWhere()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  count()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  toSql()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  paginate($value)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  links()
 *
 */
class Question extends Eloquent {
    protected $table = 'questions';
    public $timestamps = false;

    /** Определяет одиночный вопрос (true) или может использоваться только в группе с такими же (false) */
    public static function getSingle($id){
        $type_code = Question::whereId_question($id)->select('type_code')->first()->type_code;
        $type = Type::whereType_code($type_code)->select('type_name')->first()->type_name;
        if ($type == 'Да/Нет' || $type == 'Определение' || $type == 'Просто ответ'){
            return false;
        }
        else return true;
    }

    /** по названию раздела, темы и типа вычисляет количество доступных вопросов в БД данной структуры */
    public static function getAmount($section_name, $theme_name, $type_name, $test_type){
        if ($section_name != 'Любой')
            $section = Section::whereSection_name($section_name)->select('section_code')->first()->section_code;
        else $section = 'Любой';
        if ($theme_name != 'Любая')
            $theme = Theme::whereTheme_name($theme_name)->select('theme_code')->first()->theme_code;
        else $theme = 'Любая';
        if ($type_name != 'Любой')
            $type = Type::whereType_name($type_name)->select('type_code')->first()->type_code;
        else $type = 'Любой';

        if ($section == 'Любой'){
            if ($type == 'Любой'){
                if ($test_type == 'Тренировочный')                                                // любой раздел, любая тема, любой тип, тренировочный тест
                    $amount = Question::whereControl(0)->select('id_question')->count();
                else $amount = Question::select('id_question')->count();                                            // любой раздел, любая тема, любой тип, контрольный тест
            }
            else {
                if ($test_type == 'Тренировочный')                                                // любой раздел, любая тема, тренировочный тест
                    $amount = Question::whereControl(0)->whereType_code($type)->select('id_question')->count();
                else $amount = Question::whereType_code($type)->select('id_question')->count();                     // любой раздел, любая тема, контрольный тест
            }
        }
        else {
            if ($theme == 'Любая'){
                if ($type == 'Любой'){
                    if ($test_type == 'Тренировочный')                                            //любая тема, любой тип, тренировочный тест
                        $amount = Question::whereControl(0)->whereSection_code($section)->select('id_question')->count();
                    else $amount = Question::whereSection_code($section)->select('id_question')->count();           // любая тема, любой тип, контрольный тест
                }
                else {
                    if ($test_type == 'Тренировочный')                                            //любая тема, тренировочный тест
                        $amount = Question::whereControl(0)->whereSection_code($section)->whereType_code($type)->select('id_question')->count();
                    else                                                                                            // любая тема, контрольный тест
                        $amount = Question::whereSection_code($section)->whereType_code($type)->select('id_question')->count();
                }
            }
            else {
                if ($type == 'Любой'){
                    if ($test_type == 'Тренировочный')                                            // любой тип, тренировочный тест
                        $amount = Question::whereControl(0)->whereSection_code($section)->whereTheme_code($theme)->select('id_question')->count();
                    else                                                                                            // любой тип, контрольный тест
                        $amount = Question::whereSection_code($section)->whereTheme_code($theme)->select('id_question')->count();
                }
                else {
                    if ($test_type == 'Тренировочный')                                            // тренировочный тест
                        $amount = Question::whereControl(0)->whereSection_code($section)->whereTheme_code($theme)->whereType_code($type)->select('id_question')->count();
                    else                                                                                            // контрольный тест
                        $amount = Question::whereSection_code($section)->whereTheme_code($theme)->whereType_code($type)->select('id_question')->count();
                }
            }
        }
        return $amount;
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
    public function mixVariants($variants){
        $num_var = count($variants);
        $new_variants = [];
        for ($i=0; $i<$num_var; $i++){                                                                                  //варианты в случайном порядке
            $variants = $this->randomArray($variants);
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
        $type = Question::whereId_question($id_question)->join('types', 'questions.type_code', '=', 'types.type_code')
                ->first()->type_name;
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
        $id = $array[0];
        $query = $this->whereId_question($id)->select('answer','points', 'type_code')->first();
        $points = $query->points;
        $type = Type::whereType_code($query['type_code'])->select('type_name')->first()->type_name;
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
        $id_lecture = Question::whereId_question($id_question)
                ->join('themes', 'questions.theme_code', '=', 'themes.theme_code')
                ->first()->id_lecture;
        if (!is_null($id_lecture)){
            $lecture_number = Lecture::whereId_lecture($id_lecture)->select('lecture_number')->first()->lecture_number;
            array_push($array, $lecture_number);
            array_push($array, '#'.Question::whereId_question($id_question)->select('section_code')->first()->section_code.
                       '.'.Question::whereId_question($id_question)->select('theme_code')->first()->theme_code);
        }
        return $array;
    }
} 