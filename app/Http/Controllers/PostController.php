<?php

namespace App\Http\Controllers;
use App\Protocols\HAMProtocol;
use App\Protocols\MTProtocol;
use DB;
use Request;
use App\Tasks;
use App\Testsequence;
use App\User;
use Auth;
use App\Controls;
use App\UserResultPost;
use App\KontrWork;
use App\EmrForGroup;
use App\TasksPost;
use App\TestsequencePost;

class PostEmulatorController extends Controller {
	
	public function open_Post() {
		date_default_timezone_set('Europe/Moscow');
        $user_id = Auth::user()['id'];
		$group = User::whereId($user_id)->get()[0]['group'];
		$kontr_work = KontrWork::whereName('post')->get()[0];
		$emr_id = $kontr_work['id'];
		$start_date = date_create($kontr_work['start_date']);
		$finish_date = date_create($kontr_work['finish_date']);
		$now = date_create(date("Y-m-d H:i:s"));
		$available_date = ($now >= $start_date) && ($now <= $finish_date);
		$available_group_query = EmrForGroup::where('availability', 1)->where('emr_id', $emr_id)->get();
		
		for ($i = 0; $i < count($available_group_query); $i++) {
            $available_groups[$i] = $available_group_query[$i]['group_id']; 
		}
		
		$additional_access = UserResultPost::where('user_id', $user_id)->get()[0]['access'];
		
		if( $available_groups != null && in_array($group, $available_groups) && $available_date || $additional_access === 1 ) {
			$tasks = PostEmulatorController::get_control_tasks_post($additional_access);
			$remain_time = (array)(date_diff($finish_date, $now));
			
			if($tasks == null){
				return view('algorithm.Post_no_data');
			}
			else{
				return view( 'algorithm.kontrPost', compact('tasks', 'remain_time') );
			}
			
		}
		else {
			return view("algorithm.Post");
		}
	}
	
	public function get_control_tasks_post($remake_work) {
		$user_id = Auth::user()['id'];
		$is_started = UserResultPost::where('user_id', $user_id)->get()[0];
		// generate new variant if first time or remake work
        if ($is_started['variant'] == null || $remake_work) {
			$variant = TasksPost::inRandomOrder()->take(1)->get()[0]['variant'];
		}
		else {
			$variant = $is_started['variant'];
		}
		// get task text
		$easy2_full = TasksPost::whereVariant($variant)->whereLevel(1)->whereMark(2)->take(1)->get()[0]; // take easy 2 ball task
		$easy2 = $easy2_full['description'];
		$easy2id = $easy2_full['task_id'];
		$easy3_full = TasksPost::whereVariant($variant)->whereLevel(1)->whereMark(3)->take(1)->get()[0]; // take easy 3 ball task
		$easy3 = $easy3_full['description'];
		$easy3id = $easy3_full['task_id'];
		$hard3_full = TasksPost::whereVariant($variant)->whereLevel(2)->whereMark(3)->take(1)->get()[0]; // take hard 3 ball task
		$hard3 = $hard3_full['description'];
		$hard3id = $hard3_full['task_id'];
		$hard4_full = TasksPost::whereVariant($variant)->whereLevel(2)->whereMark(4)->take(1)->get()[0]; // take hard 4 ball task
		$hard4 = $hard4_full['description'];
		$hard4id = $hard4_full['task_id'];
		if ($is_started['variant'] == null || $remake_work) {
			UserResultPost::updateOrInsert(['user_id' => $user_id],
			['variant' => $variant, 'task1easy_id' => $easy2id, 'task1hard_id' => $hard3id, 'task2easy_id' => $easy3id, 'task2hard_id' => $hard4id]);
		}
		// get task check sequences
		$easy2_seq = TestsequencePost::where('task_id', $easy2id)->get();
		$easy3_seq = TestsequencePost::where('task_id', $easy3id)->get();
		$hard3_seq = TestsequencePost::where('task_id', $hard3id)->get();
		$hard4_seq = TestsequencePost::where('task_id', $hard4id)->get();
		
		if( $easy2_full == null || $easy3_full == null || $hard3_full == null || $hard4_full == null )
			return null;
		
		return ['variant' => $variant, 'easy2' => $easy2, 'easy3' => $easy3, 'hard3' => $hard3, 'hard4' => $hard4,
				'easy2_seq' => json_encode($easy2_seq), 'easy3_seq' => json_encode($easy3_seq), 'hard3_seq' => json_encode($hard3_seq), 'hard4_seq' => json_encode($hard4_seq)];
	}
	
	public function Post_set_mark(Request $request){
		$user = Auth::user();
        $user_id = $user['id'];
		$mark1 = $request->input("mark1");
		$mark2 = $request->input("mark2");
		$sum_mark = $request->input("sum_mark");
		$user_code = $request->input("user_code");
		$date = date("Y-m-d H:i:s");
		UserResultPost::updateOrInsert(['user_id' => $user_id], ['mark_1' => $mark1, 'mark_2' => $mark2, 'sum_mark' => $sum_mark, 'user_code' => $user_code, 'date' => $date]);
	}
	
	//---------------------- work with tasks ------------------------- //
	
	public function Post_manage_task(){
		$tasks_and_sequences = TestsequencePost::leftJoin('tasks_post', function($join) {
												$join->on('testsequence_post.task_id', '=', 'tasks_post.task_id');})->get();
        $tasks_and_sequences = TasksController::magic($tasks_and_sequences);
        return view("algorithm.tasks.post.alltasks", compact('tasks_and_sequences'));
    }
	
	public function Post_add_task(){
		return view("algorithm.tasks.post.addtask");
	}
	
	public function Post_delete_task($task_id) {
		TasksPost::where('task_id', $task_id)->delete();
		TestsequencePost::where('task_id', $task_id)->delete();
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
		
		$created_task = TasksPost::Create(  ['level' => $level, 'mark' => $max_mark, 'variant' => $variant, 'description' => $task_text] );
		$task_id = $created_task['id'];
		TestsequencePost::Create( ['input_word' => $input_word,  'output_word' => $output_word,  'task_id' => $task_id] );
		TestsequencePost::Create( ['input_word' => $input_word1, 'output_word' => $output_word1, 'task_id' => $task_id] );
		TestsequencePost::Create( ['input_word' => $input_word2, 'output_word' => $output_word2, 'task_id' => $task_id] );
		TestsequencePost::Create( ['input_word' => $input_word3, 'output_word' => $output_word3, 'task_id' => $task_id] );
		TestsequencePost::Create( ['input_word' => $input_word4, 'output_word' => $output_word4, 'task_id' => $task_id] );
		
		return view("algorithm.tasks.post.addtask");
    }
  
	public function Post_edit_task($sequence_id) {
		$sequence = TestsequencePost::Where('sequence_id', $sequence_id)->get();
		$sequence = TasksController::magic($sequence)[0];
		return view("algorithm.tasks.post.edit", compact('sequence','sequence_id'));
	}
	
	public function Post_editing_task($sequence_id){
		$input_word6 = Request::input("input_word6");
		$output_word6 = Request::input("output_word6");
		TestsequencePost::where('sequence_id', $sequence_id)
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

    public function Post_editing_users(){

        $availability_input = (Request::input("fines") == null) ? [] : Request::input("fines");

        for ($i=0; $i < count(Request::input("id")); $i++){
           $availability = in_array(Request::input("id")[$i], $availability_input) ? 1 : 0;
           $user = Request::input("id")[$i];
		   UserResultPost::updateOrInsert([ 'user_id' => $user ], [ 'access' => $availability ]);
        }
		
        return redirect()->back();
    }
}
