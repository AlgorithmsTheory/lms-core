<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.03.2019
 * Time: 17:46
 */

namespace App\Statements;
use App\Group;
use Illuminate\Database\Eloquent\Model as Eloquent;




class CoursePlan extends Eloquent
{
    protected $table = 'course_plans';
    public $timestamps = false;
    protected $primaryKey = 'id_course_plan';
    protected $appends = ['section_plans', 'groups'];

    /** в новое поле section_plans вставляется массив объектов SectionPlane */
    public function getSectionPlansAttribute(){
        $sectionPlans = SectionPlan::where('id_course_plan', $this->attributes['id_course_plan'])->get();
        return $sectionPlans->sortBy('section_num');
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