<?php

namespace App\Http\Controllers\Emulators;
use App\Http\Controllers\Controller;
use App\Testing\Question;
use App\Testing\Result;
use Request;
use Auth;

class RamEmulatorController extends Controller {

	public function openRAM() {
        return view('algorithm.RAM');
	}
    
    public function RAMCheck(Request $request) {
        $user_code = Request::input('user_code');
        $task_id = Request::input('task_id');
        $test_id = Request::input('test_id');
        $counter = Request::input('counter') - 1;
        $seq_true = Request::input('seq_true');
        $seq_all = Request::input('seq_all');
        $current_test = Result::getCurrentResult(Auth::user()['id'], $test_id);
        
        if($current_test != -1){
            /* Get current saved test */
            $test = Result::whereId_result($current_test)->first();
            $saved_test = $test->saved_test;
            $saved_test = unserialize($saved_test);
            
            /* Modify saved data with use question->check() */
            $question = new Question();
            $debug_counter = $saved_test[$counter]['arguments']['debug_counter'];
            
            $result_check = $question->check([$task_id, $debug_counter + 1, $seq_true, $seq_all]);
            
            $saved_test[$counter]['arguments']['debug_counter'] = $result_check['choice']['debug_counter'];
            $saved_test[$counter]['arguments']['user_code'] = $user_code;
            
            /* Save new data */
            $saved_test = serialize($saved_test);
            $test->saved_test = $saved_test;
            $test->save();
        
        }
        
        return $result_check;   
    }
}
