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

    public function magic($array) {
        return json_decode(json_encode($array), true);
    }

    public function MT(){
      return view("algorithm.MT");
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



    function run($word, $rule_file){
        $cmd = "/usr/local/bin/turing.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'turn_t'); //создание файла с уникальным именем
        $this->add_to_file($task_file, $word);
        $res = exec($cmd . " " . $rule_file . " " . $task_file); //запуск эмулятура
//        unlink($task_file);  //удаление файла
        $res = json_decode($res, True);


        $temp = json_decode(exec($cmd  . " " . $rule_file . " " . $task_file), true);
        unlink($task_file);

        return $temp['result'];
//        return "0101";
    }







    public function kontr_MTPOST(Request $request){
        $mark = 0;
        $max_mark = 5;
        $data = json_decode($request->input('task'),true);
        $id_task = $data['id'];
        /*$data = [
            'rule' => [
                ['src' => 'a.A',
                'dst' => 'b.B.R']
            ]
        ];*/
        $rule_file = tempnam(sys_get_temp_dir(), 'turn_r'); //sys_get_temp_dir — Возвращает путь к директории временных файлов


        foreach ($data["rule"] as $rule){
            $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        }
        /* Получить входные последовательности и преобразования из базы данных */
        $sqnc_1  = DB::select("SELECT input_word, output_word as conv FROM testsequence WHERE task_id =".$id_task);
        $sqnc = json_decode(json_encode($sqnc_1), true);
        $input = array();
        $conv = array();
        $ksuha = array();
        /* Проверить алгоритм и выставить оценку */
        $n_tests = 0;
        if ( $res = $sqnc ) {

            foreach($res as $row) {
                $n_tests += 1;
                $result = $this->run($row['input_word'], $rule_file);
                if ( $result == $row['conv'] ) {
                    $mark+= 1;
                }
                array_push($input, $row['input_word']);
                array_push($conv, $row['conv']);
                array_push($ksuha, $result);
            }
        } else {
            unlink($rule_file);
            die ("res error");
        }
        $efc = 1;
        $result_mark  = ($mark / $n_tests) * $max_mark * $efc;
        $repost = array(
            "input" => $input,
            "conv" => $conv,
            "ksuha" => $ksuha,
            "result" => $result_mark,
        );
////        echo(json_encode($repost));
        /* Закрыть соединение */
        /* Удалить использованный файл*/
        unlink($rule_file);
        return $repost;

//        return $res[0]['input_word'];

    }

    public function get_control_tasks(Request $request){
        $array = array();
        $variant = DB::select("SELECT variant FROM Tasks order by RAND() limit 1");
        $variant = EmulatorController::magic($variant);
        $variant = $variant[0]['variant'];
        $res = DB::select("SELECT task, number, level, variant, id_task FROM Tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");
        $res = EmulatorController::magic($res);
        foreach ($res as $r){
            array_push ( $array, $r);
        }
        return json_encode($array);
    }
 
 }