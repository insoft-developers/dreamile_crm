<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(
        protected AuthService $service
    ){}

    public function login(Request $request)
    {

        $request->validate([

            'email'=>'required|email',

            'password'=>'required'

        ]);

        $login = $this->service->login($request->all());

        return ApiResponse::success([

            'token'=>$login['token'],

            'user'=>new UserResource($login['user'])

        ],'Login berhasil');

    }

    public function me(Request $request)
    {

        return ApiResponse::success(

            new UserResource($request->user())

        );

    }

    public function logout(Request $request)
    {

        $this->service->logout($request->user());

        return ApiResponse::success(null,'Logout berhasil');

    }

}