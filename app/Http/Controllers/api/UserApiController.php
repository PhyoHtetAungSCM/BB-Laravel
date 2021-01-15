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

    public function deleteUser(Request $request)
    {
        $user = User::find($request->userID);
        $user->deleted_user_id = $request->authID;
        $user->deleted_at = Carbon::now();
        $user->save();
        return response()->json("Successful", 200);
    }

    public function createUserConfirm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'type' => 'required',
            'profile_url' => 'required'
        ]);

        return response()->json($request, 200);
    }

    public function createUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->type = $request->type;
        $user->profile = $request->profile_url;
        $user->create_user_id = $request->authID;
        $user->updated_user_id = $request->authID;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $result = $user->save();

        return response()->json($result, 200);
    }
}
