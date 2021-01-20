<?php

namespace App\Dao\User;

use App\User;
use App\Contracts\Dao\User\UserDaoInterface;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $userList = User::with('user')->whereNull('deleted_user_id')->get();
        return $userList;
    }

    /**
     * Get User Profile
     *
     * @return user detail ($userProfile)
     */
    public function userProfile($id)
    {
        $userProfile = User::find($id);
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
        $exploded = explode(',', $request->profile);
        $decoded = base64_decode($exploded[1]);
        if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } else {
            $extension = 'png';
        }
        $fileName = time().'.'.$extension;
        $path = public_path().'/images/'.$fileName;
        file_put_contents($path, $decoded);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->profile = $fileName;
        $user->profile_path = env('APP_URL') . '/images/' . $fileName;
        $user->create_user_id = Auth::id();
        $user->updated_user_id = Auth::id();
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        return $user->save();
    }

    /**
     * Update User
     *
     * @param $request
     * @param $id
     * @return updated user response
     */
    public function updateUser($request)
    {
        $updateUser = User::find($request->id);
        $updateUser->name = $request->name;
        $updateUser->email = $request->email;
        $updateUser->type = $request->type;

        if ($request->profile) {
            $exploded = explode(',', $request->profile);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png';
            }
            $fileName = time().'.'.$extension;
            $path = public_path().'/images/'.$fileName;
            file_put_contents($path, $decoded);
            $updateUser->profile = $fileName;
            $updateUser->profile_path = env('APP_URL') . '/images/' . $fileName;
        }
        
        $updateUser->updated_user_id = Auth::id();
        $updateUser->updated_at = Carbon::now();
        return $updateUser->save();
    }

    /**
     * Delete User
     *
     * @param $request
     * @return deleted user response
     */
    public function deleteUser($id)
    {
        $deleteUser = User::find($id);
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
        $user->updated_at = Carbon::now();
        return $user->save();
    }

    // for web
    public function getUpdateUser($id)
    {
        $user = User::find($id);
        return $user;
    }

    // for web
    public function updateUserConfirm($request, $id)
    {
        $updateUser = User::find($id);
        $profile = $updateUser->profile;
        return $profile;
    }
    
    // for web
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
}
