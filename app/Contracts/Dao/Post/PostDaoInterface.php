<?php

namespace App\Contracts\Dao\Post;

interface PostDaoInterface
{
    public function getPostList($request);

    public function getUpdatePost($id);

    public function createPost($request);

    public function updatePost($request, $id);

    public function deletePost($request);
}
