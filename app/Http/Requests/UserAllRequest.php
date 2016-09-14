<?php

namespace App\Http\Requests;

use Auth;

class UserAllRequest extends Request
{
    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        return @Auth::user()->role === 'admin';
    }
}
