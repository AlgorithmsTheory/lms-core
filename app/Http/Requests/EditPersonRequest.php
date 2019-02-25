<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class EditPersonRequest extends FormRequest
{
    public function authorize()
    {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        if ($role == 'Админ'){
            return true;
        }else{
            return false;
        }

    }

    public function rules()
    {
        return [
            'name_person' => "required|between:5,255",
            'year_birth' => 'date_format:Y|size:4',
            'year_death' => 'date_format:Y|size:4',
            'person_text' => 'required|min:10',
            'picture' => 'image',
        ];
    }
}
