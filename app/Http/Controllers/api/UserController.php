<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'

        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $user->createToken('Access Token of '. $user->name )->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
         auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out Successful'
        ];
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            // 'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'

        ]);

        //check email
        $user = User::where('email', $fields['email'])->first();

        //Check password
        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response([
                'message' => 'Incorrect Login/Password'
            ], 401);
        }


        $token = $user->createToken('Access Token of '.$user->username)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

}
