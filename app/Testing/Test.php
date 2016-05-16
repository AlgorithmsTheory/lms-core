<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 15:56
 */

namespace App\Testing;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_name($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_course($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_type($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTest_time($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Test  whereTotal($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  distinct()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  update($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Test  toSql()
 *
 */
class Test extends Eloquent {
    const GROUP_AMOUNT = 3;                                                                                             // число вопросов в групповых вопросах
    protected $tests = 'tests';
    public $timestamps = false;
    protected $fillable = ['test_name', 'amount', 'test_time', 'start', 'end', 'structure', 'total'];

    /** Проверяет, что установлена опция any в интерфейсе занесения теста */
    public function optionAny($option){
        if ($option == 'Любой' || $option == 'Любая' || $option == 'Любое' || $option == "Любые"){
            return true;
        }
        else return false;
    }

    public static function getAmount($id_test){
        return TestStructure::whereId_test($id_test)->sum('amount');
    }

    /** Проверяет, завершен ли тест */
    public static function isFinished($id_test){
        //ищем среди студентов тех, кто не проходил данный тест в заданный промежуток времени
        $user_query = User::where('year', '=', date('Y'))                                                               //пример сырого запроса
            //->whereRole('Студент')
            ->whereRaw("not exists (select `id` from `results`
                                        where results.id = users.id
                                        and `results`.`id_test` = ".$id_test. "
                                        and `results`.`result_date` between '".Test::whereId_test($id_test)->select('start')->first()->start."'
                                        and '".Test::whereId_test($id_test)->select('end')->first()->end."'
                                        )")
            ->distinct()
            ->select()
            ->get();
        if (sizeof($user_query) == 0)                                                                                   //если таких студентов нет, то тест завершен
            return true;
        else                                                                                                            //иначе не завершен
            return false;
    }

    /** Если тест прошлый возвращает -1, текущий 0, будущий 1 */
    public static function getTimeZone($id_test){
        $current_date = date("U");
        $test = Test::whereId_test($id_test)->first();
        $start = strtotime($test->start);
        $end = strtotime(($test->end));
        if ($start < $current_date && $end > $current_date)
            return 0;
        if ($end < $current_date)
            return -1;
        if ($start > $current_date)
            return 1;
    }

    /** проверяет права доступа к рыбинским вопросам */
    public function rybaTest($id_question){
        $question = new Question();
        if (Question::whereId_question($id_question)->select('section_code')->first()->section_code == 10){
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
    public function calcMarkRus($max, $real){
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
    public function prepareTest($id_test){                                                                              //выборка вопросов
        $array = [];
        $k = 0;
        $structures = TestStructure::whereId_test($id_test)->select('id_structure')->get();
        foreach ($structures as $structure){                                                                            // идем по всем структурам теста
            $temp_array = [];
            $records = StructuralRecord::whereId_structure($structure['id_structure'])->get();
            foreach ($records as $record){                                                                              // идем по всем записям структуры
                $questions = Question::whereSection_code($record['section_code'])                                       // заносим все подходящие вопросы во временный массив
                            ->whereTheme_code($record['theme_code'])->whereType_code($record['type_code'])
                            ->get();
                foreach ($questions as $question){
                    if (array_search($question['id_question'], $array) == false)                                        // проверяем, что вопрос уже не в выходном массиве
                        array_push($temp_array, $question['id_question']);
                }
            }

            $amount = $this->getAmount($id_test);
            while ($amount > 0){                                                                                        //пока не выбрали нужное количество вопросов данной структуры
                $temp_array = Question::randomArray($temp_array);                                                       //выбираем случайный вопрос
                $temp_question = $temp_array[count($temp_array)-1];

                if (Question::getSingle($temp_question)){                                                               //если вопрос одиночный (то есть как и было ранее)
                    $array[$k] = $temp_question;                                                                        //добавляем вопрос в выходной массив
                    $k++;
                    $amount--;
                    array_pop($temp_array);
                }
                else {                                                                                                  //если вопрос может использоваться только в группе
                    $query = Question::whereId_question($temp_question)->first();
                    $base_question_type = $query->type_code;                                                            //получаем код типа базового вопроса, для которого будем создавать группу
                    $max_id = Question::max('id_question');
                    $new_id = $max_id+1;
                    $new_title = $query->title;                                                                         //берем данные текущего вопроса
                    $new_answer = $query->answer;
                    array_pop($temp_array);                                                                             //и убираем его из массива

                    $new_temp_array = [];
                    foreach ($temp_array as $temp_question){                                                            // создаем массив из подходящих групповых вопросов
                        if (Question::whereId_question($temp_question)->first()->type_code == $base_question_type){
                            array_push($new_temp_array, $temp_question);
                        }
                    }

                    if (count($new_temp_array) < $this::GROUP_AMOUNT - 1){                                              // если нужных вопросов заведомо не хватит для составления группового вопроса
                        foreach ($new_temp_array as $question_for_remove){                                              // удаляем их из temp_array
                            $index_in_old_array = array_search($question_for_remove, $temp_array);                      //ищем в базовом массиве индекс нашего вопроса
                            $chosen = $temp_array[$index_in_old_array];                                                 //и меняем его с последним элементом в этом массиве
                            $temp_array[$index_in_old_array]=$temp_array[count($temp_array)-1];
                            $temp_array[count($temp_array)-1] = $chosen;
                            array_pop($temp_array);
                        }
                        continue;                                                                                       // продолжаем выбирать вопросы для этой структуры
                    }

                    $l = 1;
                    while ($l < $this::GROUP_AMOUNT) {                                                                  //берем 3 вопроса
                        $new_temp_array = Question::randomArray($new_temp_array);
                        $temp_question_new = $new_temp_array[count($new_temp_array)-1];

                        $index_in_old_array = array_search($temp_question_new, $temp_array);                            //ищем в базовом массиве индекс нашего вопроса
                        $chosen = $temp_array[$index_in_old_array];                                                     //и меняем его с последним элементом в этом массиве
                        $temp_array[$index_in_old_array]=$temp_array[count($temp_array)-1];
                        $temp_array[count($temp_array)-1] = $chosen;

                        $query_new = Question::whereId_question($temp_question_new)->first();
                        $new_title .= ';'.$query_new->title;                                                            //составляем составной вопрос
                        $new_answer .= ';'.$query_new->answer;
                        array_pop($temp_array);                                                                         //удаляем и из базового массива
                        array_pop($new_temp_array);                                                                     //и из нового
                        $l++;
                    }
                    Question::insert(array('title' => $new_title, 'variants' => '', 'answer' => $new_answer,            //вопрос про код и баллы
                                            'points' => 1, 'control' => 0, 'theme_code' => -1,
                                            'section_code' => -1, 'type_code' => $base_question_type));
                    $array[$k] = $new_id;                                                                               //добавляем сформированный вопрос в выходной массив
                    $k++;
                    $amount--;
                }
            }
        }
        return $array;                                                                                                  //формируем массив из id вошедших в тест вопросов
    }

} 