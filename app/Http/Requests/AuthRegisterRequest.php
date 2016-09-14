<?php

namespace App\Http\Requests;

class AuthRegisterRequest extends Request
{
    public function rules()
    {
        return [
            'username' => 'required|min:4|max:10|unique:users,username',
            'password' => 'required|min:4|max:10'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
