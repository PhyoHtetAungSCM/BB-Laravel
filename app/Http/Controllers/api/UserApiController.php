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
        /** \Log::info($request->all()); [Logging Error] */

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
        /** \Log::info($request->all()); [Logging Error] */
        
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
        $user->password = bcrypt($request->password);
        $user->type = $request->type;
        $user->profile = $fileName;
        $user->profile_path = env('APP_URL') . '/images/' . $fileName;
        $user->create_user_id = $request->authID;
        $user->updated_user_id = $request->authID;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $result = $user->save();

        return response()->json($result, 200);
    }

    public function updateUserConfirm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name,'.$request->id,
            'email'   => 'required|email|unique:users,email,'.$request->id,
            'type' => 'required',
        ]);
        // $user = User::find($request->id);
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->type = $request->type;
        // if($requuest->profile != null) {
        //     $user->profile = $request->profile;
        // } else {
        //     $user->profile = null
        // }

        return response()->json($request, 200);
    }

    public function updateUser(Request $request)
    {
        \Log::info($request->all());
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;

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

            $user->profile = $fileName;
            $user->profile_path = env('APP_URL') . '/images/' . $fileName;
        }
        
        $user->updated_user_id = $request->authID;
        $user->updated_at = Carbon::now();
        $data = $user->save();

        return response()->json($data, 200);
    }
}