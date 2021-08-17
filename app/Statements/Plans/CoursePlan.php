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

    public function getMaxes() {
        $max_control = 0;
        $max_ball_gen = 0;
        $max_seminar_pass_ball_gen = 0;
        $max_lecture_ball_gen = 0;
        $max_exam_gen = 0;
        $sections = $this->getSectionPlansAttribute();
        foreach ($sections as $section) {
            $max_ball_gen += $section->max_ball;
            $max_seminar_pass_ball_gen += $section->max_seminar_pass_ball;
            $max_lecture_ball_gen += $section->max_lecture_ball;
            $cw_ar = $section->getControlWorkPlansAttribute();
            foreach ($cw_ar as $cw) {
                $max_control += $cw->max_points;
            }
        }
        $exam_sections = $this->getExamPlansAttribute();
        foreach ($exam_sections as $exam_section) {
            $cw_ar = $exam_section->getControlWorkPlansAttribute();
            foreach ($cw_ar as $cw) {
                $max_exam_gen += $cw->max_points;
            }
        }
        return ['max_control' => $max_control,
            'max_ball_gen' => $max_ball_gen,
            'max_seminar_pass_ball_gen' => $max_seminar_pass_ball_gen,
            'max_lecture_ball_gen' => $max_lecture_ball_gen,
            'max_exam_gen' => $max_exam_gen];
    }
}