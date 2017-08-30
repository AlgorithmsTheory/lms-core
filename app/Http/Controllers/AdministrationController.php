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
use Session;
class AdministrationController extends Controller{

    public function pashalka(){
        return view('personal_account/pashalka');
    }

    public function verify()
    {
        $user = Auth::user();
        if ($user['role'] == 'Админ')
        {
            $query = User::whereRole("")->orderBy('id', 'desc')->get();
        } else {
            $query = TeacherHasGroup::join('users', 'teacher_has_group.group', '=', 'users.group')->where('teacher_has_group.user_id', $user['id'])->select('users.first_name', 'users.last_name', 'users.role', 'users.group', 'users.email')->get();
        }
        return view('personal_account/verify_students', compact('query'));
    }

    public function change_role(){
        $query = User::orderBy('id', 'desc')->get();
        return view('personal_account/change_role', compact('query'));
    }

    public function add_groups(){
        $groups = Group::get();
        return view('personal_account/add_groups', compact('groups'));
    }

    public function add_group_to_set(Request $request){
        $number = $request->input('number');
        $faculty = $request->input('faculty');
        $department = $request->input('department');
        $validate = Group::whereNumber($number)->get();
        if(count($validate) == 0){
            Group::insert(['number' => $number, 'faculty' => $faculty, 'department' => $department]);
            Pass_plan::insert(['group' => $number]);
        }
        return redirect()->route('group_set');
    }

    public function delete_group_from_set(Request $request){
        $id = json_decode($request->input('number'),true);
        Group::where('number', $id)->delete();
        Pass_plan::where('group', $id)->delete();
        TeacherHasGroup::where('group', $id)->delete();
        return $id;
    }


    public function change_group(Request $request){
        $id = json_decode($request->input('id'),true);
        $value = $request->input('value');
        User::where('id', $id)->update(['group' => $value]);
        return 0;
    }

    public function manage_groups(){
        $teachers = User::whereRole("Преподаватель")->orderBy('id', 'desc')->get();
        $group_set = Group::get();
        $groups = TeacherHasGroup::join('users', 'teacher_has_group.user_id', '=', 'users.id')->select('teacher_has_group.user_id', 'teacher_has_group.group', 'teacher_has_group.id', 'users.first_name', 'users.last_name')->get();
        return view('personal_account/manage_groups', compact('teachers', 'groups', 'group_set'));
    }

    public function manage_news(){
        $news = News::get();
        return view('personal_account/manage_news', compact('news'));
    }

    public function delete_group(Request $request){
        $id = json_decode($request->input('id'),true);
        TeacherHasGroup::where('id', $id)->delete();
        return $id;
    }

    public function delete_news(Request $request){
        $id = json_decode($request->input('id'),true);
        News::where('id', $id)->delete();
        return $id;
    }

    public function hide_news(Request $request){
        $id = json_decode($request->input('id'),true);
        $news = News::where('id', $id)->first();
        if ( $news['is_visible'] == 0){
            News::where('id', $id)->update(['is_visible' => 1]);
        } else {
            News::where('id', $id)->update(['is_visible' => 0]);
        }
        return $id;
    }

    public function add_group(Request $request){
        $teacher = $request->input('teacher');
        $group = $request->input('group');
        TeacherHasGroup::insert(['user_id' => $teacher, 'group' => $group]);
        return redirect()->route('manage_groups');
    }

    public function add_news(Request $request){
        $title = $request->input('title');
        $body = $request->input('body');
        News::insert(['title' => $title, 'body' => $body, 'is_visible' => 1]);
        return redirect()->route('manage_news');
    }

//Данные методы меняют роль выбранного юзера
    public function add_student(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        if($user['role'] != 'Студент') {
            $user->role = 'Студент';
            $user->save();

//Добавляем новую запись в ведомости по лекциям
            $lectures = new Lectures();
            $lectures->userID = $id;
            $lectures->group = $user->group;
            $lectures->save();

//Добавляем новую запись в ведомости по лекциям
            $seminars = new Seminars();
            $seminars->userID = $id;
            $seminars->group = $user->group;
            $seminars->save();

//Добавляем новую запись в ведомости по лекциям
            $classwork = new Classwork();
            $classwork->userID = $id;
            $classwork->group = $user->group;
            $classwork->save();

//Добавляем новую запись в ведомости по контрольным
            $controls = new Controls();
            $controls->userID = $id;
            $controls->group = $user->group;
            $controls->save();

//Добавляем новую запись в итоговые ведомости
            $total = new Totalresults();
            $total->userID = $id;
            $total->group = $user->group;
            $total->save();

//Добавляем новую запись в итоговые ведомости
            $progress = new Statements_progress();
            $progress->userID = $id;
            $progress->group = $user->group;
            $progress->save();
        }
        return $id;
    }
    public function add_admin(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        if($user['role'] != 'Админ') {
            $user->role = 'Админ';
            $user->save();
        }
        return $id;
    }
    public function add_average(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        if($user['role'] != 'Обычный') {
            $user->role = 'Обычный';
            $user->save();
        }
        return $id;
    }

    public function add_tutor(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        if($user['role'] != 'Преподаватель') {
            $user->role = 'Преподаватель';
            $user->save();
        }
        return $id;
    }

    public static function getAdminPanel(){
        return view('personal_account/adminPanel');
    }
}