<?php
namespace App\Http\Controllers;
use App\Group;
use App\User;
use App\Face;


class APIController extends Controller{

    public function getGroupList(){
        $groups = Group::where('archived', 0)->get();
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($groups, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function getStudentsFromGroup($group_id){
        if ($group_id == 'all') {
            $students = User::whereIn('role', ['АДМИН', 'СТУДЕНТ'])->get();
            $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
            return response()->json($students, 200, $headers, JSON_UNESCAPED_UNICODE);
        } else {
            $students = User::where('group', $group_id)->whereIn('role', ['АДМИН', 'СТУДЕНТ'])->get();
            $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
            return response()->json($students, 200, $headers, JSON_UNESCAPED_UNICODE);
        }
    }

    public function addStudentFace($student_id, $person_id, $group_id, $pswd){
        if($pswd == "mephiisthebest") {
            Face::insert(['student_id' => $student_id, 'person_id' => $person_id, 'azure_group_id' => $group_id]);
            $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
            return response()->json(0, 200, $headers, JSON_UNESCAPED_UNICODE);
        } else {
            $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
            return response()->json(-1, 200, $headers, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getStudentFace($student_id){
        $face = Face::where('student_id', $student_id)->get()->first();
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($face, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function deleteAzureGroup($group_id, $pswd){
        if($pswd == "mephiisthebest") {
            Face::where('azure_group_id', $group_id)->delete();
            $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
            return response()->json("success", 200, $headers, JSON_UNESCAPED_UNICODE);
        } else {
            $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
            return response()->json("error", 200, $headers, JSON_UNESCAPED_UNICODE);
        }
    }
}