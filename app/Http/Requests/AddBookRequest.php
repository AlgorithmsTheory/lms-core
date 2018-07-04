<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class AddBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        if ($role == 'Админ'){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        \Validator::extend('uniqueFirstAndLastName', function ($attribute, $value, $parameters, $validator) {
        $count = \DB::table('book')->where('title', $value)
            ->where('author', $parameters[0])
            ->count();

        return $count === 0;
    });

        return [
            'title' => 'required|between:5,150',
            'author' => 'required|between:5,50',
            'description' => 'required|between:30,1000',
            'format' => 'required|between:5,30',
            'publisher' => 'required|between:5,30',
            'picture' => ['image','required'],


        ];
    }
}
