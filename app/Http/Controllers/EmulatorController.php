<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Tasks;
use App\Testsequence;

class EmulatorController extends Controller {

    private function add_to_file($file_name, $data)
    {
        $fd = fopen($file_name, 'a');
        fwrite($fd, $data);
        fclose($fd);
    }

    public function MT(){
      return view("algorithm.MT");
    }

    public function HAM(){
      return view("algorithm.HAM");
	}

    public function MTPOST(Request $request){
        $cmd = "/usr/local/bin/turing.sh";
        $data = json_decode($request->input('task'),true);
        $rule_file = tempnam(sys_get_temp_dir(), 'turn_r');
        $task_file = tempnam(sys_get_temp_dir(), 'turn_t');
        foreach ($data["rule"] as $rule){
            $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        }
        $this->add_to_file($task_file, $data["str"]);
        $temp = json_decode(exec($cmd  . " " . $rule_file . " " . $task_file), true);
        unlink($rule_file);
        unlink($task_file);
        return $temp;
    }

    public function HAMPOST(Request $request){
        $cmd = "/usr/local/bin/normal.sh";
        $data = json_decode($request->input('task'),true);
        $rule_file = tempnam(sys_get_temp_dir(), 'norm_r_');
        $task_file = tempnam(sys_get_temp_dir(), 'norm_t_');
        foreach ($data["rule"] as $rule){
            $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        }
        $this->add_to_file($task_file, $data["str"]);
        $temp = json_decode(exec($cmd . " " . $rule_file . " " . $task_file), true);
        unlink($rule_file);
        unlink($task_file);
        return $temp;
    }
 
 } 

