<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 15:56
 */

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Test whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTest_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTest_type($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTest_time($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereStructure($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Test  whereTotal($value)
 * @method static \Illuminate\Database\Eloquent|\App\Test  get()
 * @method static \Illuminate\Database\Eloquent|\App\Test  distinct()
 * @method static \Illuminate\Database\Eloquent|\App\Test  where()
 * @method static \Illuminate\Database\Eloquent|\App\Test  select()
 * @method static \Illuminate\Database\Eloquent|\App\Test  first()
 * @method static \Illuminate\Database\Eloquent|\App\Test  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Test  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Test  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Test  toSql()
 *
 */
class Test extends Eloquent {
    protected $tests = 'tests';
    public $timestamps = false;
    protected $fillable = ['test_name', 'amount', 'test_time', 'start', 'end', 'structure', 'total'];

    /**
     * @param $amount
     * @param $section
     * @param $theme
     * @param $type
     * Из текстовых описаний вопроса, формирует структуру a-b.c.d
     * @return string
     */
    public function struct($amount, $section, $theme, $type){
        $codificator = new Codificator();
        if ($amount != ''){
            $struct = $amount.'-';
        }
        else $struct = '';
        if ($section == 'Любой'){
            $struct .= 'A.';
        }
        else {
            $query = $codificator->whereCodificator_type('Раздел')->whereValue($section)->select('code')->first();
            $struct .= $query->code.'.';
        }
        if ($theme == 'Любая'){
            $struct .= 'A.';
        }
        else {
            $query = $codificator->whereCodificator_type('Тема')->whereValue($theme)->join('themes', 'themes.theme', '=', 'codificators.value')->where('themes.section', '=', $section)->select('code')->first();
            $struct .= $query->code.'.';
        }
        if ($type == 'Любой'){
            $struct .= 'A';
        }
        else {
            $query = $codificator->whereCodificator_type('Тип')->whereValue($type)->select('code')->first();
            $struct .= $query->code;
        }
        return $struct;
    }

    /**
     * Декодирует кодовую структуру теста
     * Возвращает двумерный массив, где по i идут различные структуры вопросов, j=0 - количество вопросов данной структуры, j=1 - сам код вопроса
     */
    public function destruct($id_test){
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

    /** проверяет права доступа к рыбинским вопросам */
    public function rybaTest($id_question){
        $question = new Question();
        if ($question->getCode($id_question)['section_code'] == 10){
            if (Auth::user()['role'] == 'Рыбинец' || Auth::user()['role'] == 'Админ'){
                return true;
            }
            else return false;
        }
        else return true;
    }

    /** вычисляет оценку по Болонской системе, если дан максимально возможный балл и реальный */
    public function calcMarkBologna($max, $real){
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

    /** вычисляет оценку по обычной 5-тибалльной шкале, если дан максимально возможный балл и реальный */
    public  function calcMarkRus($max, $real){
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

    /** По номеру теста возвращает список id вопросов, удовлетворяющих всем параметрам теста */
    public function prepareTest($id_test){                                                                             //выборка вопросов
        $question = new Question();
        $array = [];
        $k = 0;
        $destructured = $this->destruct($id_test);
        for ($i=0; $i<count($destructured); $i++){                                                                      // идем по всем структурам
            $temp_array = [];
            $j = 0;
            $temp = '"';
            $temp .= preg_replace('~\.~', '\.', $destructured[$i][1]);
            $temp = preg_replace('~A~', '[[:digit:]]+', $temp);                                                         //заменям все A (All) на регулярное выражение, соответствующее любому набору цифр
            $temp .= '"';
            $query = Question::whereRaw("code REGEXP $temp")->get();                                                  //ищем всевозможные коды вопросов
            $test_query = $this->whereId_test($id_test)->select('test_type')->first();
            foreach ($query as $id){
                if ($question->getCode($id->id_question)['section_code'] != 'T'){                                                  //если вопрос не временный
                    if ($test_query->test_type == 'Тренировочный'){                                                     //если тест тренировочный
                        if ($id->control == 1)                                                                          //если вопрос скрытый, то проходим мимо
                            continue;
                        array_push($temp_array,$id->id_question);                                                       //для каждого кода создаем массив всех вопрососв с этим кодом
                    }
                    else array_push($temp_array,$id->id_question);                                                      // если тест контрольный
                }
            }
            while ($j < $destructured[$i][0]){                                                                          //пока не закончатся вопросы этой структуры
                $temp_array = $question->randomArray($temp_array);                                                          //выбираем случайный вопрос
                $temp_question = $temp_array[count($temp_array)-1];
                if ($question->getSingle($temp_question)){                                                                  //если вопрос одиночный (то есть как и было ранее)
                    $array[$k] = $temp_question;                                                                        //добавляем вопрос в выходной массив
                    $k++;
                    $j++;
                    array_pop($temp_array);
                }
                else {                                                                                                  //если вопрос может использоваться только в группе
                    $query = $question->whereId_question($temp_question)->first();
                    $base_question_type = $question->getCode($temp_question)['type_code'];                                  //получаем код типа базового вопроса, для которого будем создавать группу
                    $max_id = Question::max('id_question');
                    $new_id = $max_id+1;
                    $new_title = $query->title;                                                                         //берем данные текущего вопроса
                    $new_answer = $query->answer;
                    array_pop($temp_array);                                                                             //и убираем его из массива
                    $new_temp_array = [];
                    for ($p=0; $p < count($temp_array); $p++){                                                          //создаем копию массива подходящих вопросов
                        $new_temp_array[$p] = $temp_array[$p];
                    }
                    $l = 0;
                    while ($l < 3) {                                                                                    //берем еще 3 вопроса этого типа => в итоге получаем 4
                        $new_temp_array = $question->randomArray($new_temp_array);
                        $temp_question_new = $new_temp_array[count($new_temp_array)-1];

                        if ($question->getCode($temp_question_new)['type_code'] != $base_question_type){                    //если тип вопроса не совпадает с базовым
                            array_pop($new_temp_array);                                                                 //удаляем его из новго массива и идем дальше
                            continue;
                        }

                        $index_in_old_array = array_search($temp_question_new, $temp_array);                            //ищем в базовом массиве индекс нашего вопроса
                        $chosen = $temp_array[$index_in_old_array];                                                     //и меняем его с последним элементом в этом массиве
                        $temp_array[$index_in_old_array]=$temp_array[count($temp_array)-1];
                        $temp_array[count($temp_array)-1] = $chosen;

                        $query_new = $question->whereId_question($temp_question_new)->first();
                        $new_title .= ';'.$query_new->title;                                                            //составляем составной вопрос
                        $new_answer .= ';'.$query_new->answer;
                        array_pop($temp_array);                                                                         //удаляем и из базовгго массива
                        array_pop($new_temp_array);                                                                     //и из нового
                        $l++;
                    }
                    Question::insert(array('control' => 0, 'code' => 'T.T.'.$base_question_type, 'title' => $new_title, 'variants' => '', 'answer' => $new_answer, 'points' => 1));    //вопрос про код и баллы
                    $array[$k] = $new_id;                                                                               //добавляем сформированный вопрос в выходной массив
                    $k++;
                    $j++;
                }
            }
        }
        return $array;                                                                                                  //формируем массив из id вошедших в тест вопросов
    }

} 