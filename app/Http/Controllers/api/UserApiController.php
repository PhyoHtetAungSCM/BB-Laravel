<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function getUserList()
    {
        $data = User::with('user')->whereNull('deleted_user_id')->get();
        return response()->json($data, 200);
    }

    public function deleteUser($request)
    {
        $user = User::find($request->userID);
        $user->deleted_user_id = $request->authID;
        $user->deleted_at = Carbon::now();
        $user->save();
        return response()->json("Successful", 200);
    }
}
