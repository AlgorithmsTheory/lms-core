<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class AddDefinitionRequest extends FormRequest {
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
            'definition_name' => "required|between:5,255",
            'definition_content' => 'required|between:5,1000',
            'name_anchor' => 'required_if:addLink,on',
            'id_lecture' => 'required_if:addLink,on',
        ];
    }
}
