<?php

namespace App\Http\Controllers\Api\v1;

use Auth;
use JWTAuth;
use Socialite;
use JWTFactory;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Auth\Access\AuthorizationException;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = new User;
        $user->username = $request->get('username');
        $user->password = \Hash::make($request->get('password'));
        $user->save();

        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }

        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);
    }

    public function loginOther(Request $request)
    {
        $user = User::find($request->get('id'));

        if ( ! $token = JWTAuth::fromUser($user)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 404);
        }

        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);

        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function logout()
    {
        // JWTAuth::invalidate();

        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function facebook(Request $request)
    {
        return $this->_social($request, 'facebook', function ($user) {
            return (object) [
                // 'id' => $user->id,
                // 'email' => $user->user['email'],
                // 'first_name' => $user->user['first_name'],
                // 'last_name' => $user->user['last_name'],
                // 'photo_url' => $user->avatar . '&width=1200'
            ];
        });
    }

    public function google(Request $request)
    {
        return $this->_social($request, 'google', function ($user) {
            return (object) [
                // 'id' => $user->id,
                // 'email' => $user['emails'][0]['value'],
                // 'first_name' => $user['name']['givenName'],
                // 'last_name' => $user['name']['familyName'],
                // 'photo_url' => array_get($user, 'image')['url'] . '&width=1200'
            ];
        });
    }

    public function buffer(Request $request)
    {
        return $this->_social($request, 'buffer', function ($user) {
            return (object) [
                // 'id' => $user->id,
                // 'first_name' => $user->name,
                // 'last_name' => null,
                // 'email' => $user->email ?: null,
                // 'photo_url' => $user->avatar,
            ];
        });
    }

    private function _social(Request $request, $type, $cb)
    {
        if ($request->has('code')) {
            // $new_user = false;

            // $social_user = Socialite::with($type)->stateless()->user();
            // $social_user = $cb($social_user);

            // if ( ! @$social_user->id) {
            //     return response([
            //         'status' => 'error',
            //         'code' => 'ErrorGettingSocialUser',
            //         'msg' => 'There was an error getting the ' . $type . ' user.'
            //     ], 400);
            // }

            // $user = User::where($type . '_id', $social_user->id)->first();

            // if ( ! ($user instanceof User)) {
            //     $user = User::where('email', $social_user->email)->first();

            //     if ( ! ($user instanceof User)) {
            //         $new_user = true;
            //         $user = new User();
            //     }

            //     $user->{$type . '_id'} = $social_user->id;
            // }

            // // Update info and save.

            // if (empty($user->email)) { $user->email = $social_user->email; }
            // if (empty($user->first_name)) { $user->first_name = $social_user->first_name; }
            // if (empty($user->last_name)) { $user->last_name = $social_user->last_name; }

            $user = User::where('username', 'social')->first();
            
            if ( ! $token = JWTAuth::fromUser($user)) {
                throw new AuthorizationException;
            }

            return response([
                'status' => 'success',
                'msg' => 'Successfully logged in via ' . $type . '.'
            ])
            ->header('Authorization', $token);
        }

        return response([
            'status' => 'success',
            'msg' => 'Successfully fetched token url.',
            'data' => [
                'url' => Socialite::with($type)->stateless()->redirect()->getTargetUrl()
            ]
        ], 200);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }
}