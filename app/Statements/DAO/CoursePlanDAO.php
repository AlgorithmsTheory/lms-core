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

class CoursePlanDAO {

    public function allCoursePlan() {
        $course_plans = CoursePlan::all();
        return  $course_plans;
    }

    public function getCoursePlan($id){
        $course_plan = CoursePlan::where('id_course_plan', $id)->first();
        return $course_plan;
    }

    public function storeCoursePlan(AddCoursePlanRequest $request){
        $course_plane = new CoursePlan();
        $course_plane->course_plan_name = $request->input('course_plan_name');
        $course_plane->course_plan_desc = $request->input('course_plan_desc');
        $course_plane->max_controls = $request->input('max_controls');
        $course_plane->max_seminars = $request->input('max_seminars');
        $course_plane->max_seminars_work = $request->input('max_seminars_work');
        $course_plane->max_lecrures = $request->input('max_lecrures');
        $course_plane->max_exam = $request->input('max_exam');
        $course_plane->save();
        return $course_plane->id_course_plan;
    }



}