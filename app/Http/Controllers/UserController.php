<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\User;

/**
 * System Name: Bulletinboard
 * Module Name: User Screen
 */
class UserController extends Controller
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
     * @return IlluminateHttpResponse with userList
     */
    public function index()
    {
        $userList = $this->userInterface->getUserList();
        return view('user/user_list', [
            'userList' => $userList
        ]);
    }

    /**
     * Get Create User Screen
     *
     * @return IlluminateHttpResponse
     */
    public function getCreateUser()
    {
        return view('user/create_user');
    }

    /**
     * Get Update User Screen
     *
     * @return IlluminateHttpResponse with user
     */
    public function getUpdateUser($id)
    {
        $user = $this->userInterface->getUpdateUser($id);
        return view('user/update_user', [
            'user' => $user
        ]);
    }

    /**
     * Get User Profile Screen
     *
     * @return IlluminateHttpResponse with userProfile
     */
    public function getUserProfile()
    {
        $userProfile = $this->userInterface->userProfile();
        return view('user/user_profile', [
            'userProfile' => $userProfile
        ]);
    }

    /**
     * Get Change Password
     *
     * @return IlluminateHttpResponse
     */
    public function getChangePassword()
    {
        return view('user/change_password');
    }

    /**
     * Create User
     *
     * @param Request $request
     * @return IlluminateHttpResponse with success message
     */
    public function createUser(Request $request)
    {
        $result = $this->userInterface->createUser($request);
        return redirect()->route('user.index');
    }

    /**
     * Create User Confirm
     *
     * @param Request $request
     * @return IlluminateHttpResponse with post
     */
    public function createUserConfirm(Request $request)
    {
        dd($request);
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'email'   => 'required|email',
            'password' => 'required|confirmed|min:6',
            'type' => 'required',
            'phone' => 'nullable|regex:/(09)[0-9]{9}/',
            'profile' => 'required|mimes:jpeg,jpg,bmp,png|max:2048'
        ]);

        $fileName = '';

        if ($file = $request->hasFile('profile')) {
            $file = $request->file('profile') ;
            $fileName = time() . '.' . $file->extension();
            $destinationPath = public_path().'/images/';
            $file->move($destinationPath, $fileName);
        }

        session()->put('create-user', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => $request->type,
            'phone' => $request->phone,
            'address' => $request->address,
            'dob' => $request->dob,
            'profile' => $fileName
        ]);

        return view('user/create_user_confirm', [
            'user' => $request,
            'profile' => $fileName
        ]);
    }

    /**
     * Search User
     *
     * @param Request $keyword
     * @return IlluminateHttpResponse with userList
     */
    public function searchUser(Request $keyword)
    {
        $userList = $this->userInterface->searchUser($keyword);
        return view('user/user_list', [
            'userList' => $userList
        ]);
    }

    /**
     * Update User
     *
     * @param Request $request
     * @param $id
     * @return IlluminateHttpResponse
     */
    public function updateUser(Request $request, $id)
    {
        $result = $this->userInterface->updateUser($request, $id);
        return redirect()->route('user.index');
    }

    /**
     * Update User Confirm
     *
     * @param Request $request
     * @return IlluminateHttpResponse with user and profile
     */
    public function updateUserConfirm(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name,'.$id,
            'email' => 'required|email',
            'type' => 'required',
            'phone' => 'nullable|regex:/(09)[0-9]{9}/',
            'profile' => 'mimes:jpeg,jpg,bmp,png|max:2048',
        ]);

        /** Get already uploaded profile */
        $profileFromDB = $this->userInterface->updateUserConfirm($request, $id);

        /** Get recently updated profile */
        $fileName = '';

        if ($file = $request->hasFile('profile')) {
            $file = $request->file('profile') ;
            $fileName = time() . '.' . $file->extension();
            $destinationPath = public_path().'/images/' ;
            $file->move($destinationPath, $fileName);
        }

        session()->put('update-user', [
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'phone' => $request->phone,
            'address' => $request->address,
            'dob' => $request->dob,
            'profile' => $fileName
        ]);

        return view('user/update_user_confirm', [
            'profileFromDB' => $profileFromDB,
            'user' => $request,
            'profile' => $fileName
        ]);
    }

    /**
     * Delete User
     *
     * @param Request $request
     * @return IlluminateHttpResponse
     */
    public function deleteUser(Request $request)
    {
        $result = $this->userInterface->deleteUser($request);
        return redirect()->route('user.index');
    }


    /**
     * Change Password
     *
     * @param Request $request
     * @return IlluminateHttpResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => [
                'required',  function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('The old password is not correct.');
                    }
                }, 'confirmed', 'min:6'
            ],
            'new_password' => 'required|min:6'
        ]);
        $result = $this->userInterface->changePassword($request);
        return redirect()->route('post.index');
    }
}
