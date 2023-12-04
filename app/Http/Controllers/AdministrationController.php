<?php
namespace App\Http\Controllers;
use App\Group;
use App\Statements\Plans\CoursePlan;
use App\Statements\DAO\CoursePlanDAO;
use App\Statements\Passes\ControlWorkPasses;
use App\Statements\Passes\LecturePasses;
use App\Statements\Passes\SeminarPasses;
use App\Testing\Test;
use App\Testing\TestForGroup;
use App\TeacherHasGroup;
use App\News;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Log;

class AdministrationController extends Controller{
    const NEWS_FILE_DIR = 'download/news/';
    private $course_plan_DAO;


    public function __construct(CoursePlanDAO $course_plan_DAO){
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
        if (empty($id_course_plan)) {
            $id_course_plan = null;
        }
        $validate = Group::whereGroup_name($name)->get();
        if(count($validate) == 0){
            Group::insert(['group_name' => $name, 'description' => $description, 'archived' => 0, 'id_course_plan' => $id_course_plan]);
            $group_id = Group::whereGroup_name($name)->select('group_id')->first()->group_id;

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

    public function remove_user(Request $request){
        $id = json_decode($request->input('id'),true);
        User::find($id)->delete();
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
        $teachers = User::
            join('groups', 'groups.group_id', '=', 'users.group')
            ->where('users.role', 'Преподаватель')
            ->where('groups.archived', 0)
            ->orderBy('id', 'desc')->get();
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
        $validator = $this->getValidateAddStudent($id_course_plan, $group);
        if ($validator->passes()) {
            if ($user['role'] != 'Студент') {
                $user->role = 'Студент';
                $user->save();
                //Проверка, что ведомости для студента были созданы, для случая изменения роли пользователя с возвратом на "студент" (чтоб дубликатов не было)
                if (! LecturePasses::where('id_user', '=', $user->id)->exists()) {
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

            }
            return response()->json(['id' => $id]);
        }else {
            return response()->json(['errors' => $validator->errors()->all(), 'id' => $id]);
        }
    }

    public function getValidateAddStudent($id_course_plan, $group) {
        $validator = Validator::make(['id_course_plan' => $id_course_plan,
                                    ['group_name' => $group->group_name]], []);
        $validator->after(function ($validator) {
            $id_course_plan = $validator->getData()['id_course_plan'];
            $group_name = $validator->getData()['group_name'];
            if($id_course_plan == null) {
                $validator->errors()->add('without_course_plan', 'Назначьте учебный план для группы: ' . $group_name);
            } else {
                if (!CoursePlanDAO::checkPointsCoursePlan($id_course_plan)->passes()) {
                $course_plan_name = CoursePlan::where('id_course_plan', $id_course_plan)
                    ->first()->course_plan_name;
                $validator->errors()->add('not_valid_points', 'Баллы учебного плана('.$course_plan_name.') не корректны');
                }
            }
        });
        return $validator;
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

    // -------------------------
    // BEGIN manage groups elite
    // -------------------------

    private function getData(Request $request) {
        return json_decode($request->input('data'), false);
    }

    private function convertTeacher($teacher) {
        return [
            'id' => $teacher->id,
            'lastName' => $teacher->last_name,
            'firstName' => $teacher->first_name,
        ];
    }

    private function convertGroup($group) {
        return [
            'id' => $group->group_id,
            'name' => $group->group_name,
        ];
    }

    /**
     * returns [
     *  {
     *      id,
     *      lastName,
     *      firstName,
     *  },
     *  ...
     * ]
     */
    private function loadTeachers($teacherIds = null) {
        $teachers = User::
            join('groups', 'groups.group_id', '=', 'users.group')
            ->where('groups.group_name', 'Админы')
            ->where('users.role', 'Преподаватель');
        if ($teacherIds !== null) {
            $teachers = $teachers->whereIn('users.id', $teacherIds);
        }
        return $teachers
            ->orderBy('users.id', 'desc')
            ->get()
            ->map(function($x) {
                return $this->convertTeacher($x);
            })
            ->values();
    }

    /**
     * returns null or
     *  {
     *      id,
     *      lastName,
     *      firstName,
     *  }
     */
    private function loadTeacher($teacherId) {
        $teachers = $this->loadTeachers([$teacherId]);
        if (count($teachers) <= 0) {
            return null;
        }
        return $teachers[0];
    }

    /**
     * returns [
     *  {
     *      id,
     *      name,
     *  },
     *  ...
     * ]
     */
    private function loadGroups($groupIds = null) {
        $groups = Group::
            where('archived', 0)
            ->where('group_name', '!=', 'Админы');
        if ($groupIds !== null) {
            $groups = $groups->whereIn('group_id', $groupIds);
        }
        return $groups
            ->orderBy('group_id', 'desc')
            ->get()->map(function ($x) {
                return $this->convertGroup($x);
            })->values();
    }

    /**
     * returns null or
     *  {
     *      id,
     *      name,
     *  }
     */
    private function loadGroup($groupId) {
        $groups = $this->loadGroups([$groupId]);
        if (count($groups) <= 0) {
            return null;
        }
        return $groups[0];
    }

    private function loadTeachersByGroup($groupId) {
        $teacherIds = TeacherHasGroup::
            where('group', $groupId)
            ->get()
            ->map(function ($x) {
                return $x->user_id;
            })
            ->values();
        return $this->loadTeachers($teacherIds);
    }

    private function loadGroupsByTeacher($teacherId) {
        $groupIds = TeacherHasGroup::
            where('user_id', $teacherId)
            ->get()
            ->map(function ($x) {
                return $x->group;
            })
            ->values();
        return $this->loadGroups($groupIds);
    }

    public function manage_groups_elite() {
        $groupsSrc = $this->loadGroups();
        $groups = [];
        foreach ($groupsSrc as $group) {
            $groups[] = array_merge($group, [
                'teachers' => $this->loadTeachersByGroup($group['id']),
            ]);
        }
        return view('personal_account/manage_groups_elite', compact('groups'));
    }

    public function manage_groups_by_teachers_elite() {
        $teachersSrc = $this->loadTeachers();
        $teachers = [];
        foreach ($teachersSrc as $teacher) {
            $teachers[] = array_merge($teacher, [
                'groups' => $this->loadGroupsByTeacher($teacher['id']),
            ]);
        }
        return view('personal_account/manage_groups_by_teachers_elite', compact('teachers'));
    }

    public function mge_other_teachers(Request $request) {
        $data = $this->getData($request);
        $groupId = $data->groupId;

        $group = $this->loadGroup($groupId);
        $allTeachers = $this->loadTeachers();
        $groupTeachers = $this->loadTeachersByGroup($groupId);
        $otherTeachers = $this->subtract($allTeachers, $groupTeachers);

        $res = [
            'group' => $group,
            'otherTeachers' => $otherTeachers,
        ];
        return response()->json($res);
    }
    
    public function mge_other_groups(Request $request) {
        $data = $this->getData($request);
        $teacherId = $data->teacherId;

        $teacher = $this->loadTeacher($teacherId);
        $allGroups = $this->loadGroups();
        $teacherGroups = $this->loadGroupsByTeacher($teacherId);
        $otherGroups = $this->subtract($allGroups, $teacherGroups);

        $res = [
            'teacher' => $teacher,
            'otherGroups' => $otherGroups,
        ];
        return response()->json($res);
    }

    public function mge_add_teachers_to_group(Request $request) {
        $data = $this->getData($request);
        $groupId = $data->groupId;
        $teacherIds = $data->teacherIds;
        foreach ($teacherIds as $id) {
            TeacherHasGroup::insert(['user_id' => $id, 'group' => $groupId]);
        }
        $teachers = $this->loadTeachersByGroup($groupId);
        return response()->json($teachers);
    }

    public function mge_add_groups_to_teacher(Request $request) {
        $data = $this->getData($request);
        $teacherId = $data->teacherId;
        $groupIds = $data->groupIds;
        foreach ($groupIds as $id) {
            TeacherHasGroup::insert(['user_id' => $teacherId, 'group' => $id]);
        }
        $groups = $this->loadGroupsByTeacher($teacherId);
        return response()->json($groups);
    }

    public function mge_remove_teacher_from_group(Request $request) {
        $data = $this->getData($request);
        $groupId = $data->groupId;
        $teacherId = $data->teacherId;
        $this->remove_group_teacher_link($groupId, $teacherId);
        $teachers = $this->loadTeachersByGroup($groupId);
        return response()->json($teachers);
    }
    
    public function mge_remove_group_from_teacher(Request $request) {
        $data = $this->getData($request);
        $groupId = $data->groupId;
        $teacherId = $data->teacherId;
        $this->remove_group_teacher_link($groupId, $teacherId);
        $groups = $this->loadGroupsByTeacher($teacherId);
        return response()->json($groups);
    }

    private function remove_group_teacher_link($groupId, $teacherId) {
        TeacherHasGroup::
            whereUserId($teacherId)
            ->whereGroup($groupId)
            ->delete();
    }

    private function subtract($aCollection, $bCollection) {
        return $aCollection->filter(function($a) use ($bCollection) {
            return !$bCollection->contains('id', $a['id']);
        })->values();
    }

    /*
    public function mge_other_groups(Request $request) {
        $data = $this->getData($request);
        $groupId = $data->groupId;

        $group = $this->loadGroup($groupId);
        $allTeachers = $this->getTeachers();
        $groupTeachers = $this->getTeachersByGroup($groupId);
        $otherTeachers = $this->excludeTeachers($allTeachers, $groupTeachers);

        $res = [
            'group' => [
                'id' => $group->group_id,
                'name' => $group->group_name,
            ],
            'otherTeachers' => $otherTeachers->values(),
        ];
        return response()->json($res);
    }

    public function mge_add_groups_to_teacher(Request $request) {
        $data = $this->getData($request);
        $groupIds = $data->groupIds;
        $teacherId = $data->teacherId;
        foreach ($groupIds as $id) {
            TeacherHasGroup::insert(['user_id' => $teacherId, 'group' => $id]);
        }
        $groups = $this->getGroupsByTeacher($teacherId);
        return response()->json($groups->values());
    }

    private function getGroup($id) {
        return Group::
            whereGroupId($id)
            ->first();
    }

    private function getGroups() {
        return Group::
            where('archived', 0)
            ->where('group_name', '!=', 'Админы')
            ->orderBy('group_id', 'desc')
            ->get();
    }

    private function getGroupsByTeacher($teacherId) {
        return TeacherHasGroup::
            join('groups', 'teacher_has_group.group', '=', 'groups.group_id')
            ->where('teacher_has_group.user_id', $teacherId)
            ->where('groups.archived', 0)
            ->where('groups.group_name', '!=', 'Админы')
            ->orderBy('groups.group_name')
            ->select('groups.group_id', 'groups.group_name')
            ->get();
    }

    private function getTeachers() {
        return User::
            join('groups', 'groups.group_id', '=', 'users.group')
            ->where('users.role', 'Преподаватель')
            ->where('groups.archived', 0)
            ->orderBy('id', 'desc')
            ->get();
    }

    private function getTeachersByGroup($groupId) {
        return TeacherHasGroup::
            join('users', 'teacher_has_group.user_id', '=', 'users.id')
            ->where('teacher_has_group.group', $groupId)
            ->orderBy('users.last_name')
            ->orderBy('users.first_name')
            ->select('users.id', 'users.first_name', 'users.last_name')
            ->get();
    }

    private function excludeTeachers($allTeachers, $someTeachers) {
        return $allTeachers->filter(function($t) use ($someTeachers) {
            return !$someTeachers->contains('id', $t->id);
        });
    }
    */

    // -------------------------
    // END manage groups elite
    // -------------------------
}
