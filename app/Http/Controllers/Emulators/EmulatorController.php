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
use App\Http\Controllers\Controller;

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
    
    public function MTPOST(Request $request){  // выполняет Тьюринга на данных и возвращает ответ
        $cmd = "/usr/local/bin/turing.sh";
        $data = $request->input('task');
        $task_file = tempnam(sys_get_temp_dir(), 'turn_'); 
        $task_answ = tempnam(sys_get_temp_dir(), 'turn_answ_');
        file_put_contents($task_file, $data);
        $data = exec($cmd . " " . $task_file);
        unlink($task_file);
        unlink($task_answ);
        return $data;
    }

    public function HAMPOST(Request $request){ // выполняет Маркова на данных и возвращает ответ
        $cmd = "/usr/local/bin/normal.sh";
        $data = $request->input('task');
        $task_file = tempnam(sys_get_temp_dir(), 'norm_'); 
        $task_answ = tempnam(sys_get_temp_dir(), 'norm_answ_');
        file_put_contents($task_file, $data);
        $data = exec($cmd . " " . $task_file);
        unlink($task_file);
        unlink($task_answ);
        return $data;
    }

    function run($data){ // выполняет Тьюринга на данных и возвращает ответ     data -> json_decode -> MT -> json_encode(True) -> data
        $cmd = "/usr/local/bin/turing.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'turn_');
        file_put_contents($task_file, json_encode($data));
        $res = exec($cmd . " " . $task_file);
        $res = json_decode($res, True);
        unlink($task_file);
        return $res;
    }

    function runHAM($data){ // выполняет Маркова на данных и возвращает ответ     data -> json_decode -> MT -> json_encode(True) -> data
        $cmd = "/usr/local/bin/normal.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'norm_');
        file_put_contents($task_file, json_encode($data));
        $res = exec($cmd . " " . $task_file); 
        $res = json_decode($res, True);
        unlink($task_file);
        return $res;
    }

    public function kontr_HAMPOST(Request $request) {

        $user = Auth::user();
        $id_user = $user['id'];
        $mark = 0;
        $data = json_decode($request->input('task'),true);
        $id_task = $data['id']; 
        $solution_time = $data['duration'];


        $sqnc_1 = DB::select("SELECT input_word, output_word as conv FROM testsequence_nam WHERE task_id =" .$id_task);
        $sqnc = json_decode(json_encode($sqnc_1), true);

        $input = array();
        $conv = array();
        $ksuha = array();
        /* Get result mark */
        $n_tests = 0;
        $total_cycle = 0;
        if ( $res = $sqnc ) {
            foreach ($res as $row ) {
                $n_tests += 1;
                $data['str'] = $row['input_word'];
                $result = $this->runHAM($data);
                if ( $result['result'] == $row['conv'] ) {
                    $mark+= 1;
                    $total_cycle += $result['cycle'];
                }
                array_push($input, $row['input_word']);
                array_push($conv, $row['conv']);
                array_push($ksuha, $result['result']);
            }
        } else {
            die ("res error");
        }


        $task_info = DB::select("SELECT * FROM tasks_nam WHERE Id  =".$id_task);
        $task_info = EmulatorController::magic($task_info)[0];
        $max_mark = $task_info['max_mark'];
        $efc = 1;
        $total_test_time = 45 * 60; 
        if ($solution_time < $task_info['expected_time'] - $task_info['delta']) {
            $efc = $solution_time * (1 - $task_info['time_coef_b']) / ($task_info['expected_time'] - $task_info['delta']) + $task_info['time_coef_b'];
        }
        if ($solution_time > $task_info['expected_time'] + $task_info['delta']) {
            $efc = $solution_time * ($task_info['time_coef_a'] - 1) / ($total_test_time - $task_info['expected_time'] - $task_info['delta']) + $task_info['time_coef_a'];
        }
        if ($mark == $n_tests) { 
            if ($total_cycle < $task_info['cycle']) {
                $efc *= $task_info['cycle_coef'];
                DB::update("UPDATE tasks_nam SET cycle = " . $total_cycle . " WHERE Id = " . $id_task);
            }
        }
        $result_mark  = ($mark / $n_tests) * $max_mark * $efc ;
        $repost = array(
            "input" => $input,
            "conv" => $conv,
            "ksuha" => $ksuha,
            "result" => $result_mark,
        );

        //set result to data base  
        $task_number = DB::select("SELECT task_number FROM tasks_nam WHERE id =".$id_task);
        $task_number = EmulatorController::magic($task_number);
        $task_number = $task_number[0]['task_number'];
        //        $id_user= 8;
        if ($task_number == 1)
        {
            DB::update( "UPDATE  user_result_nam SET id_task_1=".$id_task.",mark_1=".$result_mark.",user_time_1='10' WHERE id_user=".$id_user);
        }
        else 
        {
            DB::update( "UPDATE  user_result_nam SET  id_task_2=".$id_task.",mark_2=".$result_mark.",user_time_2='10' WHERE id_user=".$id_user);
        }  

//ddToStatements

    $mark_info_2 = DB::select("SELECT * FROM user_result_nam WHERE id_user=".$id_user);
        $mark_info_2 = EmulatorController::magic($mark_info_2)[0];
    $score_2 = $mark_info_2['mark_1']+$mark_info_2['mark_2'];
    Controls::where('userID', $id_user)->update(['control2' => $score_2]);

        return $repost;
    }

    public function kontr_MTPOST(Request $request){

        $user = Auth::user();
        $id_user = $user['id'];
        $mark = 0;

        $data = json_decode($request->input('task'), true);
        $id_task = $data['id'];
        $rules_size = count($data['rule']);
        $solution_time = $data['duration'];

        /* Get sequences from data base */
        $sqnc_1  = DB::select("SELECT input_word, output_word as conv FROM testsequence WHERE task_id =".$id_task);


        $sqnc = json_decode(json_encode($sqnc_1), true);
        $input = array();
        $conv = array();
        $ksuha = array();
        /* Get result mark */
        $n_tests = 0;
        $total_cycle = 0;
        if ( $res = $sqnc ) {
            foreach($res as $row) {
                $n_tests += 1;
                $data['str'] = $row['input_word'];
                $result = $this->run($data);
                if ($result['result'] == $row['conv']) {
                    $mark+= 1;
                    $total_cycle += $result['cycle'];
                }
                array_push($input, $row['input_word']);
                array_push($conv, $row['conv']);
                array_push($ksuha, $result['result']);
            }
        } else {
            die ("res error");
        }

        $task_info = DB::select("SELECT * FROM tasks WHERE id_task =".$id_task);
        $task_info = EmulatorController::magic($task_info)[0];
        $max_mark = $task_info['mark'];
        $efc = 1;
        $total_test_time = 45 * 60; 
        if ($solution_time < $task_info['expected_time'] - $task_info['delta']) {
            $efc = $solution_time * (1 - $task_info['time_coef_b']) / ($task_info['expected_time'] - $task_info['delta']) + $task_info['time_coef_b'];
        }
        if ($solution_time > $task_info['expected_time'] + $task_info['delta']) {
            $efc = $solution_time * ($task_info['time_coef_a'] - 1) / ($total_test_time - $task_info['expected_time'] - $task_info['delta']) + $task_info['time_coef_a'];
        }
        if ($mark == $n_tests) { 
            if ($total_cycle < $task_info['cycle']) {
                $efc *= $task_info['cycle_coef'];
                DB::update("UPDATE tasks SET cycle = " . $total_cycle . " WHERE id_task = " . $id_task);
            }
            if ($rules_size < $task_info['rows']) {
                $efc *= $task_info['rows_coef'];
                DB::update("UPDATE tasks SET rows = " . $rules_size . " WHERE id_task = " . $id_task);
            }
        }
        $result_mark  = ($mark / $n_tests) * $max_mark * $efc ;

        $repost = array(
            "input" => $input,
            "conv" => $conv,
            "ksuha" => $ksuha,
            "result" => $result_mark,
        );

        //set result to data base 
        $task_number = DB::select("SELECT number FROM tasks WHERE id_task =".$id_task);
        $task_number = EmulatorController::magic($task_number);
        $task_number = $task_number[0]['number'];

        if ($task_number == 1)
        {
            DB::update( "UPDATE  user_result_tur SET id_task_1=".$id_task.",mark_1=".$result_mark.",user_time_1='10' WHERE id_user=".$id_user);
        }
        else 
        {
            DB::update( "UPDATE  user_result_tur SET  id_task_2=".$id_task.",mark_2=".$result_mark.",user_time_2='10' WHERE id_user=".$id_user);
        }

    //ddToStatements

    $mark_info = DB::select("SELECT * FROM user_result_tur WHERE id_user=".$id_user);
        $mark_info = EmulatorController::magic($mark_info)[0];
    $score = $mark_info['mark_1']+$mark_info['mark_2'];
    Controls::where('userID', $id_user)->update(['control1' => $score]);

        return $repost;


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
