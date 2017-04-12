<?php

namespace App\Http\Requests;

use Auth;

class UserAllRequest extends Request
{
    public function rules()
    {
        return [
            'status' => 'in:active,pending,inactive,deleted'
        ];
    }

    public function authorize()
    {
        return @Auth::user()->role === 'admin';
    }
}
