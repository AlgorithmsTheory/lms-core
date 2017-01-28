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


 public function open_MT(){

     $start_date_tur = DB::select("SELECT start_date FROM kontr_rab WHERE id = '1' AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) > start_date AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) < finish_date");

     $start_date_tur = EmulatorController::magic($start_date_tur);



     if (empty($start_date_tur))
     {

         return  EmulatorController::MT();
     }
     else

     {
         return  EmulatorController::kontrMT();
     }

  }

  public function open_HAM(){

     $start_date_nam = DB::select("SELECT start_date FROM kontr_rab WHERE id = '2' AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) > start_date AND ADDDATE(NOW( ) , INTERVAL  '03:00' HOUR_MINUTE) < finish_date");

     $start_date_nam = EmulatorController::magic($start_date_nam);

     if (empty($start_date_nam))
     {
         return  EmulatorController::HAM();
     }
     else

     {
         return  EmulatorController::kontrHAM();
     }

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
        $task_file = tempnam(sys_get_temp_dir(), 'turn_'); //why prefix?
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
        $task_file = tempnam(sys_get_temp_dir(), 'norm_'); //why prefix?
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
//        $task_file = tempnam(sys_get_temp_dir(), 'turn_t'); //создание файла с уникальным именем
//       $this->add_to_file($task_file, $word);
	file_put_contents($task_file, json_encode($data));
        $res = exec($cmd . " " . $task_file); //запуск эмулятура
//        unlink($task_file);  //удаление файла
        $res = json_decode($res, True);
//        $temp = json_decode(exec($cmd  . " " . $rule_file . " " . $task_file), true);
        unlink($task_file);
	return $res['result'];
//        return $temp['result'];
//        return "0101";
    }

    function runHAM($data){

        $cmd = "/usr/local/bin/normal.sh";
        $task_file = tempnam(sys_get_temp_dir(), 'norm_'); //создание файла с уникальным именем
        file_put_contents($task_file, json_encode($data));
        $res = exec($cmd . " " . $task_file); //запуск эмулятура
//        unlink($task_file);  //удаление файла
        $res = json_decode($res, True);
        //$temp = json_decode(exec($cmd  . " " . $rule_file . " " . $task_file), true);
        unlink($task_file);
        return $res['result'];
//        return "0101";
    }

public function kontr_HAMPOST(Request $request) {
    
        $user = Auth::user();
        $id_user = $user['id'];
        $mark = 0;
        $data = json_decode($request->input('task'),true);
        $id_task = $data['id'];
        // $rule_file = tempnam(sys_get_temp_dir(), 'norm_r_'); //sys_get_temp_dir — Возвращает путь к директории временных файлов
        // foreach ($data["rule"] as $rule){
        //     $this->add_to_file($rule_file, $rule["src"] . "->" . $rule["dst"] . "\n");
        // }
        $sqnc_1 = DB::select("SELECT input_word, output_word as conv FROM testsequence_nam WHERE task_id =" .$id_task);
        $sqnc = json_decode(json_encode($sqnc_1), true);

        $input = array();
        $conv = array();
        $ksuha = array();
        /* Проверить алгоритм и выставить оценку */
        $n_tests = 0;
        if ( $res = $sqnc) {
           foreach ($res as $row ) {
                $n_tests += 1;
                $data['str'] = $row['input_word'];
                $result = $this->runHAM($data);
                
                if ( $result == $row['conv'] ) {
                    $mark+= 1;
                }
                array_push($input, $row['input_word']);
                array_push($conv, $row['conv']);
                array_push($ksuha, $result);
            }
        } else {
            //unlink($rule_file);
            die ("res error");
        }

        $efc = 1;
        $max_mark = DB::select("SELECT max_mark FROM tasks_nam WHERE id=".$id_task);
        $max_mark = EmulatorController::magic($max_mark);
        $max_mark = $max_mark[0]['max_mark'];
        $result_mark  = ($mark / $n_tests) * $max_mark * $efc;
        $repost = array(
            "input" => $input,
            "conv" => $conv,
            "ksuha" => $ksuha,
            "result" => $result_mark,
        );

        /* Удалить использованный файл*/
       // unlink($rule_file);

           //записать в БД результат  
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
        
         return $repost;
//    return $sqnc[0]['input_word'];
}



    public function kontr_MTPOST(Request $request){
        
        $user = Auth::user();
        $id_user = $user['id'];
        $mark = 0;
       	
 //$max_mark = 5;       
        $data = json_decode($request->input('task'), true);
        $id_task = $data['id'];

        /*$data = [
            'rule' => [
                ['src' => 'a.A',
                'dst' => 'b.B.R']
            ]
        ];*
	

	//$max_mark = json_decode(json_encode($max_mark), true);
        $rule_file = tempnam(sys_get_temp_dir(), 'turn_r'); //sys_get_temp_dir — Возвращает путь к директории временных файлов
	file_put_contents($rule_file, $data);
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
		$data['str'] = $row['input_word'];
                $result = $this->run($data);
                if ( $result == $row['conv'] ) {
                    $mark+= 1;
                }
                array_push($input, $row['input_word']);
                array_push($conv, $row['conv']);
                array_push($ksuha, $result);
            }
        } else {
//            unlink($rule_file);
            die ("res error");
        }
        $efc = 1;
	$max_mark = DB::select("SELECT mark FROM tasks WHERE id_task =".$id_task);
	$max_mark = EmulatorController::magic($max_mark);
	$max_mark = $max_mark[0]['mark'];
        $result_mark  = ($mark / $n_tests) * $max_mark * $efc;

        $repost = array(
            "input" => $input,
            "conv" => $conv,
            "ksuha" => $ksuha,
            "result" => $result_mark,
        );
        
        //записать в БД результат  
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
       
        return $repost;


    }

    public function get_control_tasks(Request $request){
        
         $user = Auth::user();
         $id_user = $user['id'];
//        $id_user = 9;
        $array = array();
        $is_started = DB::select("SELECT variant FROM user_result_tur WHERE id_user =".$id_user);
        $is_started = EmulatorController::magic($is_started); 
        if (empty($is_started)) { //если варианта у студента еще нет

        $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1");
        $variant = EmulatorController::magic($variant);
        $variant = $variant[0]['variant'];
        $res = DB::select("SELECT task, number, level, variant, id_task FROM tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");
       //записать вариант в БД на студента
        DB::insert( "INSERT INTO user_result_tur (id_user,variant) VALUES (".$id_user.",".$variant.")");
                
        }

        else { //если вариант есть, вернуть ему тот же

        $variant = DB::select("SELECT variant FROM user_result_tur WHERE id_user =".$id_user);
        $variant = EmulatorController::magic($variant);
        $variant = $variant[0]['variant'];
        $res = DB::select("SELECT task, number, level, variant, id_task FROM tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");

        }
       //  $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1");
       //  $variant = EmulatorController::magic($variant);
       //  $variant = $variant[0]['variant'];
       //  $res = DB::select("SELECT task, number, level, variant, id_task FROM tasks WHERE variant = " . $variant . " AND number in (1, 2) AND level in (1,2)");
       // //записать вариант в БД на студента
       
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
//        $id_user = 1;
        $array = array();
        $is_started = DB::select("SELECT variant FROM user_result_nam WHERE id_user =".$id_user);
        $is_started = EmulatorController::magic($is_started); 
        if (empty($is_started)) {
            $variant = DB::select("SELECT variant_number  FROM tasks_nam order by RAND() limit 1");
            $variant = EmulatorController::magic($variant);
            $variant = $variant[0]['variant_number'];
            $res = DB::select("SELECT task_text as task, task_number as number, level, variant_number as variant, id as id_task FROM tasks_nam WHERE variant_number = " . $variant . " AND task_number in (1, 2) AND level in (1,2)");
             //записать вариант в БД на студента
            DB::insert( "INSERT INTO user_result_nam (id_user,variant) VALUES ('$id_user','$variant')");
        }
        else {

            // if ($status!=0)
            // {
            //     //те, кого отметили на переписывание, выдать этим такой варант, какого у них еще не было, и чистим инфу про них. И дать статус 0
            // }
            // else {
            //     //это те, у кого статус 0, уже написали либо еще пишут. Если статус 0 и дата  такая, как текущая,  выдаем вар-т тот, что уже выдан. Иначе выдаем, что уже писали кр.
            // }
            $variant = DB::select("SELECT variant FROM user_result_nam WHERE id_user =".$id_user);
            $variant = EmulatorController::magic($variant);
            $variant = $variant[0]['variant'];
            $res = DB::select("SELECT task_text as task, task_number as number, level, variant_number as variant, id as id_task FROM tasks_nam WHERE variant_number = " . $variant . " AND task_number in (1, 2) AND level in (1,2)");
               

        }
     
        $res = EmulatorController::magic($res);
        foreach ($res as $r){
            array_push ( $array, $r);
        }
        return json_encode($array);
    }


//Создание протокола
        public function get_MT_protocol(Request $request){
            $user = Auth::user();
        if ($request->ajax()) {
            $protocol = new MTProtocol('МТ', $user['id'], $request->input('html_text'));
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
