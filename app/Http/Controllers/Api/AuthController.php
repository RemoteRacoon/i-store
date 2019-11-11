<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Facades\AuthService;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return AuthService::login($request);
    }

    public function refreshToken(Request $request)
    {
        return AuthService::register($request);
    }

    public function logout()
    {
        return AuthService::logout();
    }

    public function register(RegisterRequest $request)
    {
        return AuthService::register($request);
    }
}
