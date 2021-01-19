<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    /** Api.php */
    public function getPostList();

    public function createPost($request);

    public function updatePost($request);

    public function deletePost($request);

    /** Web.php */
    public function getUpdatePost($id);
}
