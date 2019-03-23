<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 13.03.2019
 * Time: 19:02
 */

namespace App\Http\Requests\Statements;


use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
class AddCoursePlanRequest extends FormRequest {
    public function authorize() {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        if ($role == 'Админ'){
            return true;
        }else{
            return false;
        }

    }

    public function rules() {
        return [
            'course_plan_name' => "required|between:5,255",
            'course_plan_desc' => 'required|between:5,5000',
            'max_controls' => 'required|integer|between:0,100',
            'max_seminars' => 'required|integer|between:0,100',
            'max_seminars_work' => 'required|integer|between:0,100',
            'max_lecrures' => 'required|integer|between:0,100',
            'max_exam' => 'required|integer|between:0,100',
        ];
    }
}