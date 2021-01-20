<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    // for api
    public function getPostList();

    public function createPost($request);

    public function updatePost($request);

    public function deletePost($id);

    // for web
    public function getUpdatePost($id);
}
