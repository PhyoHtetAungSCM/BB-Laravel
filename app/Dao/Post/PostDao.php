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
    public function getPostList($request)
    {
        $search =  $request->input('search');

        /** If input's name(search) exists */
        if ($search != "") {
            $activePost = Post::orderBy('id', 'desc')->where('status', 1)
                            ->whereHas('user', function ($query) use ($search) {
                                $query->where('title', 'like', "%{$search}%");
                                $query->orWhere('description', 'like', "%{$search}%");
                                $query->orWhere('name', 'like', "%{$search}%");
                            })->get();

            $inactivePost = Post::where('status', 0)
                            ->where('create_user_id', Auth::id())
                            ->where('deleted_user_id', null)
                            ->whereHas('user', function ($query) use ($search) {
                                $query->where('title', 'like', "%{$search}%");
                                $query->orWhere('description', 'like', "%{$search}%");
                                $query->orWhere('name', 'like', "%{$search}%");
                            })->get();
        
            $postList = $activePost->merge($inactivePost);
            $postList = $this->paginate($postList);
            $postList->appends(['search' => $search]);
        } else {
            /** All active post */
            $activePost = Post::orderBy('id', 'desc')->where('status', 1)->get();

            /** Inactive but not deleted */
            $inactivePost = Post::where('status', 0)
                            ->where('create_user_id', Auth::id())
                            ->where('deleted_user_id', null)->get();

            $postList = $activePost->merge($inactivePost);
            $postList =$this->paginate($postList);
        }
        return $postList;
    }

    /**
     * Get Update Post
     *
     * @param $id
     * @return updated post ($post)
     */
    public function getUpdatePost($id)
    {
        $post = Post::find($id);
        return $post;
    }

    /**
     * Create Post
     *
     * @param $request
     * @return saved post response
     */
    public function createPost($request)
    {
        /** Retrieve data from session */
        $sessionPost = session()->get('create-post');

        /** Remove Session */
        session()->forget('create-post');

        /** Save data into database */
        $post = new Post();
        $post->title = $sessionPost['title'];
        $post->description = $sessionPost['description'];
        $post->create_user_id = Auth::id();
        $post->updated_user_id = Auth::id();
        $post->created_at = Carbon::now();
        $post->updated_at = Carbon::now();
        return $post->save();
    }

    /**
     * Update Post
     *
     * @param $request
     * @param $id
     * @return updated post response
     */
    public function updatePost($request, $id)
    {
        /** Retrieve data from session */
        $sessionPost = session()->get('update-post');

        /** Remove Session */
        session()->forget('update-post');

        /** Save data into database */
        $updatePost = Post::find($id);
        $updatePost->title = $sessionPost['title'];
        $updatePost->description = $sessionPost['description'];
        if ($request->status) {
            $updatePost->status = 1;
        } else {
            $updatePost->status = 0;
        }
        $updatePost->updated_user_id = Auth::id();
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
        $deletePost = Post::find($request->input('deletePostId'));
        $deletePost->status = 0;
        $deletePost->deleted_user_id = Auth::id();
        $deletePost->deleted_at = Carbon::now();
        return $deletePost->save();
    }

    /**
     * Collection Pagination
     *
     * @param $items
     * @param $perPage
     * @param $page
     * @param $options[]
     * @return new LengthAwarePaginator object
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
