<?php

namespace App\Http\Controllers\api;

use App\Post;
use App\Imports\CsvImport;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Post\PostServiceInterface;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    /** Post Interface */
    private $postInterface;

    /**
    * Create A New Controller Instance.
    *
    * @return void
    */
    public function __construct(PostServiceInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }

    /**
     * Get Post List
     *
     * @return response with json obj
     */
    public function getPostList()
    {
        $data = $this->postInterface->getPostList();
        return response()->json($data, 200);
    }

    /**
     * Create Post Confirm
     *
     * @param Request $request
     * @return response with json obj
     */
    public function createPostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'description'   => 'required|string'
        ]);
        return response()->json($request, 200);
    }

    /**
     * Create Post
     *
     * @param Request $request
     * @return response with json obj
     */
    public function createPost(Request $request)
    {
        $result = $this->postInterface->createPost($request);
        return response()->json($result, 200);
    }

    /**
     * Update Post Confirm
     *
     * @param Request $request
     * @return response with json obj
     */
    public function updatePostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,'.$request->id,
            'description'   => 'required|string',
        ]);
        return response()->json($request, 200);
    }

    /**
     * Update Post
     *
     * @param Request $request
     * @return response with json obj
     */
    public function updatePost(Request $request)
    {
        $result = $this->postInterface->updatePost($request);
        return response()->json($result, 200);
    }

    /**
     * Delete Post
     *
     * @param $id
     * @return response with json obj
     */
    public function deletePost($id)
    {
        $result = $this->postInterface->deletePost($id);
        return response()->json($result, 200);
    }

    /**
     * Upload Post
     *
     * @param Request $request
     * @return response with json obj
     */
    public function upload(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|mimes:csv,txt',
        ]);
        $path = $request->file('csvFile');
        $request = Excel::import(new CsvImport, $path);
        return response()->json($request, 200);
    }
}
