<?php


namespace App\Statements;
use App\Group;
use Illuminate\Database\Eloquent\Model as Eloquent;




class CoursePlan extends Eloquent
{
    protected $table = 'course_plans';
    public $timestamps = false;
    protected $primaryKey = 'id_course_plan';
    protected $appends = ['section_plans', 'exam_plans', 'groups'];

    /** в новое поле section_plans вставляется массив (разделов) объектов SectionPlane */
    public function getSectionPlansAttribute(){
        $sectionPlans = SectionPlan::where('id_course_plan', $this->attributes['id_course_plan'])
            ->where('is_exam', '=', 0)
            ->get();
        return $sectionPlans->sortBy('section_num');
    }

    /** в новое поле section_plans вставляется массив (Экзаменов/Зачётов) объектов SectionPlane */
    public function getExamPlansAttribute(){
        $sectionPlans = SectionPlan::where('id_course_plan', $this->attributes['id_course_plan'])
            ->where('is_exam', '=', 1)
            ->get();
        return $sectionPlans->sortBy('id_section_plan');
    }

    /** в новое поле groups вставляется строка содержащая группы через пробел */
    public function getGroupsAttribute(){
        $groups = Group::select('group_name')->where('id_course_plan', $this->attributes['id_course_plan'])->get();
        $groups_string = '';
        foreach ($groups as $group) {
            $groups_string .= $group->group_name . ' ';
        }
        return $groups_string;
    }
}