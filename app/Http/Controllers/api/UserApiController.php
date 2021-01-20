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
    
    /**
     * Get User List
     *
     * @return response with json obj
     */
    public function getUserList()
    {
        $data = $this->userInterface->getUserList();
        return response()->json($data, 200);
    }

    /**
     * Get User Profile
     *
     * @param $id
     * @return response with json obj
     */
    public function getUserProfile($id)
    {
        $data = $this->userInterface->userProfile($id);
        return response()->json($data, 200);
    }

    /**
     * Create User Confirm
     *
     * @param Request $request
     * @return response with json obj
     */
    public function createUserConfirm(Request $request)
    {
        /** \Log::info($request->all()); */
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'profile' => 'required'
        ]);
        return response()->json($request, 200);
    }

    /**
     * Create User
     *
     * @param Request $request
     * @return response with json obj
     */
    public function createUser(Request $request)
    {
        /** \Log::info($request->all()); */
        $result = $this->userInterface->createUser($request);
        return response()->json($result, 200);
    }

    /**
     * Update User Confirm
     *
     * @param Request $request
     * @return response with json obj
     */
    public function updateUserConfirm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name,'.$request->id,
            'email'   => 'required|email|unique:users,email,'.$request->id,
            'type' => 'required',
        ]);
        return response()->json($request, 200);
    }

    /**
    * Update User
    *
    * @param Request $request
    * @return response with json obj
    */
    public function updateUser(Request $request)
    {
        /** \Log::info($request->all()); */
        $result = $this->userInterface->updateUser($request);
        return response()->json($result, 200);
    }

    /**
    * Delete User
    *
    * @param $id
    * @return response with json obj
    */
    public function deleteUser($id)
    {
        $result = $this->userInterface->deleteUser($id);
        return response()->json($result, 200);
    }

    /**
    * Change Password
    *
    * @param $id
    * @return response with json obj
    */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password'
        ]);
        $user = User::find(Auth::id());
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'The old password field is incorrect'], 422);
        }
        $result = $this->userInterface->changePassword($request);
        return response()->json($result, 200);
    }
}
