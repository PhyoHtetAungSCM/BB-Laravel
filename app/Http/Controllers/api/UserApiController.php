<?php

namespace App\Http\Controllers\api;

use App\User;
use App\Http\Controllers\Controller;
use App\Contracts\Services\User\UserServiceInterface;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /** User Interface */
    private $userInterface;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(UserServiceInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    
    public function getUserList()
    {
        $data = $this->userInterface->getUserList();
        return response()->json($data, 200);
    }

    public function getUserProfile($id)
    {
        $data = $this->userInterface->userProfile($id);
        return response()->json($data, 200);
    }

    public function createUserConfirm(Request $request)
    {
        /** \Log::info($request->all()); */
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'type' => 'required',
            'profile' => 'required'
        ]);
        return response()->json($request, 200);
    }

    public function createUser(Request $request)
    {
        /** \Log::info($request->all()); */
        $result = $this->userInterface->createUser($request);
        return response()->json($result, 200);
    }

    public function updateUserConfirm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name,'.$request->id,
            'email'   => 'required|email|unique:users,email,'.$request->id,
            'type' => 'required',
        ]);
        return response()->json($request, 200);
    }

    public function updateUser(Request $request)
    {
        /** \Log::info($request->all()); */
        $result = $this->userInterface->updateUser($request);
        return response()->json($result, 200);
    }

    public function deleteUser(Request $request)
    {
        $result = $this->userInterface->deleteUser($request);
        return response()->json($result, 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password'
        ]);
        $user = User::find($request->userID);
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'The old password field is incorrect'], 422);
        }
        $user->password = Hash::make($request->new_password);
        $user->updated_user_id = $request->userID;
        $user->updated_at = Carbon::now();
        $result = $user->save();
        return response()->json($result, 200);
    }
}
