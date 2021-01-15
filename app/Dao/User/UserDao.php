<?php

namespace App\Dao\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Contracts\Dao\User\UserDaoInterface;
use App\User;
use Carbon\Carbon;

/**
 * System Name: Bulletinboard
 * Module Name: User Dao
 */
class UserDao implements UserDaoInterface
{
    /**
     * Get User List
     *
     * @return user List ($userList)
     */
    public function getUserList()
    {
        $userList = User::orderBy('id', 'desc')->whereNull('deleted_user_id')->paginate(5);
        return $userList;
    }

    /**
     * Get Updated User
     *
     * @param $id
     * @return updated user ($user)
     */
    public function getUpdateUser($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Get User Profile
     *
     * @return user detail ($userProfile)
     */
    public function userProfile()
    {
        $authId = Auth::id();
        $userProfile = User::find($authId);
        return $userProfile;
    }

    /**
     * Create User
     *
     * @param $request
     * @return saved user response
     */
    public function createUser($request)
    {
        /** Retrieve data from session */
        $sessionUser = session()->get('create-user');
        /** Remove Session */
        session()->forget('create-user');

        /** Save data into database */
        $user = new User();
        $user->name = $sessionUser['name'];
        $user->email = $sessionUser['email'];
        $user->password = Hash::make($sessionUser['password']);
        $user->type = $sessionUser['type'];
        $user->phone = $sessionUser['phone'];
        $user->address = $sessionUser['address'];
        $user->dob = $sessionUser['dob'];
        $user->profile = $sessionUser['profile'];
        $user->create_user_id = Auth::id();
        $user->updated_user_id = Auth::id();
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        return $user->save();
    }

    /**
     * Search User
     *
     * @param $keyword
     * @return search result ($userList)
     */
    public function searchUser($keyword)
    {
        $userList = User::orderBy('id', 'desc')
                    ->whereNull('deleted_user_id')
                    ->where('name', 'like', "%{$keyword->name}%")
                    ->when($keyword->email, function ($query) use ($keyword) {
                        $query->where('email', 'like', "%{$keyword->email}%");
                    })
                    ->when($keyword->created_from, function ($query) use ($keyword) {
                        $query->where('created_at', '=', $keyword->created_from);
                    })
                    ->when($keyword->created_to, function ($query) use ($keyword) {
                        $query->where('updated_at', '=', $keyword->created_to);
                    })->paginate(5);
        return $userList;
    }

    /**
     * Update User
     *
     * @param $request
     * @param $id
     * @return updated user response
     */
    public function updateUser($request, $id)
    {
        /** Retrieve data from session */
        $sessionUser = session()->get('update-user');

        /** Remove Session */
        session()->forget('update-user');

        /** Save data into database */
        $updateUser = User::find($id);
        $updateUser->name = $sessionUser['name'];
        $updateUser->email = $sessionUser['email'];
        $updateUser->type = $sessionUser['type'];
        $updateUser->phone = $sessionUser['phone'];
        $updateUser->address = $sessionUser['address'];
        $updateUser->dob = $sessionUser['dob'];
        if ($sessionUser['profile']) {
            $updateUser->profile = $sessionUser['profile'];
        }
        $updateUser->updated_user_id = Auth::id();
        $updateUser->updated_at = Carbon::now();
        return $updateUser->save();
    }

    /**
     * Update User Confirmation
     *
     * @param $request
     * @param $id
     * @return profile image
     */
    public function updateUserConfirm($request, $id)
    {
        $updateUser = User::find($id);
        $profile = $updateUser->profile;
        return $profile;
    }

    /**
     * Delete User
     *
     * @param $request
     * @return deleted user response
     */
    public function deleteUser($request)
    {
        $deleteUser = User::find($request->input('deleteUserId'));
        $deleteUser->deleted_user_id = Auth::id();
        $deleteUser->deleted_at = Carbon::now();
        return $deleteUser->save();
    }

    /**
     * Change Password
     *
     * @param $request
     * @return changed password response
     */
    public function changePassword($request)
    {
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->updated_user_id = Auth::id();
        $user->updated_at = Auth::id();
        return $user->save();
    }
}
