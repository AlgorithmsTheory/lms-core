<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;

use Request;
use DateTime;
use DB;
class RecursionController extends Controller
{
    public function index()
    {
        return view('recursion.index');
    }
    public function magic($array) {
        return json_decode(json_encode($array), true);
    }
    public function main(){
        return view('algorithm.main');
    }

   /* public  function kontrRec($testId, $userId) {
        $userId = 'vasya'; //TODO : REMOVE THIS BULLSHIT

        $exists = DB::Select("SELECT * FROM `user_result_rec` WHERE `user_result_rec`.`test_id`='$testId' and `user_result_rec`.`user_id`='$userId'");
        $exists = json_decode(json_encode($exists), true);

        if (count($exists) == 0)
        {
            $result = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`level`='0' order by RAND() limit 1");
            $result = json_decode(json_encode($result), true)[0];
            $result2 = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`level`='1' order by RAND() limit 1");
            $result2 = json_decode(json_encode($result2), true)[0];
            $easyId = $result['id'];
            $hardId = $result2['id'];
            DB::INSERT("INSERT INTO `user_result_rec` VALUES ('$testId', '$userId', '$easyId', '$hardId', '0', '0', '0', '')");
            //$solved = False;
        }else{
            $easyId = $exists[0]['task_easy'];
            $hardId = $exists[0]['task_hard'];
            $result = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`id`='$easyId'");
            $result = json_decode(json_encode($result), true)[0];
            $result2 = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`id`='$hardId'");
            $result2 = json_decode(json_encode($result2), true)[0];
            // $solved = $exists[0]['is_solved'];

        }
        return view("recursion.kontrRec", compact('result', 'result2', 'solved', 'selectedTask', 'answer', 'mark'));
    }*/

      public function kontrRec($testId, $userId) {
            $userId = 'vasya'; //TODO : REMOVE THIS BULLSHIT
    
            $exists = DB::Select("SELECT * FROM `user_result_rec` WHERE `user_result_rec`.`test_id`='$testId' and `user_result_rec`.`user_id`='$userId'");
            $exists = json_decode(json_encode($exists), true);
    
            if (count($exists) == 0)
            {
                $result = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`level`='0' order by RAND() limit 1");
                $result = json_decode(json_encode($result), true)[0];
                $result2 = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`level`='1' order by RAND() limit 1");
                $result2 = json_decode(json_encode($result2), true)[0];
                $easyId = $result['id'];
                $hardId = $result2['id'];
                DB::INSERT("INSERT INTO `user_result_rec` VALUES ('$testId', '$userId', '$easyId', '$hardId', '0', '0', '0', '')");
                $solved = False;
            }else{
                $easyId = $exists[0]['task_easy'];
                $hardId = $exists[0]['task_hard'];
                $result = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`id`='$easyId'");
                $result = json_decode(json_encode($result), true)[0];
                $result2 = DB::Select("SELECT * FROM `rectask` WHERE `rectask`.`id`='$hardId'");
                $result2 = json_decode(json_encode($result2), true)[0];
                $solved = $exists[0]['is_solved'];
            }

           if ($solved) {
               $answer = $exists[0]['answer'];
               $selectedTask = $exists[0]['selected_task'];
               $mark = $exists[0]['mark'];
           }else {
               $answer = '';
               $selectedTask = '';
               $mark = '';
           }
           return view("recursion.kontrRec", compact('result', 'result2', 'solved', 'selectedTask', 'answer', 'mark', 'userId', 'testId'));
       }

    public function solve() {
        $mark = Request::input('mark');
        $selected = Request::input('selected');
        $answer = Request::input('rec_func');
        $userId = Request::input('user_id');
        $testId = Request::input('test_id');
        //echo "mark: ".$mark." selected: ".$selected." answer: ".$answer." userId: ".$userId." testId: ".$testId; # TODO: remove
        DB::Update("UPDATE `user_result_rec` SET `mark`='$mark', `selected_task`='$selected', `is_solved`='1', `answer`='$answer' where `test_id`='$testId' and `user_id`='$userId' ");
        return $this->kontrRec($testId, $userId);
    }

    //  public function kontrtask(){
    //TODO: сюда нужна авторизация для пользователя
    // $result = DB::Select("SELECT `rectask`.`task`, `rectask`.`level`, `rectask`.`mark` FROM `rectask` WHERE `rectask`.`level`='0' order by RAND() limit 1");

    //$row = $result->first();
    //return view("recursion.kontrRec", compact('result'));
    // }

    
  //  public function kontrtask(){
        //TODO: сюда нужна авторизация для пользователя
       // $result = DB::Select("SELECT `rectask`.`task`, `rectask`.`level`, `rectask`.`mark` FROM `rectask` WHERE `rectask`.`level`='0' order by RAND() limit 1");
        
        //$row = $result->first();
        //return view("recursion.kontrRec", compact('result'));
   // }

    public function indexrec(){
        $success = false;
        $tasks = DB::select("SELECT * FROM `rectask`");
        $tasks = RecursionController::magic($tasks);
        return view("recursion.alltasksrec", compact('tasks'));
    }
    public function addtaskrec(){
        $success = false;
        return view("recursion.addtaskrec", compact('success'));
    }
    public function addingrec(){
        $task_text = Request::input('task_text');
        $max_mark = Request::input('max_mark');
        $level = Request::input('level');
        $result1 = DB::insert(  "INSERT INTO `rectask` (task, level, mark) 
                                        VALUES('$task_text','$level','$max_mark')");
        $results = DB::select('SELECT * from `rectask`');
        $results = RecursionController::magic($results);
        $success = true;
          return view("recursion.addtaskrec", compact('success'));
    }
    public function editrec($id){

        $result = DB::select("SELECT * from `rectask` WHERE id=".$id);
        $result = RecursionController::magic($result)[0];
        return view("recursion.editrec", compact('result','id'));
    }
    public function editTaskrec($id){

        $task = Request::input("task");
        $mark = Request::input("mark");
        $level = Request::input("level");
        $query3 = DB::update("UPDATE `rectask` SET `task`='$task', `mark`='$mark', `level`='$level' where `id`=".$id);
        $query3 = RecursionController::magic($query3);
        $tasks = DB::select('SELECT * FROM `rectask`');
        $tasks = RecursionController::magic($tasks);
        return view("recursion.alltasksrec", compact('tasks'));
    }
    public function deleteTaskrec($id){

        $result = DB::select("SELECT * from rectask WHERE rectask.id=".$id);
        $result = RecursionController::magic($result);
        DB::delete("DELETE FROM `rectask` WHERE rectask.id=".$id);
        $tasks = DB::select("SELECT * FROM `rectask` ");
        $tasks = RecursionController::magic($tasks);
        return view("recursion.alltasksrec", compact('tasks'));
    }
    public function get_rec_protocol(Request $request){
        $user = Auth::user();
        if ($request->ajax()) {
            $protocol = new RecProtocol("recursion", $user['id'], $request->input('id_user'), $request->input('html_text'));
            $protocol->create();
            return;
        }
    }
}