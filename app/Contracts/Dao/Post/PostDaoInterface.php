<?php

namespace App\Contracts\Dao\Post;

interface PostDaoInterface
{
    /** Api.php */
    public function getPostList();

    public function createPost($request);

    public function updatePost($request);

    public function deletePost($request);

    /** Web.php */
    public function getUpdatePost($id);
}
