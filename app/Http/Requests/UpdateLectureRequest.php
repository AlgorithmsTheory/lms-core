<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class UpdateLectureRequest extends FormRequest {
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
            'lecture_name' => "required|between:5,255",
            'lecture_text' => 'min:10',
            'doc_file' => 'mimes:doc,docx',
            'ppt_file' => 'mimes:ppt,pptx'
        ];
    }
}
