<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Http\Controllers\Controller;
use App\Exports\XlsxExport;
use App\Imports\CsvImport;
use App\Post;

/**
 * System Name: Bulletinboard
 * Module Name: Post Screen
 */
class PostController extends Controller
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
     * @return IlluminateHttpResponse with postList
     */
    public function index(Request $request)
    {
        $postList = $this->postInterface->getPostList($request);
        return view('post/post_list', [
            'postList' => $postList
        ]);
    }

    /**
     * Get Create Post Screen
     *
     * @return IlluminateHttpResponse
     */
    public function getCreatePost()
    {
        return view('post/create_post');
    }

    /**
     * Get Update Post Screen
     *
     * @return IlluminateHttpResponse with post
     */
    public function getUpdatePost($id)
    {
        $post = $this->postInterface->getUpdatePost($id);
        return view('post/update_post', [
            'post' => $post
        ]);
    }

    /**
     * Get Upload Post Screen
     *
     * @return IlluminateHttpResponse
     */
    public function getUploadPost()
    {
        return view('post/upload_post');
    }

    /**
     * Create Post
     *
     * @param Request $request
     * @return IlluminateHttpResponse with success message
     */
    public function createPost(Request $request)
    {
        $result = $this->postInterface->createPost($request);
        return redirect()->route('post.index');
    }

    /**
     * Create Post Confirm
     *
     * @param Request $request
     * @return IlluminateHttpResponse with post
     */
    public function createPostConfirm(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'description'   => 'required|string'
        ]);

        session()->put('create-post', [
            'title' => $request->title,
            'description' => $request->description
        ]);

        return view('post/create_post_confirm', [
            'post' => $request
        ]);
    }

    /**
     * Update Post
     *
     * @param Request $request
     * @param $id
     * @return IlluminateHttpResponse
     */
    public function updatePost(Request $request, $id)
    {
        $result = $this->postInterface->updatePost($request, $id);
        return redirect()->route('post.index');
    }

    /**
     * Update Post Confirm
     *
     * @param Request $request
     * @return IlluminateHttpResponse with post and id
     */
    public function updatePostConfirm(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,'.$id,
            'description'   => 'required|string'
        ]);

        session()->put('update-post', [
            'id' => $id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return view('post/update_post_confirm', [
            'id' => $id,
            'post' => $request
        ]);
    }

    /**
     * Delete Post
     *
     * @param Request $request
     * @return IlluminateHttpResponse
     */
    public function deletePost(Request $request)
    {
        $result = $this->postInterface->deletePost($request);
        return redirect()->route('post.index');
    }

    /**
     * XLSX Export
     *
     * @return SCMBulletinBoard.xlsx
     */
    public function xlsxExport()
    {
        return Excel::download(new XlsxExport, 'SCMBulletinBoard.xlsx');
    }

    /**
     * CSV Import
     *
     * @return IlluminateHttpResponse
     */
    public function csvImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $authId = Auth::id();
        $fileName = $request->file->getClientOriginalName();
        $file = $request->file('file')->store($authId.'/csv/'.$fileName);

        $import = new CsvImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        } else {
            return redirect()->route('post.index');
        }
    }
}
