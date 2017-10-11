<?php

namespace App\Http\Controllers;
use DB;
use Request;
use App\Tasks;
use App\Testsequence;
use App\Tasks_nam;
use App\Testsequence_nam;
use App\NamForGroup;



class TasksController extends Controller {


  public function magic($array) {
        return json_decode(json_encode($array), true);
    }

    public function main(){
        return view('algorithm.main');
    }


    public function index(){
    
        $tasks_and_sequences = DB::select("SELECT * FROM `testsequence_nam` i LEFT JOIN `tasks_nam` u ON u.id = i.task_id");
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.nam.alltasks", compact('tasks_and_sequences'));
    }

  
    public function deleteTask($id){
         
        $result = DB::select("SELECT * from tasks_nam WHERE tasks_nam.id=".$id);
        $result = TasksController::magic($result);
        $i = 0;
        $counter = count($result);
        while ($i < $counter){ // удаляю во второй базе множество записей
        $row = $result[$i++];
        DB::delete("DELETE FROM testsequence_nam WHERE testsequence_nam.task_id=".$row['id']."");
        }
        DB::delete("DELETE FROM tasks_nam WHERE tasks_nam.id=".$id); 
        $tasks_and_sequences = DB::select("SELECT * FROM `testsequence_nam` i LEFT JOIN `tasks_nam` u ON u.id = i.task_id");
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.nam.alltasks", compact('tasks_and_sequences'));
    }
    


    public function edit($sequense_id){

        $result = DB::select("SELECT * from testsequence_nam WHERE sequense_id=".$sequense_id);
        $result = TasksController::magic($result)[0];
        return view("algorithm.tasks.nam.edit", compact('result','sequense_id'));
    }


    public function editTask($sequense_id){

       $input_word6 = Request::input("input_word6");
       $output_word6 = Request::input("output_word6");
       $query3 = DB::update("UPDATE testsequence_nam SET input_word='$input_word6', output_word='$output_word6' where sequense_id=".$sequense_id);
       $query3 = TasksController::magic($query3);
       $tasks_and_sequences = DB::select("SELECT * FROM `testsequence_nam` i LEFT JOIN `tasks_nam` u ON u.id = i.task_id");
       $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
       return view("algorithm.tasks.nam.alltasks", compact('tasks_and_sequences'));
    }


public function editCoef(){

        $result = DB::select("SELECT * from tasks_nam ");
        $result = TasksController::magic($result)[0];
        return view("algorithm.tasks.nam.editCoef", compact('result','id'));
    }
public function editAllCoef($id){

       $new_effic = Request::input("new_effic");
       $new_time_a = Request::input("new_time_a");
       $new_time_b = Request::input("new_time_b");
       $new_delta = Request::input("new_delta");
       $query3 = DB::update("UPDATE tasks_nam SET efficiency_coef='$new_effic', time_coef_a='$new_time_a', time_coef_b='$new_time_b', delta='$new_delta'");
       $query3 = TasksController::magic($query3);
       $tasks_and_sequences = DB::select("SELECT * FROM `testsequence_nam` i LEFT JOIN `tasks_nam` u ON u.id = i.task_id");
       $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
       return view("algorithm.tasks.nam.alltasks", compact('tasks_and_sequences'));
    }

    public function addtask(){
        return view("algorithm.tasks.nam.addtask");
    }


    public function adding(){
      $task_text = Request::input('task_text');
      $max_mark = Request::input('max_mark');
      $task_number = Request::input('task_number');
      $level = Request::input('level');
      $variant_number = Request::input('variant_number');
      $input_word = Request::input('input_word');
      $output_word = Request::input('output_word'); 
      $input_word1 = Request::input('input_word1');
      $output_word1 = Request::input('output_word1'); 
      $input_word2 = Request::input('input_word2');
      $output_word2 = Request::input('output_word2'); 
      $input_word3 = Request::input('input_word3');
      $output_word3 = Request::input('output_word3'); 
      $input_word4 = Request::input('input_word4');
      $output_word4 = Request::input('output_word4');   
      $result1 = DB::insert(  " INSERT INTO tasks_nam (efficiency_coef,time_coef_a, time_coef_b, delta, task_number,task_text,level,variant_number,max_mark,min_time) 
                                        VALUES('1','1','1', '00:00:00', '$task_number','$task_text','$level','$variant_number','$max_mark','00:00:00')");
      $results = DB::select('SELECT * from tasks_nam');
      $results = TasksController::magic($results);
      $task_id = $results[count($results) - 1]['id'];
      $result2 = DB::insert( "INSERT INTO testsequence_nam (input_word,output_word,task_id) VALUES('$input_word','$output_word','$task_id')");
      $result3 = DB::insert( "INSERT INTO testsequence_nam (input_word,output_word,task_id) VALUES('$input_word1','$output_word1','$task_id')");
      $result4 = DB::insert( "INSERT INTO testsequence_nam (input_word,output_word,task_id) VALUES('$input_word2','$output_word2','$task_id')");
      $result5 = DB::insert( "INSERT INTO testsequence_nam (input_word,output_word,task_id) VALUES('$input_word3','$output_word3','$task_id')");
      $result6 = DB::insert( "INSERT INTO testsequence_nam (input_word,output_word,task_id) VALUES('$input_word4','$output_word4','$task_id')");

      return view("algorithm.tasks.nam.addtask");
}

public function alltasksmt(){
    
        $tasks_and_sequences = DB::select("SELECT * FROM `testsequence` i LEFT JOIN `tasks` u ON u.id_task = i.task_id");
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.mt.alltasks", compact('tasks_and_sequences'));
    }
  public function editmt($id_sequence){

        $result = DB::select("SELECT * from `testsequence` WHERE testsequence.id_sequence=".$id_sequence);
        $result1 = TasksController::magic($result)[0];
        return view("algorithm.tasks.mt.edit", compact('result1','id_sequence'));
    }

 public function editmtTask($id_sequence){

       $input_word6 = Request::input("input_word6");
       $output_word6 = Request::input("output_word6");
       $query3 = DB::update("UPDATE testsequence SET input_word='$input_word6', output_word='$output_word6' where id_sequence=".$id_sequence);
       $query3 = TasksController::magic($query3);
       $tasks_and_sequences = DB::select("SELECT * FROM `testsequence` i LEFT JOIN `tasks` u ON u.id_task = i.task_id");
       $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
       return view("algorithm.tasks.mt.alltasks", compact('tasks_and_sequences'));


      }

  public function addtaskmt(){
        return view("algorithm.tasks.mt.addtask");
    }

  public function addingmt(){

      $task_text = Request::input('task_text');
      $max_mark = Request::input('max_mark');
      $task_number = Request::input('task_number');
      $level = Request::input('level');
      $variant = Request::input('variant');
      $input_word = Request::input('input_word');
      $output_word = Request::input('output_word'); 
      $input_word1 = Request::input('input_word1');
      $output_word1 = Request::input('output_word1'); 
      $input_word2 = Request::input('input_word2'); 
      $output_word2 = Request::input('output_word2'); 
      $input_word3 = Request::input('input_word3');
      $output_word3 = Request::input('output_word3'); 
      $input_word4 = Request::input('input_word4');
      $output_word4 = Request::input('output_word4');   
      $result1 = DB::insert(  " INSERT INTO tasks (task,number,level,mark,variant,rows_coef,time_coef_a,time_coef_b,cycle_coef,sum_coef, rows, cycle,sum) 
                                        VALUES('$task_text','$task_number','$level','$max_mark','$variant','1','1','1','1','1','1000','1000','1000')");
      $results = DB::select('SELECT * from tasks');
      $results = TasksController::magic($results);
      $task_id = $results[count($results) - 1]['id_task'];
      $result2 = DB::insert( "INSERT INTO testsequence (input_word,output_word,task_id) VALUES('$input_word','$output_word','$task_id')");
      $result3 = DB::insert( "INSERT INTO testsequence (input_word,output_word,task_id) VALUES('$input_word1','$output_word1','$task_id')");
      $result4 = DB::insert( "INSERT INTO testsequence (input_word,output_word,task_id) VALUES('$input_word2','$output_word2','$task_id')");
      $result5 = DB::insert( "INSERT INTO testsequence (input_word,output_word,task_id) VALUES('$input_word3','$output_word3','$task_id')");
      $result6 = DB::insert( "INSERT INTO testsequence (input_word,output_word,task_id) VALUES('$input_word4','$output_word4','$task_id')");

      return view("algorithm.tasks.mt.addtask");
  }


       public function deletemtTask($id){
         
        $result = DB::select("SELECT * from tasks WHERE tasks.id_task=".$id);
        $result = TasksController::magic($result);
        $i = 0;
        $counter = count($result);
        while ($i < $counter){ // удаляю во второй базе множество записей
        $row = $result[$i++];
        DB::delete("DELETE FROM testsequence WHERE testsequence.task_id=".$row['id_task']."");
        }
        DB::delete("DELETE FROM tasks WHERE tasks.id_task=".$id); 
        $tasks_and_sequences = DB::select("SELECT * FROM `testsequence` i LEFT JOIN `tasks` u ON u.id_task = i.task_id");
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.mt.alltasks", compact('tasks_and_sequences'));

    }

    
public function editCoefMt(){

        $result = DB::select("SELECT * from tasks ");
        $result = TasksController::magic($result)[0];
        return view("algorithm.tasks.mt.editCoefMt", compact('result','id_task'));
    }

public function editAllCoefMt($id_task){

       $new_rows = Request::input("new_rows");
       $new_time_a = Request::input("new_time_a");
       $new_time_b = Request::input("new_time_b");
       $new_cycle = Request::input("new_cycle");
       $new_sum = Request::input("new_sum");
       $new_delta = Request::input("new_delta");
       $query3 = DB::update("UPDATE tasks SET rows_coef='$new_rows', time_coef_a='$new_time_a', time_coef_b='$new_time_b', cycle_coef='$new_cycle', sum_coef='$new_sum', delta='$new_delta'");
       $query3 = TasksController::magic($query3);
       $tasks_and_sequences = DB::select("SELECT * FROM `testsequence` i LEFT JOIN `tasks` u ON u.id_task = i.task_id");
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.mt.alltasks", compact('tasks_and_sequences'));
      
    }

public function edit_date(){


        $result1 = DB::select("SELECT * from kontr_rab WHERE id = '1'");
        $result1 = TasksController::magic($result1)[0];
        $result2 = DB::select("SELECT * from kontr_rab WHERE id = '2'");
        $result2 = TasksController::magic($result2)[0];
        $result3 = DB::select("SELECT * from kontr_rab WHERE id = '3'");
        $result3 = TasksController::magic($result3)[0];
       //выбрать все группы из 
        $all_groups = DB::select("SELECT * FROM `groups` i LEFT JOIN `nam_for_group` u ON u.id_group = i.group_id WHERE archived='0'");
        $all_groups = TasksController::magic($all_groups);
        return view("algorithm.edit_date", compact('result1','result2','result3', 'all_groups'));

    }

public function edit_date_mt(){


        $result1 = DB::select("SELECT * from kontr_rab WHERE id = '1'");
        $result1 = TasksController::magic($result1)[0];
        $result2 = DB::select("SELECT * from kontr_rab WHERE id = '2'");
        $result2 = TasksController::magic($result2)[0];
        $result3 = DB::select("SELECT * from kontr_rab WHERE id = '3'");
        $result3 = TasksController::magic($result3)[0];
       //выбрать все группы из 
        $all_groups = DB::select("SELECT * FROM `groups` i LEFT JOIN `mt_for_group` u ON u.id_group = i.group_id WHERE archived='0'");
        $all_groups = TasksController::magic($all_groups);
        return view("algorithm.edit_date_mt", compact('result1','result2','result3', 'all_groups'));

    }
  
public function editAllDate(){

       // $tur_start = Request::input("tur_start");
       // $new_tur_finish = Request::input("new_tur_finish");
       $new_nam_start = Request::input("new_nam_start");
       $new_nam_finish = Request::input("new_nam_finish");
       //$new_rec_start = Request::input("new_rec_start");
      // $new_rec_finish = Request::input("new_rec_finish");
       $availability_input = (Request::input("availability")== null) ? [] : Request::input("availability");
               
       for ($i = 0; $i < count(Request::input("id-group")); $i++) {
            $availability = in_array(Request::input("id-group")[$i], $availability_input) ? 1 : 0;
            $group = Request::input("id-group")[$i];
            //return Request::input("id-group");
            DB::insert("INSERT INTO nam_for_group (id_group, availability) VALUES ($group, $availability) ON DUPLICATE KEY UPDATE availability = '$availability'" );
            
        }
          
        

     
       DB::update("UPDATE kontr_rab SET start_date='$new_nam_start', finish_date='$new_nam_finish' WHERE id = '2'");
      // DB::update("UPDATE kontr_rab SET start_date='$new_rec_start', finish_date='$new_rec_finish' WHERE id = '3'");


       
       // $tasks_and_sequences = DB::select("SELECT * FROM `testsequence` i LEFT JOIN `tasks` u ON u.id_task = i.task_id");
       // $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        
      return view("algorithm.main");
      
    }

public function editAllDate_mt(){

       $tur_start = Request::input("tur_start");
       $new_tur_finish = Request::input("new_tur_finish");
      //$new_rec_start = Request::input("new_rec_start");
      // $new_rec_finish = Request::input("new_rec_finish");
       $availability_input = (Request::input("availability")== null) ? [] : Request::input("availability");
               
       for ($i = 0; $i < count(Request::input("id-group")); $i++) {
            $availability = in_array(Request::input("id-group")[$i], $availability_input) ? 1 : 0;
            $group = Request::input("id-group")[$i];
            //return Request::input("id-group");
            DB::insert("INSERT INTO mt_for_group (id_group, availability) VALUES ($group, $availability) ON DUPLICATE KEY UPDATE availability = '$availability'" );
            
        }
          
        DB::update("UPDATE kontr_rab SET start_date='$tur_start', finish_date='$new_tur_finish' WHERE id = '1'");
      // DB::update("UPDATE kontr_rab SET start_date='$new_rec_start', finish_date='$new_rec_finish' WHERE id = '3'");


       
       // $tasks_and_sequences = DB::select("SELECT * FROM `testsequence` i LEFT JOIN `tasks` u ON u.id_task = i.task_id");
       // $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        
      return view("algorithm.main");
      
    }    

  }
    
     

    
    
 
