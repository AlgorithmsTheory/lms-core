<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 27.11.18
 * Time: 10:43
 */

namespace App\Testing\TestGeneration;

use App\Classwork;
use App\Lectures;
use App\Seminars;
use App\Testing\Adaptive\AdaptiveQuestion;

use App\Testing\Adaptive\BolognaMark;
use App\Testing\Adaptive\FinishCriteria;
use App\Testing\Adaptive\KnowledgeLevel;
use App\Testing\Adaptive\Phase;
use App\Testing\Adaptive\QuestionClass;
use App\Testing\Adaptive\Weights;
use App\Testing\Question;
use App\Testing\Result;
use App\Testing\StructuralRecord;
use App\Testing\Test;
use App\User;
use Auth;
use Illuminate\Support\Facades\Log;

class AdaptiveTestGenerator implements TestGenerator {

    /**
     * @var int result ID
     */
    private $id_result;

    /**
     * @var KnowledgeLevel from user info
     */
    private $student_knowledge_level;

    /**
     * @var BolognaMark expected student mark for the test
     */
    private $student_expected_mark;

    /**
     * @var int pre calculated value
     * 
     * Ср. арифм. сложностей Вопросов (по шкале от [0; 6])
     * Разделов, упоминаемых в Структурах Тестов. (любых Тем и любых Типов)
     */
    private $mean_difficulty;

    /**
     * @var int pre defined value by teacher
     * 
     * Макс. число вопросов в Тесте, заданное Пользователем при создании Теста
     * (на первом шаге).
     */
    private $max_question_number;

    /**
     * @var int number of questions in the main phase
     * 
     * Суммарное число Вопросов = сумма кол-ва Вопросов Структур
     * (кол-ва для каждой структуры задаются Пользователем)
     */
    private $main_phase_amount;

    /**
     * @var int
     * 
     * Номер следующего вопроса (после инициализации 0, затем 1, 2 и т.д.)
     */
    private $current_question_number;

    /**
     * @var int sum of difficulties of passed questions
     * 
     * При выполнении метода chooseQuestion() увеличивается на
     * Сложность Вопроса.
     */
    private $current_difficulty_sum;

    /**
     * @var QuestionClass[] student visited
     */
    private $visited_classes = [];

    /**
     * @var AdaptiveQuestionPool
     * 
     * Подзразделяется на MAIN-пул и COMMON-пул.
     * Каждый из пулов подразделяется на 5 классов по уровням сложности.
     * 
     * MAIN-пул создаётся методом generate.
     * Состоит из всех возможных Вопросов (без ограничений), соответствующих
     * Записям Структур Теста, через которые проходит поток после
     * алгоритма поиска максимального потока.
     * Т.о. не все вопросы не всех Записей там будут.
     * Т.о. там могут быть вопросы, не отобранные для Теста с помощью chosen_records.
     * 
     * COMMON-пул создаётся в конструкторе.
     * Состоит из всех возможных Вопросов (без ограничений) всех Разделов,
     * упоминаемых в Тесте (любой Темы и любого Типа).
     * 
     * Вопрос из $question_pool исключается при выполнении метода chooseQuestion().
     */
    private $question_pool;

    /**
     * @var AdaptiveRecord[] formed by Ford-Fulkerson algorithm
     * 
     * Выбранные Адаптивные Записи.
     * Адапт. Запись хранит сколько еще вопросов
     * такого вида (раздел-тема-тип) можно взять и сами Вопросы.
     */
    private $chosen_records = [];

    /**
     * @var AdaptiveQuestion[] already passed by student
     * 
     * Наполняется при выполнении метода chooseQuestion().
     */
    private $passed_questions = [];

    public function __construct($mark_expected_by_student, $id_test, $id_result) {
        $this->id_result = $id_result;
        $this->id_test = $id_test;
        $student_id = Auth::user()['id'];
        $student = User::whereId($student_id)->select('group', 'knowledge_level')->first();
        $this->student_knowledge_level = $student['knowledge_level'];
        $group_id = $student['group'];
        $this->student_expected_mark = $this->evalStudentExpectedMark($mark_expected_by_student, $student_id, $group_id);
        // Весь Пул вопросов делится на 2 категории:
        // 1. Главный пул (MAIN)
        // 2. Общий пул (COMMON)
        // Каждая из категорий подразделяется на 5 классов по уровням сложности вопросов.
        // Создаём пустой Пул вопросов.
        $this->question_pool = new AdaptiveQuestionPool();
        // Берём все Вопросы Разделов любых Типов и любых Тем, которые упоминаются в Тесте.
        // Преобразуем эти Вопросы в Адаптивные и сохраняем их в Общий Пул с подразделением на
        // классы по сложностям.
        // Ср. сложность всех этих Вопросов сохраняем в $this->mean_difficulty.
        // Ср. сложность рассчитывается не на основе значений сложностей [-3; 3],
        // а на основе [0; 6]
        $this->mean_difficulty = $this->evalMeanDifficultyAndSetCommonPool($id_test);
        // Макс. число вопросов в Тесте сохраняем в $this->max_question_number.
        $this->max_question_number = Test::whereId_test($id_test)->select('max_questions')->first()->max_questions;
        $this->current_question_number = 0;
        $this->current_difficulty_sum = 0;
        // Средний класс сложностей вопросов считаем уже посещённым.
        array_push($this->visited_classes, QuestionClass::MIDDLE);
        $this->main_phase_amount = 0;
    }

    public function generate(Test $test) {
        // Строим граф:
        // Источник -> Записи Структур Теста -> Структуры Теста -> Сток
        //          a)                       b)                 c)
        //   flow / capacity
        // a) 0 / число вопросов (соответствующих Записи)
        // b) 0 / лимит вопросов Структуры
        // c) 0 / лимит вопросов Структуры
        $graph = GraphBuilder::buildGraphFromTest($test);
        // Находим максимальный поток
        $graph->fordFulkersonMaxFlow();
        // $graph->randomMaxFlow();
        Log::Debug('');
        Log::Debug('Создан граф теста:');
        Log::Debug('');
        Log::Debug('Раздел/Тема/Тип');
        Log::Debug('? - это исток или сток');
        Log::Debug('поток / capacity');
        Log::Debug('');
        $graph->display();

        // Если flow !== capacity хотя бы в одном из (c), то Выходим.
        // то есть общее число Доступных вопросов по каждой из Записей
        // должно быть выше или равно лимиту, заданному для Структуры.
        if (!$graph->isSaturated())
            throw new TestGenerationException("Test has unacceptable structure!");

        // Для каждой Вершины-Записи...
        foreach ($graph->getSource()->getNextNodes() as $record) {
            // Общий поток из Вершины-Записи в Вершины-Структуры
            // заносим в amount.
            // Запись может быть повторена для разных Структур.
            /*
            Пример графа, где Запись 1/1/1 используется в Структурах 438 и 439
            (но случилось, что поток через них не прошёл):
            [2024-04-26 15:21:18] local.DEBUG: ? -> 1/1/1: 0 / 3  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 1/2/1: 3 / 3  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 1/3/1: 0 / 2  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 1/1/2: 4 / 5  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 1/2/2: 0 / 0  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 1/3/2: 0 / 0  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 2/11/1: 3 / 4  
            [2024-04-26 15:21:18] local.DEBUG: ? -> 2/12/1: 6 / 6  
            [2024-04-26 15:21:18] local.DEBUG: 438(7) -> ?: 7 / 7  
            [2024-04-26 15:21:18] local.DEBUG: 439(9) -> ?: 9 / 9  
            [2024-04-26 15:21:18] local.DEBUG: 1/1/1 -> 438(7): 0 / 7  !!!
            [2024-04-26 15:21:18] local.DEBUG: 1/2/1 -> 438(7): 3 / 7  
            [2024-04-26 15:21:18] local.DEBUG: 1/3/1 -> 438(7): 0 / 7  
            [2024-04-26 15:21:18] local.DEBUG: 1/1/2 -> 438(7): 4 / 7  
            [2024-04-26 15:21:18] local.DEBUG: 1/2/2 -> 438(7): 0 / 7  
            [2024-04-26 15:21:18] local.DEBUG: 1/3/2 -> 438(7): 0 / 7  
            [2024-04-26 15:21:18] local.DEBUG: 1/1/1 -> 439(9): 0 / 9  !!!
            [2024-04-26 15:21:18] local.DEBUG: 2/11/1 -> 439(9): 3 / 9  
            [2024-04-26 15:21:18] local.DEBUG: 2/12/1 -> 439(9): 6 / 9  
            */

            /*
            Для графа:
            [2024-04-26 15:03:27] local.DEBUG: ? -> 1/1/1: 3 / 3  
            [2024-04-26 15:03:27] local.DEBUG: ? -> 1/2/1: 0 / 3  
            [2024-04-26 15:03:27] local.DEBUG: ? -> 1/3/1: 0 / 2  
            [2024-04-26 15:03:27] local.DEBUG: ? -> 1/1/2: 4 / 5  
            [2024-04-26 15:03:27] local.DEBUG: ? -> 1/2/2: 0 / 0  
            [2024-04-26 15:03:27] local.DEBUG: ? -> 1/3/2: 0 / 0  
            [2024-04-26 15:03:27] local.DEBUG: 437(7) -> ?: 7 / 7  
            [2024-04-26 15:03:27] local.DEBUG: 1/1/1 -> 437(7): 3 / 7  !!! Отдельная итерация внешнего цикла для этого ребра
            [2024-04-26 15:03:27] local.DEBUG: 1/2/1 -> 437(7): 0 / 7  
            [2024-04-26 15:03:27] local.DEBUG: 1/3/1 -> 437(7): 0 / 7  
            [2024-04-26 15:03:27] local.DEBUG: 1/1/2 -> 437(7): 4 / 7  !!! Отдельная итерация внешнего цикла для этого ребра
            [2024-04-26 15:03:27] local.DEBUG: 1/2/2 -> 437(7): 0 / 7  
            [2024-04-26 15:03:27] local.DEBUG: 1/3/2 -> 437(7): 0 / 7  
            */

            // На итерации для "1/1/1" amount будет равно 3 (берётся из помеченной !!! строки).
            // Для Данного Графа нет такой же Записи ("1/1/1") в других Структурах,
            // т.к. Структура только одна.
            //
            // На итерации для "1/1/2" amount будет равно 4 (берётся из помеченной !!! строки).
            // На остальных amount будет равно 0.

            // $amount = сколько Вопросов в Тесте должно быть
            // по Разделу, Теме, Типу Записи $record.
            $amount = 0;
            foreach ($record->getNextNodes() as $struct_node) {
                $amount += $graph->getEdge($record, $struct_node)->getFlow();
            }

            // При суммировании всех составляющих в main_phase_amount получим Лимит,
            // заданный для всех Структур Теста, т.е. Общее Число Вопросов в Тесте.
            // То Число Вопросов, которое фактически должно быть в Тесте.
            $this->main_phase_amount += $amount;

            // Если для данной Записи можно выбрать Вопросы, то...
            if ($amount > 0) {
                // Берём все Вопросы по теме и нужного типа
                $questions = Question::whereSection_code($record->section_code)
                    ->whereTheme_code($record->theme_code)
                    ->whereType_code($record->type_code)
                    ->select('id_question', 'pass_time', 'difficulty', 'discriminant', 'guess')
                    ->get();
                // Создаем адаптивную Запись.
                // Она хранит, сколько еще Вопросов можно выдать.
                // А также все Вопросы нужного вида (Раздел-Тема-Тип), из которых выбирать.
                $adaptive_record = new AdaptiveRecord($record, $amount, $questions);

                // Все Адаптивные Записи, из которых нужно выбирать Вопросы.
                array_push($this->chosen_records, $adaptive_record);

                foreach ($questions as $question) {
                    // Каждый Вопрос из всех абсолютно такого вида (Раздел-Тема-Тип)
                    // добавляется в MAIN pool
                    $adaptive_question = new AdaptiveQuestion($question, $this->student_knowledge_level);
                    $this->question_pool->addQuestionToMainPhasePool($adaptive_question);
                }
            }
        }
    }

    public function chooseQuestion() {
        Log::Debug("Выбираем вопрос из пула:");
        Log::Debug('');
        $this->logLines($this->question_pool->questionsCountToString());

        $this->current_question_number++;
        $phase = $this->getCurrentPhase();

        Log::Debug("Текущая фаза: " . ($phase == Phase::MAIN ? "Главная" : "Экстра"));

        if ($phase == Phase::MAIN) {
            if ($this->current_question_number >= $this->max_question_number) {
                throw new TestGenerationException("Invalid test state: " +
                    "main phase contains more questions than test limit");
            }
        } else {
            if ($this->isReadyToFinish()) {
                return -1;
            }
        }

        // На основе очков за ответ на последний вопрос
        // выбирается класс сложности (выше на 1, такой же что у пред. вопроса,
        // ниже на 1).
        // 
        // Для выбранного класса пытаемся достать вопросы из пула и вернуть их.
        // 
        // Но если таких вопросов нет, то рассматриваем из ближайших классов.
        // 
        // Если и таких нет, то рассматриваем в том числе
        // среди классов бОльшей отдалённости.
        $possible_questions = $this->getPossibleQuestions($phase);
        $possible_questions_count = count($possible_questions);

        if ($possible_questions_count == 0) {
            Log::Debug("Нет возможных вопросов для выбора!");
            if ($phase == Phase::MAIN) {
                throw new TestGenerationException("Can't find question in main phase!");
            }
            return -1;
        }

        // Выбираем случайный вопрос из возможных и сохраняем
        // в $chosen_question.
        $rand_question_index = rand(0, $possible_questions_count - 1);
        $chosen_question = $possible_questions[$rand_question_index];

        Log::Debug("Выбранный вопрос ID: " . $chosen_question->getId());
        $this->logLines("Адаптивные данные: " . $chosen_question);
        $question = Question::whereIdQuestion($chosen_question->getId())->first();
        if ($question) {
            Log::Debug('Текст вопроса: ' . $question->text);
            Log::Debug('Тема/Тип: ' . $question->theme_code . '/' . $question->type_code);
            Log::Debug("Правильный ответ: " . $question->answer);
        } else {
            Log::Debug('Вопрос не найден в БД');
        }

        // Увеличить current_difficulty_sum на сложность выбранного Вопроса.
        // Добавить Класс Сложности выбранного вопроса в visited classes.
        //
        // Перенести выбранный Вопрос из question_pool в passed_questions.
        $this->setStateAfterChooseQuestion($chosen_question, $phase);

        Log::Debug('Выбранный вопрос убран из пула:');
        Log::Debug('');
        $this->logLines($this->question_pool->questionsCountToString());

        Log::Debug('');
        Log::Debug('Пройденные вопросы:');
        foreach ($this->passed_questions as $passed_question) {
            Log::Debug("ID вопроса: " . $passed_question->getId());
            Log::Debug("Сложность: " . $passed_question->getDifficulty());
            Log::Debug("Класс сложности: " . QuestionClass::getClassName($passed_question->getClass()));
            Log::Debug("Время прохождения: " . $passed_question->getPassTime() . " секунд");
            Log::Debug("Фактор верности ответа: " . $passed_question->getRightFactor());
            Log::Debug("Время окончания: " . date('Y-m-d H:i:s', $passed_question->getEndTime()));
            Log::Debug('---');
        }

        if ($phase == Phase::MAIN) {
            // Исключить из каждой chosen_records id вопроса
            // $chosen_question, если есть в (Адаптивной) Записи.
            // А также, если есть в Записи, то уменьшить число
            // оставшихся в Записи Вопросов на 1.
            // Если Запись оказалась пустой, то исключить
            // Вопрос из question_pool.
            $this->handleGraphRecordsAfterChooseQuestion($chosen_question, $phase);
        }

        Log::Debug('Адаптивные записи:');
        foreach ($this->chosen_records as $record) {
            if ($record->isEmpty()) {
                Log::Debug("Запись пуста. ID вопросов были удалены из пула: " . implode(", ", $record->getQuestionIds()));
            } else {
                $this->logLines($record);
            }
        }

        Log::Debug('Состояние пула вопросов после изменений:');
        $this->logLines($this->question_pool->questionsCountToString());


        // Задаём время, до которого Вопрос
        // должен быть решён. (сейчас + question.pass_time).
        // question.pass_time - за какое время Вопрос должен быть решён
        $chosen_question->setEndTime();

        // Возвращаем ID выбранного Вопроса.
        return $chosen_question->getId();
    }

    public function setEndTimeForChosenQuestion($end_time) {
        end($this->passed_questions)->setEndTime($end_time);
    }

    public function setRightFactorAfterCheck($right_factor) {
        end($this->passed_questions)->setRightFactor($right_factor);
    }

    public function getCurrentQuestionNumber() {
        return $this->current_question_number;
    }

    public function getIdResult() {
        return $this->id_result;
    }

    public function getCurrentQuestionEndTime() {
        return end($this->passed_questions)->getEndTime();
    }

    public function getCurrentQuestionId() {
        return end($this->passed_questions)->getId();
    }

    private function evalStudentExpectedMark($mark_expected_by_student, $student_id, $group_id) {
        $mark_expected_by_system = $this->evalExpectedBySystemMark($student_id, $group_id);
        if ($mark_expected_by_student == 'Нет') return $mark_expected_by_system;
        return Weights::MARK_EXPECTED_BY_STUDENT_FACTOR * $mark_expected_by_student +
               Weights::MARK_EXPECTED_BY_SYSTEM_FACTOR * $mark_expected_by_system;
    }

    private function evalExpectedBySystemMark($id_student, $group_id) {
        $remote_activity = $this->evalRemoteActivity($id_student);
        $classroom_activity = $this->evalClassroomActivity($id_student, $group_id);
        return min(max(0, $remote_activity + $classroom_activity), 1);
    }

    private function evalRemoteActivity($id_student) {
        // TODO: for section test we need tale t account only this section trained tests ?
        $results = Result::whereId($id_student)
            ->join('tests', 'results.id_test', '=', 'tests.id_test')
            ->where("tests,test_type", '=', 'Тренировочный')
            ->select('results.result as result', 'tests.total as total')
            ->orderBy('results.id_result');
        $remote_activity = 0;
        $counter = 0;
        $results_size = sizeof($results);
        if ($results_size == 0) return 0;
        $interval_length = $this->evalIntervalLength($results_size);
        $first_factor = $this->evalFirstFactor($results_size, $interval_length);
        foreach ($results as $result) {
            $normalized_result = $result['result'] / $result['total'];
            $test_factor = $this->evalTrainTestFactor($first_factor, $interval_length, ++$counter);
            $remote_activity += $normalized_result * $test_factor;
        }
        return $remote_activity;
    }

    private function evalIntervalLength($results_size) {
        $index_sum = 0;
        if ($results_size == 1) return Weights::MAX_TRAIN_TEST_INTERVAL_LENGTH;
        for ($i = 1; $i <= $results_size - 1; $i++) {
            $index_sum += $i;
        }
        return min(1 / $index_sum, Weights::MAX_TRAIN_TEST_INTERVAL_LENGTH);
    }

    private function evalFirstFactor($results_size, $interval_length) {
        $index_sum = 0;
        for ($i = 1; $i <= $results_size - 1; $i++) {
            $index_sum += $i;
        }
        return (1 - $interval_length * $index_sum) / $results_size;
    }

    private function evalTrainTestFactor($first_factor, $interval_length, $test_order) {
        return $first_factor + ($test_order - 1) * $interval_length;
    }

    private function evalClassroomActivity($id_student, $group_id) {
        return $this->evalLecturesActivity($id_student, $group_id) + $this->evalSeminarsActivity($id_student, $group_id);
    }

    private function evalLecturesActivity($id_student, $group_id) {
        $lectures_group_attendance = Lectures::whereGroup($group_id)->get();
        $lectures_student_attendance = Lectures::whereUserid($id_student)->first();
        $attendance_percentage = $this->getAttendancePercentage($lectures_group_attendance, $lectures_student_attendance);
        if ($attendance_percentage > 0.8) return 0.05 * ($attendance_percentage + 1);
        if ($attendance_percentage >= 0.5) return $attendance_percentage / 3 - 2.4;
        return -0.1;
    }

    private function evalSeminarsActivity($id_student, $group_id) {
        return $this->evalSeminarsAttendanceActivity($id_student, $group_id) + $this->evalSeminarsWorkActivity($id_student, $group_id);
    }

    private function evalSeminarsAttendanceActivity($id_student, $group_id) {
        $seminars_group_attendance = Seminars::whereGroup($group_id)->get();
        $seminars_student_attendance = Seminars::whereUserid($id_student)->first();
        $attendance_percentage = $this->getAttendancePercentage($seminars_group_attendance, $seminars_student_attendance);
        if ($attendance_percentage >= 0.6) return 0.5 * ($attendance_percentage -1);
        return -0.2;
    }

    private function evalSeminarsWorkActivity($id_student, $group_id) {
        $seminars_group_attendance = Seminars::whereGroup($group_id)->get();
        $seminars_student_work = Classwork::whereUserid($id_student)->first();
        $work_percentage = $this->getAttendancePercentage($seminars_group_attendance, $seminars_student_work);
        return 0.2 * $work_percentage;
    }

    private function getAttendancePercentage($group_attendance, $student_attendance) {
        $column_name_prefix = 'col';
        $carried = 0;
        $visited = 0;
        for ($i = 1; $i <= 16; $i++) {
            $column_name = $column_name_prefix . $i;
            $is_carried = false;
            foreach ($group_attendance as $student) {
                if ((int)$student[$column_name] > 0) {
                    $is_carried = true;
                }
            }
            if ($is_carried) {
                $carried++;
                if ((int)$student_attendance[$column_name] > 0) $visited++;
            }
        }
        if ($carried == 0) return 1;
        return $visited / $carried;
    }

    private function evalMeanDifficultyAndSetCommonPool($id_test) {
        // Одна Структура может содержать множество Записей (Запись = ТемаРаздела+ТипВопроса)
        // Загрузить записи всех Структур Теста.
        // Из них берём все Разделы.
        $sections = StructuralRecord::whereId_test($id_test)->select('section_code')->distinct()->get();
        $difficult_sum = 0;
        $questions_counter = 0;
        // Массив адаптивных вопросов из Разделов, указанных в Структурах Теста
        $common_questions_pool = [];
        // Для каждого Раздела (Раздел подразделяется по Темам.)
        foreach ($sections as $section) {
            // Получаем все Вопросы Раздела любого типа,
            // не являющиеся только для печати.
            $questions = Question::whereSection_code($section['section_code'])
                ->join('types', 'questions.type_code', '=', 'types.type_code')
                ->where('types.only_for_print', '=', '0')
                ->select('id_question', 'pass_time', 'difficulty', 'discriminant', 'guess')->get();
            // Для каждого Вопроса
            foreach ($questions as $question) {
                $questions_counter++;
                // Т.к. сложности вопросов в общем случае варьируются от -3 до 3
                // Суммируем смещённые на 3 сложности для получения средней сложности.
                $difficult_sum += $question['difficulty'] + 3;
                // преобразуем каждый вопрос в Адаптивный вопрос.
                $adaptive_question = new AdaptiveQuestion($question, $this->student_knowledge_level);
                array_push($common_questions_pool, $adaptive_question);
            }
        }
        // Сохраняем все Адаптивные вопросы в Общий пул (с подразделением на 5 классов сложностей).
        $this->question_pool->setCommonPool($common_questions_pool);
        return $difficult_sum / $questions_counter;
    }

    private function getCurrentExpectedPointsSum() {
        return $this->mean_difficulty * $this->current_question_number;
    }

    private function getCurrentTrajectoryDistance() {
        return $this->current_difficulty_sum - $this->getCurrentExpectedPointsSum();
    }

    private function isReadyToFinish() {
        if ($this->getCurrentPhase() == Phase::MAIN) return false;
        if ($this->current_question_number >= $this->max_question_number) return true;
        $trajectory_finish_factor = $this->evalTrajectoryFinishFactor();
        $knowledge_finish_factor = $this->evalKnowledgeFinishFactor();
        $probability_to_finish = min(max(0, $trajectory_finish_factor + $knowledge_finish_factor), 1);
        $rand_num = rand(0, 100);
        return $rand_num <= $probability_to_finish * 100;
    }

    // Возвращает 0, 0.2, 0.5 или 1.0.
    // 0 - если последний 1-2 вопроса варьировались по классу
    //  сложности на 2.
    // 0.2 - если последние 3 вопроса варьировались по кл.сл на 2.
    // 0.5 - если последние 4
    // 1.0 - если последние 5+ вопросов варьир. по кл. сл. на 2.
    private function evalTrajectoryFinishFactor() {
        $number_of_steps_in_two_classes = 1;
        $max_class = end($this->visited_classes);
        $min_class = $max_class;
        // Находим сколько последних вопросов нужно взять,
        // чтобы разница в классе сложностей в этих вопросах была
        // 2 или более.
        // Например:
        // Классы сложностей выбранных вопросов: 1 (первый), 2, 5, 4, 4, 3 (последний).
        // Берём 1 последних: 3 -> min=3,max=3. 3-3=0  < 2
        // Берём 2 последних: 3 -> min=3,max=4. 4-3=1  < 2
        // Берём 3 последних: 3 -> min=3,max=4. 4-3=1  < 2
        // Берём 4 последних: 3 -> min=3,max=5. 5-3=2  >= 2!
        // Значит $number_of_steps_in_two_classes === 4!
        // При этом значение выше 5 быть не может.
        //
        // Выходит, что если класс сложности выбранных вопросов
        // долго не менялся (т.е. устоялся),
        // $number_of_steps_in_two_classes будет большим.
        //
        // Если классы новых вопросов не стабильны,
        // то $number_of_steps_in_two_classes будет маленьким числом.
        while($max_class - $min_class < 2 && $number_of_steps_in_two_classes < 5) {
            $number_of_steps_in_two_classes++;
            $current_class = prev($this->visited_classes);
            if ($current_class == false) break;
            if ($current_class > $max_class) $max_class = $current_class;
            if ($current_class < $min_class) $min_class = $current_class;
        }
        // $number_of_steps_in_two_classes -> finish factor
        // 1: 0.0
        // 2: 0.0
        // 3: 0.2
        // 4: 0.5
        // 5: 1.0 (долго не менялся -> финишируем)
        return FinishCriteria::getClassFinishFactor($number_of_steps_in_two_classes);
    }

    private function evalKnowledgeFinishFactor() {
        $expected_level = KnowledgeLevel::getKnowledgeLevelFromMark($this->student_expected_mark)->getLevel();
        $current_level = KnowledgeLevel::getKnowledgeLevelFromPoints($this->getCurrentPoints())->getLevel();
        return FinishCriteria::getKnowledgeFinishFactor(abs($expected_level - $current_level));
    }

    private function getCurrentPoints() {
        $current_clean_mark = $this->getCurrentCleanMark();
        $trajectory_distance = $this->getCurrentTrajectoryDistance();
        $normalized_mark = ($current_clean_mark + $trajectory_distance) / $this->current_difficulty_sum;
        return min(max(0, $normalized_mark), 1);
    }

    private function getCurrentCleanMark() {
        $points_sum = 0;
        foreach ($this->passed_questions as $question) {
            $points_sum += $question->getDifficulty() * $question->getRightFactor();
        }
        return $points_sum;
    }

    private function getCurrentPhase() {
        if ($this->current_question_number <= $this->main_phase_amount) return Phase::MAIN;
        else return Phase::EXTRA;
    }

    // Для Первого вопроса возвращает MIDDLE.
    // Для Второго и далее вопросов возвращает
    // Класс ниже на 1, равный или выше на 1 чем Класс последнего отвеченного
    // вопроса в зависимости от полученных очков за ответ (0; 0.6; 0.8; 1).
    // Хорошо ответил на пред. вопрос -> возвращаем класс сложности сложнее.
    // Плохо -> проще.
    private function getCurrentClass() {
        // Для первого Вопроса выбираем Средний класс Сложности.
        if ($this->current_question_number == 1) {
            return QuestionClass::MIDDLE;
        }

        // Последний Класс сложности в visited_classes
        $prev_class = end($this->visited_classes);

        // Последний пройденный Вопрос (Он будет, т.к. сюда попадаем,
        // только если хотя бы 1 Вопрос был решён)
        $last_passed_question = end($this->passed_questions);

        // rightFactor (Фактор Верности)
        // последнего пройденного Вопроса (задаётся, когда
        // пользователь ответит на Вопрос)
        $points_for_prev_question = $last_passed_question->getRightFactor();

        Log::Debug("Очков за пред. ответ: " . $points_for_prev_question);

        // Определить Класс сложности Текущего вопроса на основе
        // Класса сложности и Очков (набранных) для Предыдущего вопроса.
        return QuestionClass::getNextClass($prev_class, $points_for_prev_question);
    }

    /**
     * @return AdaptiveQuestion[]
     * 
     * На основе очков за ответ на последний вопрос
     * выбирается класс сложности (выше на 1, такой же что у пред. вопроса,
     * ниже на 1).
     * 
     * Для выбранного класса пытаемся достать вопросы из пула и вернуть их.
     * 
     * Но если таких вопросов нет, то рассматриваем из ближайших классов.
     * 
     * Если и таких нет, то рассматриваем в том числе
     * среди классов бОльшей отдалённости.
     */
    private function getPossibleQuestions($phase) {
        // Для Первого вопроса возвращает MIDDLE.
        // Для Второго и далее вопросов возвращает
        // Класс ниже на 1, равный или выше на 1 чем Класс последнего отвеченного
        // вопроса в зависимости от полученных очков за ответ (0; 0.6; 0.8; 1).
        // Хорошо ответил на пред. вопрос -> возвращаем класс сложности сложнее.
        // Плохо -> проще.
        $class = $this->getCurrentClass();
        Log::Debug("Выбранный класс сложности: " . QuestionClass::getClassName($class));

        $possible_questions_count = 0;
        $try = 0;
        $classes_questions = [];

        // Пробуем вначале достать из question_pool
        // в $classes_questions
        // Вопросы Класса сложности $class.
        //
        // Если таких нет, то очень близких к $class.
        //
        // Если и таких нет, то не столь уже близких к $class.
        while ($possible_questions_count == 0  && $try < 3) {
            // Здесь будут все допустимые вопросы из пула
            // Классов сложностей, близких Классу сложности
            // $class (т.е. требуемому).
            $classes_questions = [];
            $try++;

            // Получаем близкие к $class Классы сложностей.
            // Чем выше $try, тем больше различных классов сложностей,
            // близких к $class мы получаем.
            // Конкретика в комментах к функции getNearsetClasses().
            $classes_for_choose = QuestionClass::getNearestClasses($class, $try);

            // Для каждого Класса сложностей из близких к классу последнего вопроса
            foreach ($classes_for_choose as $class_for_choose) {
                $questions_in_class = $this->getPhasePool($phase)[$class_for_choose];
                if (count($questions_in_class) != 0) {
                    $classes_questions = array_merge($classes_questions, $questions_in_class);
                }
            }
            $possible_questions_count = count($classes_questions);
        }
        if ($possible_questions_count == 0) {
            $classes_questions = [];
        }
        Log::Debug("Выбранные классы сложности для вопросов:");
        foreach ($classes_for_choose as $class_for_choose) {
            Log::Debug(QuestionClass::getClassName($class_for_choose));
        }

        Log::Debug("ID и классы сложности выбранных вопросов:");
        $logMessages = [];
        foreach ($classes_questions as $question) {
            $logMessages[] = $question->getId() . " (" . QuestionClass::getClassName($question->getClass()) . ")";
        }
        Log::Debug(implode(", ", $logMessages));
        return $classes_questions;
    }

    private function getPhasePool($phase) {
        if ($phase == Phase::MAIN) {
            return $this->question_pool->getMainPhasePool();
        }
        return $this->question_pool->getCommonPool();
    }

    private function setStateAfterChooseQuestion(AdaptiveQuestion $chosen_question, $phase) {
        $this->current_difficulty_sum += $chosen_question->getDifficulty();
        array_push($this->visited_classes, $chosen_question->getClass());

        $this->question_pool->remove($chosen_question->getId(), $phase);
        array_push($this->passed_questions, $chosen_question);
    }

    private function handleGraphRecordsAfterChooseQuestion(AdaptiveQuestion $chosen_question, $phase) {
        foreach ($this->chosen_records as $record) {
            if ($record->remove($chosen_question->getId())) {
                $record->decreaseAmount();
                if ($record->isEmpty()) {
                    foreach ($record->getQuestionIds() as $id) {
                        $this->question_pool->remove($id, $phase);
                    }
                }
            }
        }
    }

    private function logLines($str) {
        $lines = explode("\n", $str);
        foreach ($lines as $line) {
            Log::Debug($line);
        }
    }
}

