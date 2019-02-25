<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class UpdateDefinitionRequest extends FormRequest
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
            'definition_name' => "required|between:5,255",
            'definition_content' => 'required|between:10,1000',
            'name_anchor' => 'min:2',
        ];
    }
}
