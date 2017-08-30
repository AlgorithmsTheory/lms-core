<?php
namespace App\Http\Controllers;
use App\Classwork;
use App\Group;
use App\Controls;
use App\Lectures;
use App\Seminars;
use App\Totalresults;
use App\Statements_progress;
use App\TeacherHasGroup;
use App\Pass_plan;
use App\News;
use App\User;
use Auth;
use Illuminate\Http\Request;

class APIController extends Controller{

    public function getGroupList(){
        $groups = Group::get();
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($groups, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getStudentsFromGroup($group_id){
        $students = User::where('group', $group_id)->get();
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($students, 200, $headers, JSON_UNESCAPED_UNICODE);
    }
}