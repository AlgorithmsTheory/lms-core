<?php
namespace App\Http\Controllers;
use App\Group;
use App\Statements\CoursePlan;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\Passes\ControlWorkPasses;
use App\Statements\Passes\LecturePasses;
use App\Statements\Passes\SeminarPasses;
use App\Testing\Test;
use App\Testing\TestForGroup;
use App\TeacherHasGroup;
use App\Pass_plan;
use App\News;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
class AdministrationController extends Controller{

    const NEWS_FILE_DIR = 'download/news/';
    private $course_plan_DAO;


    public function __construct(CoursePlanDAO $course_plan_DAO)
    {
        $this->course_plan_DAO = $course_plan_DAO;
    }

    public function checkEmailIfExists(Request $request){
        $email = $request->input('email');
        $users = User::where('email' , $email)->get();
        if (count($users) != 0) {
            return "exists";
        } else {
            return "notExists";
        }
    }

    public function verify()
    {
        $groups = Group::where('archived', 0)->get();
        $user = Auth::user();
        if ($user['role'] == 'Админ')
        {
            $query = User::whereRole("")->join('groups', 'groups.group_id', '=', 'users.group')->where('groups.archived', 0)->orderBy('id', 'desc')->get();
        } else {
            $query = TeacherHasGroup::join('users', 'teacher_has_group.group', '=', 'users.group')->join('groups', 'groups.group_id', '=', 'users.group')->where('teacher_has_group.user_id', $user['id'])->where('users.role', '')->select('users.first_name', 'users.last_name', 'users.role', 'users.group', 'users.email', 'users.id', 'groups.group_name')->distinct()->get();
        }
        return view('personal_account/verify_students', compact('query', 'groups'));
    }

    public function change_role(){
        $groups = Group::where('archived', 0)->get();
        $query = User::join('groups', 'groups.group_id', '=', 'users.group', 'left outer')->where('groups.archived', 0)->orderBy('id', 'desc')->get();
        return view('personal_account/change_role', compact('query', 'groups'));
    }

    public function add_groups(){
        $groups = Group::orderBy('group_id', 'desc')->get();
        $course_plans = CoursePlan::all('id_course_plan', 'course_plan_name');
        return view('personal_account/add_groups', compact('groups', 'course_plans'));
    }

    public function add_group_to_set(Request $request){
        $name = $request->input('name');
        $description = $request->input('description');
        $id_course_plan = $request->input('id_course_plan');
        $validate = Group::whereGroup_name($name)->get();
        if(count($validate) == 0){
            Group::insert(['group_name' => $name, 'description' => $description, 'archived' => 0, 'id_course_plan' => $id_course_plan]);
            $group_id = Group::whereGroup_name($name)->select('group_id')->first()->group_id;
            Pass_plan::insert(['group' => $group_id]);

            // add group availability for active tests
            $active_tests = Test::whereArchived(0)->select('id_test')->get();
            foreach ($active_tests as $test) {
                TestForGroup::insert(['id_test' => $test['id_test'], 'id_group' => $group_id, 'availability' => 0]);
            }
        }
        return redirect()->route('group_set');
    }

    public function delete_group_from_set(Request $request){
        $id = json_decode($request->input('number'),true);
        Group::where('group_id', $id)->update(['archived' => 1]);
        return $id;
    }


    public function change_group(Request $request){
        $id = json_decode($request->input('id'),true);
        $value = $request->input('value');
        User::where('id', $id)->update(['group' => $value]);
        return 0;
    }

    public function change_l_name(Request $request){
        $id = json_decode($request->input('id'),true);
        $value = $request->input('value');
        User::where('id', $id)->update(['last_name' => $value]);
        return 0;
    }
    public function change_f_name(Request $request){
        $id = json_decode($request->input('id'),true);
        $value = $request->input('value');
        User::where('id', $id)->update(['first_name' => $value]);
        return 0;
    }

    public function manage_groups(){
        $teachers = User::whereRole("Преподаватель")->orderBy('id', 'desc')->get();
        $group_set = Group::where('archived', 0)->get();
        $groups = TeacherHasGroup::join('users', 'teacher_has_group.user_id', '=', 'users.id')
            ->join('groups', 'groups.group_id', '=', 'teacher_has_group.group')
            ->where('groups.archived', 0)
            ->select('teacher_has_group.user_id', 'teacher_has_group.group', 'teacher_has_group.id', 'users.first_name', 'users.last_name', 'groups.group_name')
            ->get();
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
        $news = new News();
        $news->body = $request->input('body');
        $news->title = $request->input('title');
        $news->is_visible = 1;
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                $file =  Input::file('file');
                $filename = mt_rand(0, 10000). '_' . $file->getClientOriginalName();
                $file->move($this::NEWS_FILE_DIR, $filename);
                $news->file_path = $this::NEWS_FILE_DIR . $filename;
            } else {
                return back()->withInput()->withErrors(['Ошибка при загрузке файла']);
            }
        }
        $news->save();
        return redirect()->route('manage_news');
    }

//Данные методы меняют роль выбранного юзера
    public function add_student(Request $request){
        $id = json_decode($request->input('id'),true);
        $user = User::find($id);
        //Если группа привязана к учебному плану, то создаём для студентов ведомости
        $group = Group::whereGroup_id($user->group)->first();
        $id_course_plan = $group->id_course_plan;
        if ($id_course_plan != null) {
            if ($user['role'] != 'Студент') {
                $user->role = 'Студент';
                $user->save();
                //Заполняем нулями ведомость по посещаемости лекций
                $all_lectures = $this->course_plan_DAO->getAllLectures($id_course_plan);
                foreach ($all_lectures as $lecture) {
                    LecturePasses::insert(['id_lecture_plan' => $lecture->id_lecture_plan,
                        'id_user' => $user->id, 'presence' => 0]);
                }

                //Заполняем нулями ведомость работы на семинаре
                $all_seminars = $this->course_plan_DAO->getAllSeminars($id_course_plan);
                foreach ($all_seminars as $seminar) {
                    SeminarPasses::insert(['id_seminar_plan' => $seminar->id_seminar_plan,
                        'id_user' => $user->id, 'presence' => 0, 'work_points' => 0]);
                }

                //Заполняем нулями итоговую ведомость
                $all_works = $this->course_plan_DAO->getAllControlWorks($id_course_plan)
                    ->merge($this->course_plan_DAO->getAllExamWorks($id_course_plan));
                foreach ($all_works as $control_work) {
                   ControlWorkPasses::insert(['id_control_work_plan' => $control_work->id_control_work_plan,
                        'id_user' => $user->id, 'presence' => 0, 'points' => 0]);
                }

            }
            return response()->json(['id' => $id]);
        }else {
            return response()->json(['error' => 'Назначьте учебный план для группы: ' . $group->group_name]);
        }
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