<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function login(array $request)
    {

        if(!Auth::attempt([
            'email'=>$request['email'],
            'password'=>$request['password']
        ])){

            throw ValidationException::withMessages([
                'email'=>['Email atau Password salah']
            ]);

        }

        /** @var User $user */
        $user = Auth::user();

        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;

        return [

            'token'=>$token,

            'user'=>$user

        ];

    }

    public function logout(User $user)
    {

        $user->currentAccessToken()->delete();

        return true;

    }

}