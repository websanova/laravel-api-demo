<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserAllRequest;

class UserController extends Controller
{
    public function all(UserAllRequest $request)
    {
        $users = User::orderBy('created_at', 'desc')->limit(50)->get();

        return response([
            'status' => 'success',
            'data' => [
                'items' => $users
            ]
        ]);
    }
}