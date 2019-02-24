<?php

namespace App\Http\Controllers\Emulators;
use Auth;
use Request;
use App\User;
use App\Emulators\UserResultRam;
use App\Emulators\KontrWork;
use App\Emulators\EmrForGroup;
use App\Emulators\TasksRam;
use App\Emulators\TestsequenceRam;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TasksController;

class RamEmulatorController extends Controller {

	public function open_RAM() {
		date_default_timezone_set('Europe/Moscow');
        $user_id = Auth::user()['id'];
		$group = User::whereId($user_id)->get()[0]['group'];
		$kontr_work = KontrWork::whereName('ram')->get()[0];
		$emr_id = $kontr_work['id'];
		$start_date = date_create($kontr_work['start_date']);
		$finish_date = date_create($kontr_work['finish_date']);
		$now = date_create(date("Y-m-d H:i:s"));
		$available_date = ($now >= $start_date) && ($now <= $finish_date);
		$available_group_query = EmrForGroup::where('availability', 1)->where('emr_id', $emr_id)->get();

		for ($i = 0; $i < count($available_group_query); $i++) {
            $available_groups[$i] = $available_group_query[$i]['group_id']; 
		}
		
		$additional_access = UserResultRam::where('user_id', $user_id)->get()[0]['access'];
		
		if( $available_groups != null && in_array($group, $available_groups) && $available_date || $additional_access === 1 ) {
			$tasks = RamEmulatorController::get_control_tasks_ram($additional_access);
			$remain_time = (array)(date_diff($finish_date, $now));
			
			if($tasks == null){
				return view('algorithm.RAM_no_data');
			}
			else{
				return view( 'algorithm.kontrRAM', compact('tasks', 'remain_time') );
			}
		}
		else {
			return view('algorithm.RAM');
		}
	}
	
	public function get_control_tasks_ram($remake_work) {
		$user_id = Auth::user()['id'];
		$is_started = UserResultRam::where('user_id', $user_id)->get()[0];
		// generate new variant if first time or remake work
        if ($is_started['variant'] == null || $remake_work) {
			$variant = TasksRam::inRandomOrder()->take(1)->get()[0]['variant'];
		}
		else{
			$variant = $is_started['variant'];
		}
		// get task text
		$easy2_full = TasksRam::whereVariant($variant)->whereLevel(1)->whereMark(2)->take(1)->get()[0]; // take easy 2 ball task
		$easy2 = $easy2_full['description'];
		$easy2id = $easy2_full['task_id'];
		$easy3_full = TasksRam::whereVariant($variant)->whereLevel(1)->whereMark(3)->take(1)->get()[0]; // take easy 3 ball task
		$easy3 = $easy3_full['description'];
		$easy3id = $easy3_full['task_id'];
		$hard3_full = TasksRam::whereVariant($variant)->whereLevel(2)->whereMark(3)->take(1)->get()[0]; // take hard 3 ball task
		$hard3 = $hard3_full['description'];
		$hard3id = $hard3_full['task_id'];
		$hard4_full = TasksRam::whereVariant($variant)->whereLevel(2)->whereMark(4)->take(1)->get()[0]; // take hard 4 ball task
		$hard4 = $hard4_full['description'];
		$hard4id = $hard4_full['task_id'];
		if ($is_started['variant'] == null || $remake_work) {
			UserResultRam::updateOrInsert(['user_id' => $user_id],
			['variant' => $variant, 'task1easy_id' => $easy2id, 'task1hard_id' => $hard3id, 'task2easy_id' => $easy3id, 'task2hard_id' => $hard4id]);
		}
		// get task check sequences
		$easy2_seq = TestsequenceRam::where('task_id', $easy2id)->get();
		$easy3_seq = TestsequenceRam::where('task_id', $easy3id)->get();
		$hard3_seq = TestsequenceRam::where('task_id', $hard3id)->get();
		$hard4_seq = TestsequenceRam::where('task_id', $hard4id)->get();
		
		if( $easy2_full == null || $easy3_full == null || $hard3_full == null || $hard4_full == null )
			return null;
		
		return ['variant' => $variant, 'easy2' => $easy2, 'easy3' => $easy3, 'hard3' => $hard3, 'hard4' => $hard4,
				'easy2_seq' => json_encode($easy2_seq), 'easy3_seq' => json_encode($easy3_seq), 'hard3_seq' => json_encode($hard3_seq), 'hard4_seq' => json_encode($hard4_seq)];
	}
	
	public function RAM_set_mark(Request $request){
		$user_id = Auth::user()['id'];
		$mark1 = $request->input("mark1");
		$mark2 = $request->input("mark2");
		$sum_mark = $request->input("sum_mark");
		$user_code = $request->input("user_code");
		$date = date("Y-m-d H:i:s");
		UserResultRam::updateOrInsert(['user_id' => $user_id], ['mark_1' => $mark1, 'mark_2' => $mark2, 'sum_mark' => $sum_mark, 'user_code' => $user_code, 'date' => $date]);
	}
	
	//---------------------- work with tasks ------------------------- //
	
	public function RAM_manage_task(){
		$tasks_and_sequences = TestsequenceRam::leftJoin('tasks_ram', function($join) {
												$join->on('testsequence_ram.task_id', '=', 'tasks_ram.task_id');})->get();
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.ram.alltasks", compact('tasks_and_sequences'));
    }
	
	public function RAM_add_task(){
		return view("algorithm.tasks.ram.addtask");
	}
	
	public function RAM_delete_task($task_id) {
		TasksRam::where('task_id', $task_id)->delete();
		TestsequenceRam::where('task_id', $task_id)->delete();
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
		
		$created_task = TasksRam::Create(  ['level' => $level, 'mark' => $max_mark, 'variant' => $variant, 'description' => $task_text] );
		$task_id = $created_task['id'];
		TestsequenceRam::Create( ['input_word' => $input_word,  'output_word' => $output_word,  'task_id' => $task_id] );
		TestsequenceRam::Create( ['input_word' => $input_word1, 'output_word' => $output_word1, 'task_id' => $task_id] );
		TestsequenceRam::Create( ['input_word' => $input_word2, 'output_word' => $output_word2, 'task_id' => $task_id] );
		TestsequenceRam::Create( ['input_word' => $input_word3, 'output_word' => $output_word3, 'task_id' => $task_id] );
		TestsequenceRam::Create( ['input_word' => $input_word4, 'output_word' => $output_word4, 'task_id' => $task_id] );
		
		return view("algorithm.tasks.ram.addtask");
    }
  
	public function RAM_edit_task($sequence_id) {
		$sequence = TestsequenceRam::Where('sequence_id', $sequence_id)->get();
		$sequence = TasksController::magic($sequence)[0];
		return view("algorithm.tasks.ram.edit", compact('sequence','sequence_id'));
	}
	
	public function RAM_editing_task($sequence_id){
		$input_word6 = Request::input("input_word6");
		$output_word6 = Request::input("output_word6");
		TestsequenceRam::where('sequence_id', $sequence_id)
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

    public function RAM_editing_users(){

        $availability_input = (Request::input("fines") == null) ? [] : Request::input("fines");

        for ($i=0; $i < count(Request::input("id")); $i++){
           $availability = in_array(Request::input("id")[$i], $availability_input) ? 1 : 0;
           $user = Request::input("id")[$i];
		   UserResultRam::updateOrInsert([ 'user_id' => $user ], [ 'access' => $availability ]);
        }
		
        return redirect()->back();
    }

}
