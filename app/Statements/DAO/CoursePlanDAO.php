<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 10.03.2019
 * Time: 20:40
 */

namespace App\Statements\DAO;

use App\Http\Requests\Statements\AddCoursePlanRequest;
use App\Statements\CoursePlan;

class CoursePlanDAO
{

    public function allCoursePlan() {
        $coursePlans = CoursePlan::all();
        return  $coursePlans;
    }

    public function getCoursePlan($id){
        $coursePlan = CoursePlan::where('id_course_plan', $id)->first();
        return $coursePlan;
    }

    public function storeCoursePlan(AddCoursePlanRequest $request){
        $coursePlane = new CoursePlan();
        $coursePlane->course_plan_name = $request->course_plan_name;
        $coursePlane->course_plan_desc = $request->course_plan_desc;
        $coursePlane->max_controls = $request->max_controls;
        $coursePlane->max_seminars = $request->max_seminars;
        $coursePlane->max_seminars_work = $request->max_seminars_work;
        $coursePlane->max_lecrures = $request->max_lecrures;
        $coursePlane->max_exam = $request->max_exam;
        $coursePlane->save();
        return $coursePlane->id_course_plan;
    }


//    public function updateDefinition(UpdateDefinitionRequest $request, $id){
//        $definition = Definition::findOrFail($id);
//        $definition->name = $request->definition_name;
//        $definition->content = $request->definition_content;
//        if ($request->id_lecture == null || $request->name_anchor == null) {
//            $definition->id_lecture = null;
//            $definition->name_anchor = null;
//        } else {
//            $definition->id_lecture = $request->id_lecture;
//            $definition->name_anchor = $request->name_anchor;
//        }
//        $definition->save();
//    }
//
//    public function deleteDefinition($id){
//        $definition = Definition::findOrFail($id);
//        $definition->delete();
//    }
}