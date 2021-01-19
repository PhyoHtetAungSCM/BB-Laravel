<?php

namespace App\Dao\Post;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Post;
use Carbon\Carbon;

/**
 * System Name: Bulletinboard
 * Module Name: Post Dao
 */
class PostDao implements PostDaoInterface
{
    /**
     * Get Post List
     *
     * @param $request
     * @return post list ($postList)
     */
    public function getPostList()
    {
        // all active post
        $activePost = Post::with('user')->where('status', 1)->get();
        // inactive but not deleted
        $inactivePost = Post::with('user')->where('status', 0)
                        ->where('create_user_id', Auth::id())
                        ->where('deleted_user_id', null)->get();

        $postList = $activePost->merge($inactivePost);
        return $postList;
    }

    /**
     * Create Post
     *
     * @param $request
     * @return saved post response
     */
    public function createPost($request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->create_user_id = $request->authID;
        $post->updated_user_id = $request->authID;
        return $post->save();
    }

    /**
     * Update Post
     *
     * @param $request
     * @param $id
     * @return updated post response
     */
    public function updatePost($request)
    {
        $updatePost = Post::find($request->id);
        $updatePost->title = $request->title;
        $updatePost->description = $request->description;
        $updatePost->create_user_id = $request->authID;
        $updatePost->updated_user_id = $request->authID;
        $updatePost->updated_at = Carbon::now();
        return $updatePost->save();
    }

    /**
     * Delete Post
     *
     * @param $request
     * @return deleted post response
     */
    public function deletePost($request)
    {
        $deletePost = Post::find($request->postID);
        $deletePost->status = 0;
        $deletePost->deleted_user_id = $request->authID;
        $deletePost->deleted_at = Carbon::now();
        return $deletePost->save();
    }

    /** < web.php > */
    public function getUpdatePost($id)
    {
        $post = Post::find($id);
        return $post;
    }

    /** < web.php > */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
