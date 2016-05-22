<?php
namespace App\Http\Controllers;
use App\Classwork;
use App\Control_test_dictionary;
use App\Controls;
use App\Lectures;
use App\Testing\Result;
use App\Seminars;
use App\Testing\Test;
use App\Testing\Theme;
use App\Totalresults;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Testing\Question;
use App\Testing\Codificator;
use PDOStatement;
use  PDO;
use Session;

class PersonalAccount extends Controller{
    private $test;
    function __construct(Test $test){
        $this->test=$test;
    }

    public function showPA(){   //показывает личный кабинет, вкладку со статистикой
        $tests = [];
        $names = [];
        $query = $this->test->select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                array_push($tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($names, $test->test_name);                                                            //самого названия теста
            }
        }
        $amount = count($tests);
        $user = Auth::user();
        $results = Result::whereId($user['id'])->get();
        return view('personal_account/personal_account', compact('results', 'amount', 'tests', 'names'));
    }


    public function showTeacherPA(){   //показывает личный кабинет, вкладку со статистикой
        $tests = [];
        $names = [];
        $last_names = [];
        $first_names = [];
        $groups = [];
        $test_names = [];
        $result_dates = [];
        $results = [];
        $marks = [];
        $query = $this->test->select('id_test', 'test_course', 'test_name', 'start', 'end', 'test_type')->get();
        foreach ($query as $test){
            if ($test->test_course != 'Рыбина'){                    //проверка, что тест открыт и он не из Рыбинских
                array_push($tests, $test->id_test);                                                              //название тренировочного теста состоит из слова "Тренировочный" и
                array_push($names, $test->test_name);                                                            //самого названия теста
            }
        }
        $amount = count($tests);
        $c = 0;
        $resultsQuery = Result::select('id_user', 'test_name', 'result_date', 'result', 'mark_eu')->get();
        foreach ($resultsQuery as $res){
            $user = User::whereId($res->id_user)->get();
//            $c = $c + count($user);
            if(count($user) != 0) {
                array_push($last_names, $user[0]->last_name);
                array_push($first_names, $user[0]->first_name);
                array_push($groups, $user[0]->group);
            }
            else {
                array_push($last_names, 'УДАЛЕН');
                array_push($first_names, 'УДАЛЕН');
                array_push($groups, '-1');
            }
            array_push($test_names, $res->test_name);
            array_push($result_dates, $res->result_date);
            array_push($results, $res->result);
            array_push($marks, $res->mark_eu);
        }
        return view('personal_account/teacher_account', compact('results', 'last_names', 'first_names', 'groups', 'test_names', 'result_dates', 'marks', 'amount', 'tests', 'names'));
    }

    public function verify(){
        $query = User::whereRole("")->get();
        return view('personal_account/verify_students', compact('query'));
    }

//Данные методы меняют роль выбранного юзера
    public function add_student(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        $user->role = 'Студент';
        $user->save();

        //Добавляем новую запись в ведомости по лекциям
        $lectures = new Lectures();
        $lectures->userID = $id;
        $lectures->group = $user->group;
        $lectures->save();

        //Добавляем новую запись в ведомости по лекциям
        $seminars = new Seminars();
        $seminars->userID = $id;
        $seminars->group = $user->group;
        $seminars->save();

        //Добавляем новую запись в ведомости по лекциям
        $classwork = new Classwork();
        $classwork->userID = $id;
        $classwork->group = $user->group;
        $classwork->save();

        //Добавляем новую запись в ведомости по контрольным
        $controls = new Controls();
        $controls->userID = $id;
        $controls->group = $user->group;
        $controls->save();

        //Добавляем новую запись в итоговые ведомости
        $total = new Totalresults();
        $total->userID = $id;
        $total->group = $user->group;
        $total->save();

        return $id;
    }
    public function add_admin(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        $user->role = 'Админ';
        $user->save();
        return $id;
    }
    public function add_average(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        $user->role = 'Обычный';
        $user->save();
        return $id;
    }


    //Возвращает главную страницу для выбора типа ведомости и группы
    public function statements(){
        return view('personal_account/statements');
    }

    //Возвращают представление соответствующей ведомости
    public function get_lectures(Request $request){
        $group = json_decode($request->input('group'),true);
        $statement = Lectures::whereGroup($group)->get();
        $last_names = [];
        $first_names = [];
        foreach ($statement as $state){
            $user = User::whereId($state->userID)->get();
            array_push($last_names, $user[0]->last_name);
            array_push($first_names, $user[0]->first_name);
        }
        return view('personal_account/statements/lectures', compact('statement', 'first_names', 'last_names'));
    }
    public function get_seminars(Request $request){
        $group = json_decode($request->input('group'),true);
        $statement = Seminars::whereGroup($group)->get();
        $last_names = [];
        $first_names = [];
        foreach ($statement as $state){
            $user = User::whereId($state->userID)->get();
            array_push($last_names, $user[0]->last_name);
            array_push($first_names, $user[0]->first_name);
        }
        return view('personal_account/statements/seminars', compact('statement', 'first_names', 'last_names'));
    }
    public function get_classwork(Request $request){
        $group = json_decode($request->input('group'),true);
        $statement = Classwork::whereGroup($group)->get();
        $last_names = [];
        $first_names = [];
        foreach ($statement as $state){
            $user = User::whereId($state->userID)->get();
            array_push($last_names, $user[0]->last_name);
            array_push($first_names, $user[0]->first_name);
        }
        return view('personal_account/statements/classwork', compact('statement', 'first_names', 'last_names'));
    }
    public function get_controls(Request $request){
        $group = json_decode($request->input('group'),true);
        $statement = Controls::whereGroup($group)->get();
        $last_names = [];
        $first_names = [];
        foreach ($statement as $state){
            $user = User::whereId($state->userID)->get();
            array_push($last_names, $user[0]->last_name);
            array_push($first_names, $user[0]->first_name);
        }
        return view('personal_account/statements/control', compact('statement', 'first_names', 'last_names'));
    }
    public function get_resulting(Request $request){
        $this->calc_first();
        $this->calc_second();
        $this->calc_third();
        $this->calc_fourth();
        $this->calc_term();
        $this->calc_final();
        $group = json_decode($request->input('group'),true);
        $statement =Totalresults::whereGroup($group)->get();
        $last_names = [];
        $first_names = [];
        foreach ($statement as $state){
            $user = User::whereId($state->userID)->get();
            array_push($last_names, $user[0]->last_name);
            array_push($first_names, $user[0]->first_name);
        }
        return view('personal_account/statements/results', compact('statement', 'first_names', 'last_names'));
    }


    //Отмечает или раз-отмечает студента на лекции
    public function lecture_was(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $lecture = Lectures::where('userID', $id)->update([$column => 1]);
        return 0;
    }
    public function lecture_wasnot(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $lecture = Lectures::where('userID', $id)->update([$column => 0]);
        return 0;
    }

    //Отмечает или раз-отмечает студента на семинаре
    public function seminar_was(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $lecture = Seminars::where('userID', $id)->update([$column => 1]);
        return 0;
    }
    public function seminar_wasnot(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $lecture = Seminars::where('userID', $id)->update([$column => 0]);
        return 0;
    }
    //Изменяет балл студента за работу на семинаре
    public function classwork_change(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $value = $request->input('value');
        $lecture = Classwork::where('userID', $id)->update([$column => $value]);
        return 0;
    }

    //Изменяет балл студента за контрольную работу
    public function controls_change(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $value = $request->input('value');
        $lecture = Controls::where('userID', $id)->update([$column => $value]);
        return 0;
    }

    //Изменяет балл студента в итоговой ведомости
    public function resulting_change(Request $request){
        $id = json_decode($request->input('id'),true);
        $column = $request->input('column');
        $value = $request->input('value');
        $lecture = Totalresults::where('userID', $id)->update([$column => $value]);
        return 0;
    }

    //метод, подсчитывающий итоги за первый раздел
    //1 раздел = КР1 + КР2 + Тест1Авт + Тест1Письм + 7 недель(каждый тип кроме работы в классе делится на 7)
    public function calc_first(){
        $results = Totalresults::all();
        $id = 0;
        $k_lec = 7;
        $k_sem = 7;
        $max_score = 22;
        foreach ($results as $result){
            $score = 0;
            $id = $result['userID'];
            $control = Controls::where('userID', $id)->first();
            $lecture = Lectures::where('userID', $id)->first();
            $seminar = Seminars::where('userID', $id)->first();
            $classwork = Classwork::where('userID', $id)->first();
            $score += $control['control1'] + $control['control2'] + $control['test1'] + $control['test1quiz'];
            $score += ($lecture['col1'] + $lecture['col2'] + $lecture['col3'] + $lecture['col4'] + $lecture['col5'] + $lecture['col6'] + $lecture['col7']) / $k_lec;
            $score += $classwork['col1'] + $classwork['col2'] + $classwork['col3'] + $classwork['col4'] + $classwork['col5'] + $classwork['col6'] + $classwork['col7'];
            $score += ($seminar['col1'] + $seminar['col2'] + $seminar['col3'] + $seminar['col4'] + $seminar['col5'] + $seminar['col6'] + $seminar['col7']) / $k_sem;
            if ($score > $max_score) $score = $max_score;
            $res = Totalresults::where('userID', $id)->update(['section1' => round($score)]);
        }
        return 0;
    }
    //метод, подсчитывающий итоги за второй раздел
    //2 раздел = Тест2Авт + Тест2Письм + 4 недели(каждый тип кроме работы в классе делится на 4)
    public function calc_second(){
        $results = Totalresults::all();
        $id = 0;
        $k_lec = 4;
        $k_sem = 4;
        $max_score = 12;
        foreach ($results as $result){
            $score = 0;
            $id = $result['userID'];
            $control = Controls::where('userID', $id)->first();
            $lecture = Lectures::where('userID', $id)->first();
            $seminar = Seminars::where('userID', $id)->first();
            $classwork = Classwork::where('userID', $id)->first();
            $score += $control['test2'] + $control['test2quiz'];
            $score += ($lecture['col8'] + $lecture['col9'] + $lecture['col10'] + $lecture['col11']) / $k_lec;
            $score += $classwork['col8'] + $classwork['col9'] + $classwork['col10'] + $classwork['col11'];
            $score += ($seminar['col8'] + $seminar['col9'] + $seminar['col10'] + $seminar['col11']) / $k_sem;
            if ($score > $max_score) $score = $max_score;
            $res = Totalresults::where('userID', $id)->update(['section2' => round($score)]);
        }
        return 0;
    }
    //метод, подсчитывающий итоги за третий раздел
    //3 раздел = КР3Эмуляторы + КР3Письм + Тест3Авт + Тест3Письм + 4 недели(каждый тип кроме работы в классе делится на 4)
    public function calc_third(){
        $results = Totalresults::all();
        $id = 0;
        $k_lec = 4;
        $k_sem = 4;
        $max_score = 16;
        foreach ($results as $result){
            $score = 0;
            $id = $result['userID'];
            $control = Controls::where('userID', $id)->first();
            $lecture = Lectures::where('userID', $id)->first();
            $seminar = Seminars::where('userID', $id)->first();
            $classwork = Classwork::where('userID', $id)->first();
            $score += $control['control3'] + $control['control3quiz'] + $control['test3'] + $control['test3quiz'];
            $score += ($lecture['col12'] + $lecture['col13'] + $lecture['col14'] + $lecture['col15']) / $k_lec;
            $score += $classwork['col12'] + $classwork['col13'] + $classwork['col14'] + $classwork['col15'];
            $score += ($seminar['col12'] + $seminar['col13'] + $seminar['col14'] + $seminar['col15']) / $k_sem;
            if ($score > $max_score) $score = $max_score;
            $res = Totalresults::where('userID', $id)->update(['section3' => round($score)]);
        }
        return 0;
    }
    //метод, подсчитывающий итоги за четвертый раздел
    //4 раздел = Опрос + 1 неделя
    public function calc_fourth(){
        $results = Totalresults::all();
        $id = 0;
        $max_score = 10;
        foreach ($results as $result){
            $score = 0;
            $id = $result['userID'];
            $control = Controls::where('userID', $id)->first();
            $lecture = Lectures::where('userID', $id)->first();
            $seminar = Seminars::where('userID', $id)->first();
            $classwork = Classwork::where('userID', $id)->first();
            $score += $control['lastquiz'];
            $score += $lecture['col16'];
            $score += $classwork['col16'];
            $score += $seminar['col16'];
            if ($score > $max_score) $score = $max_score;
            $res = Totalresults::where('userID', $id)->update(['section4' => round($score)]);
        }
        return 0;
    }
    //метод, подсчитывающий итоги работу в семестре
    //Итог за семестр = разде1 + раздел2 + раздел3 + раздел4
    public function calc_term(){
        $results = Totalresults::all();
        $max_score = 60;
        foreach ($results as $result){
            $score = 0;
            $id = $result['userID'];
            $score += $result['section1'] + $result['section2'] + $result['section3'] + $result['section4'];
            if ($score > $max_score) $score = $max_score;
            $res = Totalresults::where('userID', $id)->update(['termResult' => round($score)]);
        }
        return 0;
    }
    //метод, подсчитывающий итоги за весь раздел
    //Итог  = ИтогЗаСеместр + Экзамен
    public function calc_final(){
        $results = Totalresults::all();
        $max_score = 100;
        foreach ($results as $result){
            $score = 0;
            $id = $result['userID'];
            $score += $result['termResult'] + $result['exam'];
            if ($score > $max_score) $score = $max_score;
            $markRU = $this->calcMarkRus(100, $score);
            $markEU = $this->calcMarkBologna(100, $score);
            $res = Totalresults::where('userID', $id)->update(['finalResult' => round($score), 'markRU' => $markRU, 'markEU' => $markEU]);
        }
        return 0;
    }


    // вычисляет оценку по Болонской системе, если дан максимально возможный балл и реальный */
    private function calcMarkBologna($max, $real){
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

    // вычисляет оценку по обычной 5-тибалльной шкале, если дан максимально возможный балл и реальный */
    private function calcMarkRus($max, $real){
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


    //метод, проверяющий, является ли тест одним из контрольных. В случаи если является, добавляет его результат в ведомость.
    public function add_to_statements($id_test, $id_user, $score){
        $dictionary = Control_test_dictionary::where('id', 1)->first();
        if($id_test == $dictionary['test1']){
            $results = Controls::where('userID', $id_user)->update(['test1' => $score]);
        }
        if($id_test == $dictionary['test2']){
            $results = Controls::where('userID', $id_user)->update(['test2' => $score]);
        }
        if($id_test == $dictionary['test3']){
            $results = Controls::where('userID', $id_user)->update(['test3' => $score]);
        }
        return 0;
    }


}