<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class AddEducationMaterialRequest extends FormRequest {
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
            'name' => "required|between:5,255",
            'education_material_file' => 'required|mimes:doc,pdf,docx',

        ];
    }
}
