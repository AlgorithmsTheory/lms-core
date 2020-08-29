<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
class AddBookRequest extends FormRequest {
    public function authorize() {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        if ($role == 'Админ'){
            return true;
        }else{
            return false;
        }

    }

    public function rules() {
        \Validator::extend('uniqueFirstAndLastName', function ($attribute, $value, $parameters, $validator) {
        $count = \DB::table('book')->where('title', $value)
            ->where('author', $parameters[0])
            ->count();

        return $count === 0;
    });

        return [
            'book_title' => "required|between:5,255",
            'book_author' => 'required|between:5,255',
            'book_description' => 'required|between:10,3000',
            'book_format' => 'required|between:5,255',
            'book_publisher' => 'required|between:5,255',
            'picture' => 'required|image',
            'book_genre_id' => 'required',
        ];
    }
}
