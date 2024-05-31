<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 05.04.15
 * Time: 15:56
 */

namespace App\Testing;
use App\Testing\Qtypes\AccordanceTable;
use App\Testing\Qtypes\Definition;
use App\Testing\Qtypes\FillGaps;
use App\Testing\Qtypes\FromCleene;
use App\Testing\Qtypes\JustAnswer;
use App\Testing\Qtypes\MultiChoice;
use App\Testing\Qtypes\OneChoice;
use App\Testing\Qtypes\QuestionTypeFactory;
use App\Testing\Qtypes\Theorem;
use App\Testing\Qtypes\TheoremLike;
use App\Testing\Qtypes\ThreePoints;
use App\Testing\Qtypes\YesNo;
use App\User;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Question  links()
 *
 */
class Question extends Eloquent {
    protected $table = 'questions';
    public $timestamps = false;

    const GROUP_AMOUNT = 3;         // TODO: think how it can be set outside

    /** Определяет одиночный вопрос (true) или может использоваться только в группе с такими же (false) */
    public static function isSingle($id){
        $type_code = Question::whereId_question($id)->select('type_code')->first()->type_code;
        $type = Type::whereType_code($type_code)->select('type_name')->first()->type_name;
        // TODO: remove hard code of grouped question types
        if ($type == 'Да/Нет' || $type == 'Определение' || $type == 'Просто ответ'){
            return false;
        }
        else return true;
    }

    /**
     * @param $sections int[]
     * @param $themes int[]
     * @param $types int[]
     * @param $test_type string
     * @param $printable int
     * @return int number of question with specified test settings | HTTP bad header
     */
    public static function getAmount($sections, $themes, $types, $test_type, $printable){
        if (count($sections) == 0 || count($themes) == 0 || count($types) == 0) {
            header('HTTP/1.1 500 Some parameters are not specified yet');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'Some parameters are not specified yet', 'code' => 1337)));
        }

        $questions  = new Question();

        // Все Вопросы из Разделов $sections.
        $questions = $questions->where(function($query) use ($sections) {
            $query->whereSection_code($sections[0]);
            for ($i = 1; $i < count($sections); $i++) {
                $query->orWhere('section_code', '=', $sections[$i]);
            }
        });

        // Фильтруем, оставляя только Вопросы
        // по Темам $themes
        $questions = $questions->where(function($query) use ($themes) {
            $query->whereTheme_code($themes[0]);
            for ($i = 1; $i < count($themes); $i++) {
                $query->orWhere('theme_code', '=', $themes[$i]);
            }
        });

        // Фильтруем далее, оставляя только Вопросы
        // Типов $types.
        $questions = $questions->where(function($query) use ($types) {
            $query->whereType_code($types[0]);
            for ($i = 1; $i < count($types); $i++) {
                $query->orWhere('type_code', '=', $types[$i]);
            }
        });

        // Для Тренировочных фильтруем далее,
        // оставляя только Тренировочные вопросы.
        // Выходит, что на Тренировке видим только Тренировочные Вопросы.
        // На Контрольной видим Тренировочные и Контрольные Вопросы.
        if ($test_type == 'Тренировочный'){
            $questions = $questions->whereControl(0);
        }
        // если не только для печати, а для электронного прохождения
        if ($printable == 0){
            $questions = $questions->whereRaw("type_code in (select type_code from types where only_for_print = 0)");
        }
        $amount = $questions->select('id_question')->count();
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
    public static function mixVariants($variants){
        $num_var = count($variants);
        $new_variants = [];
        for ($i=0; $i<$num_var; $i++){                                                                                  //варианты в случайном порядке
            $variants = Question::randomArray($variants);
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

    /** Получить правильный ответ */
    public static function getAnswer($id_question) {
        Log::debug('$id_question');
        Log::debug($id_question);
        $type = Question::whereId_question($id_question)->join('types', 'questions.type_code', '=', 'types.type_code')
                ->first()->type_name;
        $question = QuestionTypeFactory::getQuestionTypeByTypeName($id_question, $type);
        return $question->getAnswer();
    }

    /** Показывает вопрос согласно типу */
    public function show($id_question, $count, $is_adaptive){
        $type = Question::whereId_question($id_question)->join('types', 'questions.type_code', '=', 'types.type_code')
                ->first()->type_name;
        $question = QuestionTypeFactory::getQuestionTypeByTypeName($id_question, $type);
        $array = $question->show($count);
        $array['arguments']['is_adaptive'] = $is_adaptive;
        $route = $is_adaptive ? 'check_adaptive_test' : 'question_checktest';
        $array['arguments']['route'] = $route;
        return $array;
    }

    /** Проверяет вопрос согласно типу и на выходе дает баллы за него */
    public function check($array){
        $id = $array[0];
        $query = $this->whereId_question($id)->select('answer','points', 'type_code')->first();
        $points = $query->points;
        $type = Type::whereType_code($query['type_code'])->select('type_name')->first()->type_name;
        //если не был отмечен ни один вариант
        if (count($array)==1){
            $choice = [];
            $score = 0;
            $data = array('mark'=>'Неверно','score'=> $score, 'id' => $id,
                'points' => $points, 'choice' => $choice, 'right_percent' => 0);
            return $data;
        }
        $this->shift_ar($array);
        //убираем из входного массива id вопроса, чтобы остались лишь выбранные варианты ответа
        array_pop($array);
        $question = QuestionTypeFactory::getQuestionTypeByTypeName($id, $type);
        return $question->check($array);
    }

    /**
     * Передвигает массив так, чтобы первый элемент оказался последним.
     *
     * @param array $array
     */
    private static function shift_ar(&$array) {
        for ($i=0; $i < count($array)-1; $i++){
            $array[$i] = $array[$i+1];
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

    public static function isAnsweredRight($score, $max_points) {
        return ($score >= $max_points * 0.6);
    }

    public function evalDiscriminant($id_question) {
        $tasks = TestTask::whereId_question($id_question)
            ->join('results', 'test_tasks.id_result', '=', 'results.id_result')
            ->join('users', 'results.id', '=', 'users.id')
            ->whereNotNull('users.knowledge_level')
            ->select(
                'test_tasks.points as points',
                'users.knowledge_level as level'
            )
            ->get();
        return $this->discrV1($tasks, $id_question);
    }

    

    /**
     * Метод discrV1 использует классический подход корреляции Пирсона для расчёта дискриминанта.
     * Он вычисляет корреляцию между баллами, полученными на вопросе, и уровнем знаний пользователей.
     * Этот метод хорошо подходит, когда данные распределены нормально и когда важно учитывать линейную зависимость между переменными.
     */
    private function discrV1($tasks, $id_question) {
        // 0.7 будем использовать для тех вопросов, для которых
        // дискриминант не удаётся определить.
        $avg_res = 0.8;
        $N = $tasks->count();
        if ($N <= 0) {
            return $avg_res;
            // return Question::whereId_question($id_question)
            //     ->select('discriminant')->first()->discriminant;
        }
        $sum_points = 0;
        $sum_levels = 0;
        $sum_points_and_levels = 0;
        $sum_quadratic_points = 0;
        $sum_quadratic_levels = 0;
        foreach ($tasks as $task) {
            $points = $task->points;
            $level = $task->level;
            $sum_points += $points;
            $sum_levels += $level;
            $sum_points_and_levels += $points * $level;
            $sum_quadratic_points += $points * $points;
            $sum_quadratic_levels += $level * $level;
        }

        $division = ($N * $sum_points_and_levels) - ($sum_points * $sum_levels);
        $divider = sqrt(
            ($N * $sum_quadratic_points - pow($sum_points, 2)) *
            ($N * $sum_quadratic_levels - pow($sum_levels, 2))
        );

        if ($divider == 0) {
            return $avg_res;
            // return Question::whereId_question($id_question)
            //     ->select('discriminant')->first()->discriminant;
        }

        // Без домножения на 3 получаются значения [-1; 0.6].
        // В адаптивном вопросе используется в формуле 1.7 * discr.
        // При таком множителе discr должен находиться в практическом диапазоне [-1.64; 1.64].
        // Отрицательным он для хороший вопросов не должен быть, но это единичные случаи.
        // Получится следующий диапазон при домножении на 3:
        // [-3; 1.8]
        return $division / $divider * 3;
    }

    /**
     * Метод discrV2 использует подход, основанный на средних значениях и разностях от средних (delta метод).
     * Этот метод может быть более устойчивым к выбросам в данных, так как он не подвержен квадратичному влиянию экстремальных значений, как в случае с корреляцией Пирсона.
     */
    private function discrV2($tasks, $id_question) {
        $N = $tasks->count();
        if ($N <= 0) {
            return Question::whereId_question($id_question)
                ->select('discriminant')->first()->discriminant;
        }
        $xAvg = $tasks->avg('points');
        $yAvg = $tasks->avg('level');
        $sumDeltaX = 0;
        $sumDeltaY = 0;
        $sumSquaredDeltaX = 0;
        $sumSquaredDeltaY = 0;
        foreach ($tasks as $task) {
            $x = $task->points;
            $y = $task->level;
            $dx = $x - $xAvg;
            $dy = $y - $yAvg;
            $sumDeltaX += $dx;
            $sumDeltaY += $dy;
            $sumSquaredDeltaX += $dx*$dx;
            $sumSquaredDeltaY += $dy*$dy;
        }
        $divider = sqrt($sumSquaredDeltaX * $sumSquaredDeltaY);
        if ($divider == 0) {
            return Question::whereId_question($id_question)
                ->select('discriminant')->first()->discriminant;
        }
        return $sumDeltaX * $sumDeltaY / $divider;
    }

    public function evalDifficulty($id_question) {
        $right_answers_count = 0;
        $wrong_answers_count = 0;

        // Вопрос (хранит код темы, код раздела, код типа)
        $question = Question::whereId_question($id_question)->select('points', 'difficulty')->first();
        $max_points = $question->points;
        // Ответы на вопрос от разных пользователей (каждый ответ хранит ид результата, ид вопроса)
        // P.S. Результат - пройденный кем-то тест (тест может быть пройден несколько раз)
        $tasks = TestTask::whereId_question($id_question)->select('points')->get();
        foreach ($tasks as $task) {
            // Балл за ответ выше 60%?
            if (Question::isAnsweredRight($task->points, $max_points)) $right_answers_count++;
            else $wrong_answers_count++;
        }

        if ($right_answers_count == 0) {
            // Этот if отдельно выделен для возможности идентификации ситуации, когда
            // difficulty вопроса не определён именно по причине $right_answers_count == 0
            return 0;
        }
        if ($wrong_answers_count == 0) {
            return 0;
        }
        // Натуральный логарифм.
        // Результат от -Infinity до Infinity.
        // 1) 1 при wrong/right === e.
        // 2) 0 при wrong/right === 1.
        return log($wrong_answers_count / $right_answers_count);
    }
}
