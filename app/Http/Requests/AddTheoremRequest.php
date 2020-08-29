<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class AddTheoremRequest extends FormRequest {
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
            'name_anchor' => 'required_if:addLink,on',
            'id_lecture' => 'required_if:addLink,on',
            'theorem_name' => "between:5,255",
            'theorem_content' => 'required|between:10,1000',
        ];
    }
}
