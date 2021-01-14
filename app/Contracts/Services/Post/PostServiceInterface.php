<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    public function getPostList($request);

    public function getUpdatePost($id);

    public function createPost($request);

    public function updatePost($request, $id);

    public function deletePost($request);
}
