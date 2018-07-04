<?php
namespace App\Http\Controllers;
use App\Seminars;
use App\Group;
use App\User;
use Illuminate\Http\Request;


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

    public function checkStudentsAtSeminar(Request $request) {
        $classNumber = $request->input('classNumber');
        $ids = $request->input('students');
        $pass = $request->input('passToken');

        if ($pass == 'mephiisthebest') {
            foreach ($ids as $id){
                Seminars::where('userID', $id)->update(["col" . $classNumber => 1]);
            }
        } else { return -1; }

        return 0;
    }
}
