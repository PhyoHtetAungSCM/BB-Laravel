<?php

namespace App\Http\Controllers\api;

use App\Post;
use App\Exports\XlsxExport;
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

    public function getPostList()
    {
        $data = $this->postInterface->getPostList();
        return response()->json($data, 200);
    }

    public function createPostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'description'   => 'required|string'
        ]);
        return response()->json($request, 200);
    }

    public function createPost(Request $request)
    {
        $result = $this->postInterface->createPost($request);
        return response()->json($result, 200);
    }

    public function updatePostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,'.$request->id,
            'description'   => 'required|string'
        ]);
        return response()->json($request, 200);
    }

    public function updatePost(Request $request)
    {
        $result = $this->postInterface->updatePost($request);
        return response()->json($result, 200);
    }

    public function deletePost(Request $request)
    {
        $result = $this->postInterface->deletePost($request);
        return response()->json($result, 200);
    }

    public function download()
    {
        $posts = Post::where('status', 1);
        $posts = $posts->get();
        $postList = [];
        foreach ($posts as $key => $post) {
            array_push($postList, [
                'title' => $post['title'],
                'description' => $post['description'],
            ]);
        }
        return response()->json($postList, 200);
    }
}
