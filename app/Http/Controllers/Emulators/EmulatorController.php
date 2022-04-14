<?php

namespace App\Http\Controllers\Emulators;
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
        return view("algorithm.HAM");
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
    
    public static function HAMRun($data) {
        $cmd = "/usr/local/bin/normal.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'norm_'); 
        $task_answ = tempnam(sys_get_temp_dir(), 'norm_answ_');
        file_put_contents($task_file, $data);
        $data = exec($cmd . " " . $task_file);
        unlink($task_file);
        unlink($task_answ);
        return $data;
    }
    
    public function MTPOST(Request $request){  // выполняет Тьюринга на данных и возвращает ответ   (ОБЫЧНОЕ ИСПОЛНЕНИЕ)
        //$data = Request::input('task'); // data уже в JSON
        //return EmulatorController::MTRun($data);
    }

    public function HAMPOST(Request $request){ // выполняет Маркова на данных и возвращает ответ    (ОБЫЧНОЕ ИСПОЛНЕНИЕ)
        $data = Request::input('task'); // data уже в JSON
        return EmulatorController::HAMRun($data);
    }
    
    public static function MTCheckSequence($data, $test_seq) {
        $seq_true = 0;
        $seq_all = count($test_seq['input_word']);
        $total_cycle = 0;
        $data = json_decode($data, true);
        $automaton = $data['automaton'];
        $alphabet = $data['alphabet'];
        Log::debug('automaton');
        Log::debug($automaton);
        Log::debug('alphabet');
        Log::debug($alphabet);
        $machine = new MT2TuringMachine($automaton, $alphabet);
        for($i = 0; $i < $seq_all; $i++){
            $inputWord = $test_seq['input_word'][$i];
            $inputWord = mb_substr($inputWord, 1, null, 'UTF-8');
            $outputWord = $test_seq['output_word'][$i];
            $outputWord = mb_substr($outputWord, 1, null, 'UTF-8');
            Log::debug('input');
            Log::debug($inputWord);
            Log::debug('right answer');
            Log::debug($outputWord);
            $answer = EmulatorController::MTRun($machine, $inputWord);
            Log::debug('output');
            Log::debug($answer);
            $total_cycle += $answer['cycle'];
            if(trim($answer['result']) == trim($outputWord)){
                $seq_true++;
            }
        }
        return [$seq_true, $seq_all, $total_cycle];
    }
    
    public static function HAMCheckSequence($data, $test_seq) {
        Log::debug('Checking');
        $seq_true = 0;
        $seq_all = count($test_seq['input_word']);
        $total_cycle = 0;
        
        for($i = 0; $i < $seq_all; $i++){
            $data = json_decode($data, true);

            $test_seq['input_word'][$i] = str_replace("Λ", "", $test_seq['input_word'][$i]);
            $test_seq['input_word'][$i] = "Λ".$test_seq['input_word'][$i];

            $data['str'] = $test_seq['input_word'][$i];
            $data = json_encode($data);
            Log::debug('Input: '.$data);
            $answer = EmulatorController::HAMRun($data);
            Log::debug('Output: '.$answer);
            $answer = json_decode($answer, true);
            
            $total_cycle += $answer['cycle'];

            $test_seq['output_word'][$i] = str_replace("Λ", "", $test_seq['output_word'][$i]);
            $answer['result'] = str_replace("Λ", "", $answer['result']);
            Log::debug('Expected result = '.$test_seq['output_word'][$i]);
            Log::debug('Actual result = '.$answer['result']);

            if($answer['result'] == $test_seq['output_word'][$i]){
                $seq_true++;
            }
        }
        return [$seq_true, $seq_all, $total_cycle];
    }
    
    public function MTCheck(Request $request) {
        $task = Request::input('task');
        $task_id = Request::input('task_id');
        $test_id = Request::input('test_id');
        $counter = Request::input('counter') - 1;
        Log::debug('task');
        Log::debug($task);
        Log::debug('task_id');
        Log::debug($task_id);
        Log::debug('test_id');
        Log::debug($test_id);
        Log::debug('counter');
        Log::debug($counter);
        Log::debug('user_id');
        Log::debug(Auth::user()['id']);
        $current_test = Result::getCurrentResult(Auth::user()['id'], $test_id);
        Log::debug('current_test');
        Log::debug($current_test);

        if($current_test != -1){
            /* Get current saved test */
            $test = Result::whereId_result($current_test)->first();
            $saved_test = $test->saved_test;
            $saved_test = unserialize($saved_test);
            Log::debug('saved_test');
            Log::debug($saved_test);
            
            /* Modify saved data with use question->check() */
            $question = new Question();
            $debug_counter = $saved_test[$counter]['arguments']['debug_counter'];

            # $task_id = 43564 (идентификатор вопроса)
            # $debug_counter = 8 (сколько раз нажали на кнопку "Проверить работу" вплоть до сих пор
            # $task = информация о текущем вводе пользователя в эмулятор Тьюринга в следующем виде:
            #   {"rule":[{"src":"S0{∂}","dst":"{∂}{R}S0"}],"str":["∂"]}
            $result_check = $question->check([$task_id, $debug_counter + 1, $task]);

            Log::debug('result_check');
            Log::debug($result_check);
            
            $saved_test[$counter]['arguments']['debug_counter'] = $result_check['choice']['debug_counter'];
            
            /* Save new data */
            $saved_test = serialize($saved_test);
            $test->saved_test = $saved_test;
            $test->save();
        
        }
        
        return $result_check;   
    }

    public function HAMCheck(Request $request) {
        $task = Request::input('task');
        $task_id = Request::input('task_id');
        $test_id = Request::input('test_id');
        $counter = Request::input('counter') - 1;
        $current_test = Result::getCurrentResult(Auth::user()['id'], $test_id);
        
        if($current_test != -1){
            /* Get current saved test */
            $test = Result::whereId_result($current_test)->first();
            $saved_test = $test->saved_test;
            $saved_test = unserialize($saved_test);
            
            /* Modify saved data with use question->check() */
            $question = new Question();
            $debug_counter = $saved_test[$counter]['arguments']['debug_counter'];
            
            $result_check = $question->check([$task_id, $debug_counter + 1, $task]);
            
            $saved_test[$counter]['arguments']['debug_counter'] = $result_check['choice']['debug_counter'];
            
            /* Save new data */
            $saved_test = serialize($saved_test);
            $test->saved_test = $saved_test;
            $test->save();
        
        }
        
        return $result_check;   
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
