<?php

namespace App\Http\Controllers;
use App\Protocols\HAMProtocol;
use App\Protocols\MTProtocol;
use DB;
use Illuminate\Http\Request;
use App\Tasks;
use App\Testsequence;
use App\User;
use Auth;
use App\Controls;

class EmulatorController extends Controller {



    //$user = Auth::user();
    //$user['id'];

    public function magic($array) {
        return json_decode(json_encode($array), true);
    }


    private function add_to_file($file_name, $data)
    {
        $fd = fopen($file_name, 'a');
        fwrite($fd, $data);
        fclose($fd);
    }

    public function open_MMT(){
        return  EmulatorController::MMT();
    }


 public function Post(){
      return view("algorithm.Post");
    }


    public function open_MT(){

        $user = Auth::user();
        $id_user = $user['id'];
        //$id_user =54;
       //$cur_group=9;
        $cur_group=DB::select("SELECT `id_group` FROM mt_for_group WHERE availability='1'");
        
        $cur_group = EmulatorController::magic($cur_group);

        $start_date_tur = DB::select("SELECT start_date FROM kontr_rab WHERE id = '1' AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) > start_date AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) < finish_date");

        $start_date_tur = EmulatorController::magic($start_date_tur);

        $group = DB::select("SELECT `group` FROM `users` WHERE id=".$id_user);
        $group = EmulatorController::magic($group);

        $user_access = DB::select("SELECT `access` FROM `user_result_tur` WHERE Id_user=".$id_user);
        $user_access = EmulatorController::magic($user_access);
        $user_access = $user_access[0]['access'];

         for ($i = 0; $i < count($cur_group); $i++) {
            $new[$i]=$cur_group[$i]['id_group']; 
            }   
        
             $available = 0;
        if ($new != null) {
            if (in_array($group[0]['group'], $new))
            {
                $available = 1;
            }
                 
        }  
            if ($available==1 or $user_access==1)   
            {
                //return  $cur_group;
                return  EmulatorController::kontrMT();
                
            }
            else

            {
                //return $cur_group[1]['id_group'];
                return  EmulatorController::MT();
            }

        // if (empty($start_date_tur))
        // {

        //     return  EmulatorController::MT();
        // }
        // else

        // {
        //     return  EmulatorController::kontrMT();
        // }

    }

    public function open_HAM(){

        $user = Auth::user();
        $id_user = $user['id'];
        //$id_user =54;
       //$cur_group=9;
        $cur_group=DB::select("SELECT `id_group` FROM nam_for_group WHERE availability='1'");
        
        $cur_group = EmulatorController::magic($cur_group);
    
        $start_date_nam = DB::select("SELECT start_date FROM kontr_rab WHERE id = '2' AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) > start_date AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) < finish_date");
        $start_date_nam = EmulatorController::magic($start_date_nam);
        
        $group = DB::select("SELECT `group` FROM `users` WHERE id=".$id_user);
        $group = EmulatorController::magic($group);

        $user_access = DB::select("SELECT `access` FROM `user_result_nam` WHERE Id_user=".$id_user);
        $user_access = EmulatorController::magic($user_access);
        $user_access = $user_access[0]['access'];


         for ($i = 0; $i < count($cur_group); $i++) {
            $new[$i]=$cur_group[$i]['id_group']; 
            }   
        
             $available = 0;
        if ($new != null) {
            if (in_array($group[0]['group'], $new))
            {
                $available = 1;
            }
                 
        }  
            if ($available==1 or $user_access==1)   
            {
                //return  $cur_group;
                return  EmulatorController::kontrHAM();
                
            }
            else

            {
                //return $cur_group[1]['id_group'];
                return EmulatorController::HAM();
            }

    }
	
	public function openRAM(){
		$user = Auth::user();
        $id_user = $user['id'];
		$group = DB::select("SELECT `group` FROM `users` WHERE id=".$id_user);
		return EmulatorController::RAM();
    }


    public function MT(){
        return view("algorithm.MT");
    }

    public function MMT() {
        return view("algorithm.MMT");
    }

    public function HAM(){
        return view("algorithm.HAM");
    }

    public function kontrMT(){
        return view("algorithm.kontrMT");
    }

    public function kontrHAM(){
        return view("algorithm.kontrHAM");
    }
	
	public function RAM() {
		return view("algorithm.RAM");
	}


    public function MTPOST(Request $request){

        // $cmd = "/usr/local/bin/turing.sh";
        // $data = json_decode($request->input('task'),true);
        // $rule_file = tempnam(sys_get_temp_dir(), 'turn_r');
        // $task_file = tempnam(sys_get_temp_dir(), 'turn_t');
        // foreach ($data["rule"] as $rule){
        //     $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        // }
        // $this->add_to_file($task_file, $data["str"]);
        // $temp = json_decode(exec($cmd  . " " . $rule_file . " " . $task_file), true);
        // unlink($rule_file);
        // unlink($task_file);
        // return $temp;

        // exec('LANG=\"en_US.UTF8\" locale charmap');
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

    public function HAMPOST(Request $request){

        $cmd = "/usr/local/bin/normal.sh";
        $data = $request->input('task');
        $task_file = tempnam(sys_get_temp_dir(), 'norm_'); 
        $task_answ = tempnam(sys_get_temp_dir(), 'norm_answ_');
        file_put_contents($task_file, $data);
        $data = exec($cmd . " " . $task_file);
        unlink($task_file);
        unlink($task_answ);
        return $data;
        // $data = json_decode($request->input('task'),true);
        // $rule_file = tempnam(sys_get_temp_dir(), 'norm_r_');
        // $task_file = tempnam(sys_get_temp_dir(), 'norm_t_');
        // foreach ($data["rule"] as $rule){
        //     $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        // }
        // $this->add_to_file($task_file, $data["str"]);
        // $temp = json_decode(exec($cmd . " " . $rule_file . " " . $task_file), true);
        // unlink($rule_file);
        // unlink($task_file);
        // return $temp;
    }



    function run($data){

        $cmd = "/usr/local/bin/turing.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'turn_');

        file_put_contents($task_file, json_encode($data));
        $res = exec($cmd . " " . $task_file);
        $res = json_decode($res, True);
        unlink($task_file);
        return $res;

    }

    function runHAM($data){

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


        // $rule_file = tempnam(sys_get_temp_dir(), 'norm_r_'); 
        // foreach ($data["rule"] as $rule){
        //     $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        // }
        $sqnc_1 = DB::select("SELECT input_word, output_word as conv FROM testsequence_nam WHERE task_id =" .$id_task);
        $sqnc = json_decode(json_encode($sqnc_1), true);

        $input = array();
        $conv = array();
        $ksuha = array();
        /* Get result mark */
        $n_tests = 0;
        $total_cycle = 0;
        if ( $res = $sqnc) {
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
            //unlink($rule_file);
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

        // unlink($rule_file);

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
        //    return $sqnc[0]['input_word'];
    }



    public function kontr_MTPOST(Request $request){

        $user = Auth::user();
        $id_user = $user['id'];
        $mark = 0;

        $data = json_decode($request->input('task'), true);
        $id_task = $data['id'];
        $rules_size = count($data['rule']);
        $solution_time = $data['duration'];

        /*$data = [
            'rule' => [
                ['src' => 'a.A',
                'dst' => 'b.B.R']
            ]
        ];*


    //$max_mark = json_decode(json_encode($max_mark), true);
        $rule_file = tempnam(sys_get_temp_dir(), 'turn_r');
    file_put_contents($rule_file, $data);
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
            //            unlink($rule_file);
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

        //         $id_user = 9;

        if ($task_number == 1)
        {
            DB::update( "UPDATE  user_result_tur SET id_task_1=".$id_task.",mark_1=".$result_mark.",user_time_1='10' WHERE id_user=".$id_user);
        }
        else 
        {
            DB::update( "UPDATE  user_result_tur SET  id_task_2=".$id_task.",mark_2=".$result_mark.",user_time_2='10' WHERE id_user=".$id_user);
        }  

        //        unlink($rule_file);

    //ddToStatements

    $mark_info = DB::select("SELECT * FROM user_result_tur WHERE id_user=".$id_user);
        $mark_info = EmulatorController::magic($mark_info)[0];
    $score = $mark_info['mark_1']+$mark_info['mark_2'];
    Controls::where('userID', $id_user)->update(['control1' => $score]);

        return $repost;


    }

    public function get_control_tasks(Request $request){

        $user = Auth::user();
        $id_user = $user['id'];
        //        $id_user = 54;
        $array = array();
        $is_started = DB::select("SELECT variant FROM user_result_tur WHERE id_user =".$id_user);
        $is_started = EmulatorController::magic($is_started); 
        if (empty($is_started) ) { //if student hasn't variant

            $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1");
            $variant = EmulatorController::magic($variant);
            $variant = $variant[0]['variant'];
            $res = DB::select("SELECT task, number, level, variant, id_task FROM tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");
            //set the student variant to data base
            DB::insert( "INSERT INTO user_result_tur (id_user,variant) VALUES (".$id_user.",".$variant.")");

        }

        else { //if the variant is, return it

            $variant = DB::select("SELECT variant FROM user_result_tur WHERE id_user =".$id_user);
            $variant = EmulatorController::magic($variant);
            $variant = $variant[0]['variant'];

            if ($variant==0) 
            {
               $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1"); 
               $variant = EmulatorController::magic($variant);
               $variant = $variant[0]['variant'];
               DB::update("UPDATE user_result_tur SET variant=" . $variant . " WHERE id_user =".$id_user);
            }
                          
            $res = DB::select("SELECT task, number, level, variant, id_task FROM tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");
           
            
        }
        //  $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1");
        //  $variant = EmulatorController::magic($variant);
        //  $variant = $variant[0]['variant'];
        //  $res = DB::select("SELECT task, number, level, variant, id_task FROM tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");

        $res = EmulatorController::magic($res);
        foreach ($res as $r){
            array_push ( $array, $r);
        }
        return json_encode($array);
        //return 0;

    }

    public function get_control_tasks_nam(Request $request){

         $user = Auth::user();
         $id_user = $user['id'];
        //$id_user = 9;
        $array = array();
        $is_started = DB::select("SELECT variant FROM user_result_nam WHERE id_user =".$id_user);
        $is_started = EmulatorController::magic($is_started); 
        if (empty($is_started)) {
            $variant = DB::select("SELECT variant_number  FROM tasks_nam order by RAND() limit 1");
            $variant = EmulatorController::magic($variant);
            $variant = $variant[0]['variant_number'];
            $res = DB::select("SELECT task_text as task, task_number as number, level, variant_number as variant, id as id_task FROM tasks_nam WHERE variant_number = " . $variant . " AND task_number in (1, 2) AND level in (1,2)");
            //set the student variant to data base
            DB::insert( "INSERT INTO user_result_nam (id_user,variant) VALUES ('$id_user','$variant')");
        }
        else {


            $variant = DB::select("SELECT variant FROM user_result_nam WHERE id_user =".$id_user);
            $variant = EmulatorController::magic($variant);
            $variant = $variant[0]['variant'];

             if ($variant==0) 
            {
                $variant = DB::select("SELECT variant_number  FROM tasks_nam order by RAND() limit 1");
                $variant = EmulatorController::magic($variant);
                $variant = $variant[0]['variant_number'];
               DB::update("UPDATE user_result_nam SET variant_number=" . $variant . " WHERE id_user =".$id_user);
            }

            $res = DB::select("SELECT task_text as task, task_number as number, level, variant_number as variant, id as id_task FROM tasks_nam WHERE variant_number = " . $variant . " AND task_number in (1, 2) AND level in (1,2)");


        }

        $res = EmulatorController::magic($res);
        foreach ($res as $r){
            array_push ( $array, $r);
        }
        return json_encode($array);
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
