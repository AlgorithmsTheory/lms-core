<?php
namespace App\Http\Controllers;
use App\Classwork;
use App\Controls;
use App\Lectures;
use App\Seminars;
use App\Totalresults;
use App\Statements_progress;
use App\TeacherHasGroup;
use App\News;
use App\User;
use Illuminate\Http\Request;

class AdministrationController extends Controller{

    public function pashalka(){
        return view('personal_account/pashalka');
    }

    public function verify(){
        $query = User::whereRole("")->orderBy('id', 'desc')->get();
        return view('personal_account/verify_students', compact('query'));
    }

    public function change_role(){
        $query = User::orderBy('id', 'desc')->get();
        return view('personal_account/change_role', compact('query'));
    }

    public function change_group(Request $request){
        $id = json_decode($request->input('id'),true);
        $value = $request->input('value');
        $user = User::where('id', $id)->update(['group' => $value]);
        return 0;
    }

    public function manage_groups(){
        $teachers = User::whereRole("Преподаватель")->orderBy('id', 'desc')->get();
        $groups = TeacherHasGroup::join('users', 'teacher_has_group.user_id', '=', 'users.id')->select('teacher_has_group.user_id', 'teacher_has_group.group', 'teacher_has_group.id', 'users.first_name', 'users.last_name')->get();
        return view('personal_account/manage_groups', compact('teachers', 'groups'));
    }

    public function manage_news(){
        $news = News::get();
        return view('personal_account/manage_news', compact('news'));
    }

    public function delete_group(Request $request){
        $id = json_decode($request->input('id'),true);
        $group = TeacherHasGroup::where('id', $id)->delete();
        return $id;
    }

    public function delete_news(Request $request){
        $id = json_decode($request->input('id'),true);
        $group = News::where('id', $id)->delete();
        return $id;
    }

    public function add_group(Request $request){
        $teacher = $request->input('teacher');
        $group = $request->input('group');
        $teacher_group = TeacherHasGroup::insert(['user_id' => $teacher, 'group' => $group]);
        return redirect()->route('manage_groups');
    }

    public function add_news(Request $request){
        $title = $request->input('title');
        $body = $request->input('body');
        $news = News::insert(['title' => $title, 'body' => $body]);
        return redirect()->route('manage_news');
    }

//Данные методы меняют роль выбранного юзера
    public function add_student(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
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

        return $id;
    }
    public function add_admin(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        $user->role = 'Админ';
        $user->save();
        return $id;
    }
    public function add_average(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        $user->role = 'Обычный';
        $user->save();
        return $id;
    }

    public function add_tutor(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        $user->role = 'Преподаватель';
        $user->save();
        return $id;
    }

    public static function getAdminPanel(){
        return view('personal_account/adminPanel');
    }
}