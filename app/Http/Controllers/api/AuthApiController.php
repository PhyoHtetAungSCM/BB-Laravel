<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token_type'] = 'Bearer';
            $success['access_token'] = $user->createToken('SCMBulletinboard Password Grant Client')->accessToken;
            $success['data'] = $user;
            return response()->json($success, 200);
        } else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
}
