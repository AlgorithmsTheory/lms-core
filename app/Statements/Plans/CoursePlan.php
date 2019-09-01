<?php


namespace App\Statements\Plans;
use App\Group;
use Illuminate\Database\Eloquent\Model as Eloquent;

class CoursePlan extends Eloquent {
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

    /** в новое поле section_plans вставляется массив (Экзаменов/Зачётов) объектов SectionPlan */
    public function getExamPlansAttribute(){
        $sectionPlans = SectionPlan::where('id_course_plan', $this->attributes['id_course_plan'])
            ->where('is_exam', '=', 1)
            ->get();
        return $sectionPlans->sortBy('id_section_plan');
    }

    public function getGroupsAttribute(){
        return Group::select(['group_name', 'group_id'])->where('id_course_plan', $this->attributes['id_course_plan'])->get();
    }
}