<?php

namespace App\Http\Controllers;
use DB;
use Request;
use App\User;
use App\Tasks;
use App\Testsequence;
use App\Tasks_nam;
use App\Testsequence_nam;
use App\Tasks_ram;
use App\Tasks_post;
use App\Testsequence_ram;
use App\Testsequence_post;
use App\Kontr_work;
use App\Group;
use App\EmrForGroup;
use App\UserResultRam;
use App\UserResultPost;
use Illuminate\Support\Facades\Input;


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

    public function edit_users_nam(){


       //выбрать всех студентов и результаты контрольных по Маркову 
        $all_users = DB::select("SELECT * FROM `users` i LEFT JOIN `user_result_nam` u ON u.Id_user = i.id LEFT JOIN `groups` g ON i.group = g.group_id WHERE archived='0'");
        $all_users = TasksController::magic($all_users);

        //return $all_users[0]['group'];
        return view("algorithm.edit_users_nam", compact('all_users'));

    }  
    public function edit_users_nam_change(Request $request){

        $availability_input = (Request::input("fines") == null) ? [] : Request::input("fines");

        for ($i=0; $i < count(Request::input("id")); $i++){

           $availability = in_array(Request::input("id")[$i], $availability_input) ? 1 : 0;
           $user = Request::input("id")[$i];

            DB::insert("INSERT INTO user_result_nam (Id_user, access) VALUES ($user, $availability) ON DUPLICATE KEY UPDATE access = '$availability'" );
            
           //  $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1");
           //  $variant = EmulatorController::magic($variant);
           //  $variant = $variant[0]['variant'];

           // DB::update( "UPDATE `user_result_nam` SET `variant`=".$variant." ,`mark_1`= 0 ,`mark_2` = 0, `Id_task_1`=0, `Id_task_2`=0  WHERE access = 1 AND `Id_user`=".$user);
        
        }
        //return $availability_input;
        return redirect()->back();
    }

     public function edit_users_mt(){


       //выбрать всех студентов и результаты контрольных по Маркову 
        $all_users = DB::select("SELECT * FROM `users` i LEFT JOIN `user_result_tur` u ON u.Id_user = i.id LEFT JOIN `groups` g ON i.group = g.group_id WHERE archived='0'");
        $all_users = TasksController::magic($all_users);

        //return $all_users[0]['group'];
        return view("algorithm.edit_users_mt", compact('all_users'));

    }  

     public function edit_users_mt_change(Request $request){

        $availability_input = (Request::input("fines") == null) ? [] : Request::input("fines");

        for ($i=0; $i < count(Request::input("id")); $i++){

           $availability = in_array(Request::input("id")[$i], $availability_input) ? 1 : 0;
           $user = Request::input("id")[$i];

            DB::insert("INSERT INTO user_result_tur (Id_user, access) VALUES ($user, $availability) ON DUPLICATE KEY UPDATE access = '$availability'" );
            
           //  $variant = DB::select("SELECT variant FROM tasks order by RAND() limit 1");
           //  $variant = EmulatorController::magic($variant);
           //  $variant = $variant[0]['variant'];

           // DB::update( "UPDATE `user_result_nam` SET `variant`=".$variant." ,`mark_1`= 0 ,`mark_2` = 0, `Id_task_1`=0, `Id_task_2`=0  WHERE access = 1 AND `Id_user`=".$user);
        
        }
        //return $availability_input;
        return redirect()->back();
    }
	
	// ---------------- RAM Emulator ------------------- //
	
	public function RAM_manage_task(){
		$tasks_and_sequences = Testsequence_ram::leftJoin('tasks_ram', function($join) {
												$join->on('testsequence_ram.task_id', '=', 'tasks_ram.task_id');})->get();
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.ram.alltasks", compact('tasks_and_sequences'));
    }
	
	public function RAM_add_task(){
		return view("algorithm.tasks.ram.addtask");
	}
	
	public function RAM_delete_task($task_id) {
		Tasks_ram::where('task_id', $task_id)->delete();
		Testsequence_ram::where('task_id', $task_id)->delete();
		return redirect()->route('RAM_manage_task');
	}
	
	public function RAM_adding_task(){
		$task_text = Request::input('task_text');
		$max_mark = Request::input('max_mark');
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
		
		$created_task = Tasks_ram::Create(  ['level' => $level, 'mark' => $max_mark, 'variant' => $variant, 'description' => $task_text] );
		$task_id = $created_task['id'];
		Testsequence_ram::Create( ['input_word' => $input_word,  'output_word' => $output_word,  'task_id' => $task_id] );
		Testsequence_ram::Create( ['input_word' => $input_word1, 'output_word' => $output_word1, 'task_id' => $task_id] );
		Testsequence_ram::Create( ['input_word' => $input_word2, 'output_word' => $output_word2, 'task_id' => $task_id] );
		Testsequence_ram::Create( ['input_word' => $input_word3, 'output_word' => $output_word3, 'task_id' => $task_id] );
		Testsequence_ram::Create( ['input_word' => $input_word4, 'output_word' => $output_word4, 'task_id' => $task_id] );
		
		return view("algorithm.tasks.ram.addtask");
    }
  
	public function RAM_edit_task($sequence_id) {
		$sequence = Testsequence_ram::Where('sequence_id', $sequence_id)->get();
		$sequence = TasksController::magic($sequence)[0];
		return view("algorithm.tasks.ram.edit", compact('sequence','sequence_id'));
	}
	
	public function RAM_editing_task($sequence_id){
		$input_word6  = Request::input("input_word6");
		$output_word6 = Request::input("output_word6");
		Testsequence_ram::where('sequence_id', $sequence_id)
		  			    ->update(['input_word' => $input_word6, 'output_word' => $output_word6]);
		return redirect()->route('RAM_manage_task');
	}
	
	public function RAM_edit_users(){
		//выбрать всех студентов и результаты контрольных по RAM
		$all_users = User::leftJoin('user_result_ram', function($join) {
						  $join->on('user_result_ram.user_id', '=', 'users.id');})
						 ->leftJoin('groups', function($join) {
						  $join->on('groups.group_id', '=', 'users.group');})
						 ->where('archived', 0)
						 ->get();
		$emr_type = "ram";
        return view("algorithm.edit_users", compact('all_users', 'emr_type'));
    }

    public function RAM_editing_users(Request $request){

        $availability_input = (Request::input("fines") == null) ? [] : Request::input("fines");

        for ($i=0; $i < count(Request::input("id")); $i++){
           $availability = in_array(Request::input("id")[$i], $availability_input) ? 1 : 0;
           $user = Request::input("id")[$i];
		   UserResultRam::updateOrInsert([ 'user_id' => $user ], [ 'access' => $availability ]);
        }
		
        return redirect()->back();
    }
	
	// -------------- Post Emulator ----------------------- //
	
	public function Post_manage_task(){
		$tasks_and_sequences = Testsequence_post::leftJoin('tasks_post', function($join) {
												$join->on('testsequence_post.task_id', '=', 'tasks_post.task_id');})->get();
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.post.alltasks", compact('tasks_and_sequences'));
    }
	
	public function Post_add_task(){
		return view("algorithm.tasks.post.addtask");
	}
	
	public function Post_delete_task($task_id) {
		Tasks_post::where('task_id', $task_id)->delete();
		Testsequence_post::where('task_id', $task_id)->delete();
		return redirect()->route('Post_manage_task');
	}
	
	public function Post_adding_task(){
		$task_text = Request::input('task_text');
		$max_mark = Request::input('max_mark');
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
		
		$created_task = Tasks_post::Create(  ['level' => $level, 'mark' => $max_mark, 'variant' => $variant, 'description' => $task_text] );
		$task_id = $created_task['id'];
		Testsequence_post::Create( ['input_word' => $input_word,  'output_word' => $output_word,  'task_id' => $task_id] );
		Testsequence_post::Create( ['input_word' => $input_word1, 'output_word' => $output_word1, 'task_id' => $task_id] );
		Testsequence_post::Create( ['input_word' => $input_word2, 'output_word' => $output_word2, 'task_id' => $task_id] );
		Testsequence_post::Create( ['input_word' => $input_word3, 'output_word' => $output_word3, 'task_id' => $task_id] );
		Testsequence_post::Create( ['input_word' => $input_word4, 'output_word' => $output_word4, 'task_id' => $task_id] );
		
		return view("algorithm.tasks.post.addtask");
    }
  
	public function Post_edit_task($sequence_id) {
		$sequence = Testsequence_post::Where('sequence_id', $sequence_id)->get();
		$sequence = TasksController::magic($sequence)[0];
		return view("algorithm.tasks.post.edit", compact('sequence','sequence_id'));
	}
	
	public function Post_editing_task($sequence_id){
		$input_word6  = Request::input("input_word6");
		$output_word6 = Request::input("output_word6");
		Testsequence_post::where('sequence_id', $sequence_id)
		  			    ->update(['input_word' => $input_word6, 'output_word' => $output_word6]);
		return redirect()->route('Post_manage_task');
	}
	
	public function Post_edit_users(){
		//выбрать всех студентов и результаты контрольных по POST
		$all_users = User::leftJoin('user_result_post', function($join) {
						  $join->on('user_result_post.user_id', '=', 'users.id');})
						 ->leftJoin('groups', function($join) {
						  $join->on('groups.group_id', '=', 'users.group');})
						 ->where('archived', 0)
						 ->get();
		$emr_type = "post";
        return view("algorithm.edit_users", compact('all_users', 'emr_type'));
    }

    public function Post_editing_users(Request $request){

        $availability_input = (Request::input("fines") == null) ? [] : Request::input("fines");

        for ($i=0; $i < count(Request::input("id")); $i++){
           $availability = in_array(Request::input("id")[$i], $availability_input) ? 1 : 0;
           $user = Request::input("id")[$i];
		   UserResultPost::updateOrInsert([ 'user_id' => $user ], [ 'access' => $availability ]);
        }
		
        return redirect()->back();
    }
	
	// -------------- Emulators common ------------------------//
	
	public function edit_date(){
		// тип эмулятора
		$name = Input::get('name');
		// время КР для эмулятора и ID
		$kontr_work = Kontr_work::where('name', $name)->get()[0];
		$emr_id 	= $kontr_work['id'];
        // доступ для групп
		$all_groups = Group::leftJoin('emr_for_group', function($join) {
										$join->on('groups.group_id', '=', 'emr_for_group.group_id');})->where('archived', 0)->where('emr_id', $emr_id)->get();
										
        return view("algorithm.edit_date", compact('emr_id', 'kontr_work', 'all_groups'));

    }
	
	public function editAllDate(){
		$new_start   = Request::input("new_start");
		$new_finish  = Request::input("new_finish");
		$emr_id		 = Request::input("emr_id");
		$availability_input = (Request::input("availability")== null) ? [] : Request::input("availability");
		
		for ($i = 0; $i < count(Request::input("id-group")); $i++) {
			$availability = in_array(Request::input("id-group")[$i], $availability_input) ? 1 : 0;
			$group_id = Request::input("id-group")[$i];
			EmrForGroup::updateOrInsert([ 'emr_id' => $emr_id, 'group_id' => $group_id], ['availability' => $availability]);
		}
		
		Kontr_work::whereId($emr_id)->update(['start_date' => $new_start, 'finish_date' => $new_finish]);
		return view("algorithm.main");
    }
}
    
     

    
    
 
