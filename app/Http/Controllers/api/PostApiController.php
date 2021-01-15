<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function getPostList()
    {
        /** All active post */
        $activePost = Post::with('user')->where('status', 1)->get();

        /** Inactive but not deleted */
        $inactivePost = Post::with('user')->where('status', 0)
                        ->where('create_user_id', Auth::id())
                        ->where('deleted_user_id', null)->get();

        $data = $activePost->merge($inactivePost);
        return response()->json($data, 200);
    }

    public function deletePost(Request $request)
    {
        $deletePost = Post::find($request->postID);
        $deletePost->status = 0;
        $deletePost->deleted_user_id = $request->authID;
        $deletePost->deleted_at = Carbon::now();
        $result = $deletePost->save();
        return response()->json($result, 200);
    }

    public function createPostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'description'   => 'required|string'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        return response()->json($data, 200);
    }

    public function createPost(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->create_user_id = $request->authID;
        $post->updated_user_id = $request->authID;
        $data = $post->save();

        return response()->json($data, 200);
    }

    public function updatePostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,'.$request->id,
            'description'   => 'required|string'
        ]);

        $data['id'] = $request->id;
        $data['title'] = $request->title;
        $data['description'] = $request->description;

        return response()->json($data, 200);
    }

    public function updatePost(Request $request)
    {
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->create_user_id = $request->authID;
        $post->updated_user_id = $request->authID;
        $post->updated_at = Carbon::now();
        $data = $post->save();

        return response()->json($data, 200);
    }
}
