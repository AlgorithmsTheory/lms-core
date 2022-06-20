<?php

namespace App\Http\Controllers\Emulators;
use App\HamFees;
use App\Protocols\HAMProtocol;
use App\Protocols\MTProtocol;
use Input;
use DB;
use Request;
use App\Group;
use Auth;
use App\Controls;
use App\Emulators\KontrWork;
use App\Emulators\EmrForGroup;
use App\Http\Controllers\Controller;
use App\Testing\Question;
use App\Testing\Result;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Emulators\MT2TuringMachine;

class EmulatorController extends Controller {
    
    public function openMT(){
        return view("algorithm.MT");
    }
    
    public function openMMT(){
        return view("algorithm.MMT");
    }
    
    public function openHAM(){
        $fees = HamFees::first();
        return view("algorithm.HAM", compact('fees'));
    }

    public function magic($array) {
        return json_decode(json_encode($array), true);
    }

    private function add_to_file($file_name, $data)
    {
        $fd = fopen($file_name, 'a');
        fwrite($fd, $data);
        fclose($fd);
    }
    
    public static function MTRun($machine, $inputWord) {
        return $machine->run($inputWord);
    }

    public static function HAMRun($machine, $inputWord) {
        return $machine->run($inputWord);
    }

    public static function MTRun_($data) {
        $cmd = "/usr/local/bin/turing.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'turn_');
        $task_answ = tempnam(sys_get_temp_dir(), 'turn_answ_');
        file_put_contents($task_file, $data);
        $data = exec($cmd . " " . $task_file);
        unlink($task_file);
        unlink($task_answ);
        return $data;
    }
    
    public function MTPOST(Request $request){  // выполняет Тьюринга на данных и возвращает ответ   (ОБЫЧНОЕ ИСПОЛНЕНИЕ)
        $data = Request::input('task'); // data уже в JSON
        return EmulatorController::MTRun_($data);
    }

    public function HAMCheck(Request $request) {
        $task = Request::input('task');
        $task_id = Request::input('task_id');
        $test_id = Request::input('test_id');
        $counter = Request::input('counter');
        return $this->HAMCheckInternal($task, $task_id, $test_id, 'btnDebug', $counter);
    }

    public function HAMPOST(Request $request){ // выполняет Маркова на данных и возвращает ответ    (ОБЫЧНОЕ ИСПОЛНЕНИЕ)
        $data = Request::input('task'); // data уже в JSON
        $notice = Request::input('notice') == "true";
        $withSteps = Request::input('withSteps') === 'true';
        $data = EmulatorController::HAMRun($data);
        $result = [
            'data' => $data,
            'notice' => $notice,
        ];
        if ($notice) {
            $test_id = Request::input('test_id');
            $buttonCode = $withSteps ? 'btnSteps' : 'btnRun';
            $counter = Request::input('counter');
            $noticeResult = $this->HAMCheckInternal(null, null, $test_id, $buttonCode, $counter);
            $result['noticeResult'] = $noticeResult;
        }
        return $result;
    }

    /**
     * $task and $task_id values not used by the function if $button_code is 'btnSteps' or 'btnRun'
     *
     * @param $task
     * @param $task_id
     * @param $test_id
     * @param $button_code
     * @param $counter
     * @return array|null
     */
    private function HAMCheckInternal($task, $task_id, $test_id, $button_code, $counter) {
        $counter--;
        $current_test = Result::getCurrentResult(Auth::user()['id'], $test_id);

        if ($current_test == -1) {
            return null;
        }

        /* Get current saved test */
        $test = Result::whereId_result($current_test)->first();
        $saved_test = $test->saved_test;
        $saved_test = unserialize($saved_test);

        $arguments = $saved_test[$counter]['arguments'];
        $debug_counter = $arguments['debug_counter'];
        $run_counter = $arguments['run_counter'];
        $steps_counter = $arguments['steps_counter'];

        if ($button_code == 'btnSteps' || $button_code == 'btnRun') {
            if ($button_code == 'btnSteps') {
                $steps_counter++;
            } else if ($button_code == 'btnRun') {
                $run_counter++;
            }
            $saved_test[$counter]['arguments']['steps_counter'] = $steps_counter;
            $saved_test[$counter]['arguments']['run_counter'] = $run_counter;
            $saved_test = serialize($saved_test);
            $test->saved_test = $saved_test;
            $test->save();
            return [
                'debug_counter' => $debug_counter,
                'steps_counter' => $steps_counter,
                'run_counter' => $run_counter,
            ];
        }

        /* Modify saved data with use question->check() */
        $question = new Question();
        $should_increment_debug_counter = true;
        $result_check = $question->check([$task_id, $debug_counter, $run_counter, $steps_counter,
            $should_increment_debug_counter, $task]);
        $saved_test[$counter]['arguments']['debug_counter'] = $result_check['choice']['debug_counter'];

        /* Save new data */
        $saved_test = serialize($saved_test);
        $test->saved_test = $saved_test;
        $test->save();

        return $result_check;
    }

    public function MTCheck(Request $request) {
        $task = Request::input('task');
        $task_id = Request::input('task_id');
        $test_id = Request::input('test_id');
        $button_code = Request::input('buttonCode');
        $counter = Request::input('counter') - 1;
        $current_test = Result::getCurrentResult(Auth::user()['id'], $test_id);

        if ($current_test == -1) {
            return null;
        }

        /* Get current saved test */
        $test = Result::whereId_result($current_test)->first();
        $saved_test = $test->saved_test;
        $saved_test = unserialize($saved_test);

        $arguments = $saved_test[$counter]['arguments'];
        $debug_counter = $arguments['debug_counter'];
        $check_syntax_counter = $arguments['check_syntax_counter'];
        $run_counter = $arguments['run_counter'];

        if ($button_code == 'btnCheckSyntax' || $button_code == 'btnRun') {
            if ($button_code == 'btnCheckSyntax') {
                $check_syntax_counter++;
            } else if ($button_code == 'btnRun') {
                $run_counter++;
            }
            $saved_test[$counter]['arguments']['check_syntax_counter'] = $check_syntax_counter;
            $saved_test[$counter]['arguments']['run_counter'] = $run_counter;
            $saved_test = serialize($saved_test);
            $test->saved_test = $saved_test;
            $test->save();
            return [
                'debug_counter' => $debug_counter,
                'check_syntax_counter' => $check_syntax_counter,
                'run_counter' => $run_counter,
            ];
        }

        # $task_id = 43564 (идентификатор вопроса)
        # $debug_counter = 8 (сколько раз нажали на кнопку "Проверить работу" вплоть до сих пор
        # $task = информация о текущем вводе пользователя в эмулятор Тьюринга в следующем виде:
        #   {"rule":[{"src":"S0{∂}","dst":"{∂}{R}S0"}],"str":["∂"]}
        $question = new Question();
        $should_increment_debug_counter = true;
        $result_check = $question->check([$task_id, $debug_counter, $check_syntax_counter, $run_counter,
            $should_increment_debug_counter, $task]);
        $saved_test[$counter]['arguments']['debug_counter'] = $result_check['choice']['debug_counter'];

        /* Save new data */
        $saved_test = serialize($saved_test);
        $test->saved_test = $saved_test;
        $test->save();

        return $result_check;
    }

    public function HAM2Check(Request $request) {
        $task = Request::input('task');
        $task_id = Request::input('task_id');
        $test_id = Request::input('test_id');
        $button_code = Request::input('buttonCode');
        $counter = Request::input('counter') - 1;
        $current_test = Result::getCurrentResult(Auth::user()['id'], $test_id);

        if ($current_test == -1) {
            return null;
        }

        /* Get current saved test */
        $test = Result::whereId_result($current_test)->first();
        $saved_test = $test->saved_test;
        $saved_test = unserialize($saved_test);

        $arguments = $saved_test[$counter]['arguments'];
        $debug_counter = $arguments['debug_counter'];
        $check_syntax_counter = $arguments['check_syntax_counter'];
        $run_counter = $arguments['run_counter'];

        if ($button_code == 'btnCheckSyntax' || $button_code == 'btnRun') {
            if ($button_code == 'btnCheckSyntax') {
                $check_syntax_counter++;
            } else if ($button_code == 'btnRun') {
                $run_counter++;
            }
            $saved_test[$counter]['arguments']['check_syntax_counter'] = $check_syntax_counter;
            $saved_test[$counter]['arguments']['run_counter'] = $run_counter;
            $saved_test = serialize($saved_test);
            $test->saved_test = $saved_test;
            $test->save();
            return [
                'debug_counter' => $debug_counter,
                'check_syntax_counter' => $check_syntax_counter,
                'run_counter' => $run_counter,
            ];
        }

        # $task_id = 43564 (идентификатор вопроса)
        # $debug_counter = 8 (сколько раз нажали на кнопку "Проверить работу" вплоть до сих пор
        # $task = информация о текущем вводе пользователя в эмулятор Тьюринга в следующем виде:
        #   {"rule":[{"src":"S0{∂}","dst":"{∂}{R}S0"}],"str":["∂"]}
        $question = new Question();
        $should_increment_debug_counter = true;
        $result_check = $question->check([$task_id, $debug_counter, $check_syntax_counter, $run_counter,
            $should_increment_debug_counter, $task]);
        $saved_test[$counter]['arguments']['debug_counter'] = $result_check['choice']['debug_counter'];

        /* Save new data */
        $saved_test = serialize($saved_test);
        $test->saved_test = $saved_test;
        $test->save();

        return $result_check;
    }

    public static function MTCheckSequence($data, $test_seq) {
        $seq_true = 0;
        $seq_all = count($test_seq['input_word']);
        $total_cycle = 0;
        $data = json_decode($data, true);
        $automaton = $data['automaton'];
        $alphabet = $data['alphabet'];
        $machine = new MT2TuringMachine($automaton, $alphabet);
        for($i = 0; $i < $seq_all; $i++){
            $inputWord = $test_seq['input_word'][$i];
            $outputWord = $test_seq['output_word'][$i];
            $answer = EmulatorController::MTRun($machine, $inputWord);
            $total_cycle += $answer['cycle'];
            if(trim($answer['result']) == trim($outputWord)){
                $seq_true++;
            }
        }
        return [$seq_true, $seq_all, $total_cycle];
    }

    public static function HAMCheckSequence($data, $test_seq) {
        $seq_true = 0;
        $seq_all = count($test_seq['input_word']);
        $total_cycle = 0;
        $data = json_decode($data, true);
        $list = $data['list'];
        $alphabet = $data['alphabet'];
        $machine = new HAM2Machine($list, $alphabet);
        $lambdaSymbol = 'Λ';
        for($i = 0; $i < $seq_all; $i++){
            $inputWord = $test_seq['input_word'][$i];
            if (substr($inputWord, 0, strlen($lambdaSymbol)) === $lambdaSymbol) {
                $inputWord = mb_substr($inputWord, 1, null, 'UTF-8');
            }
            $outputWord = $test_seq['output_word'][$i];
            if (substr($outputWord, 0, strlen($lambdaSymbol)) === $lambdaSymbol) {
                $outputWord = mb_substr($outputWord, 1, null, 'UTF-8');
            }
            $answer = EmulatorController::HAMRun($machine, $inputWord);
            $total_cycle += $answer['cycle'];
            if(trim($answer['result']) == trim($outputWord)){
                $seq_true++;
            }
        }
        return [$seq_true, $seq_all, $total_cycle];
    }

    //protocol creation
    public function get_MT_protocol(Request $request){
        $user = Auth::user();
        if ($request->ajax()) {
            $protocol = new MTProtocol('MT', $user['id'], $request->input('html_text'));
            $protocol->create();
            return;
        }
    }

    public function get_HAM_protocol(Request $request){
        $user = Auth::user();
        if ($request->ajax()) {
            $protocol = new HAMProtocol('HAM', $user['id'], $request->input('html_text'));
            $protocol->create();
            return;
        }
    }
}
