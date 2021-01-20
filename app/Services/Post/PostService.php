<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;

/**
 * System Name: Bulletinboard
 * Module Name: Post Service
 */
class PostService implements PostServiceInterface
{
    private $postDao;

    /**
     * Class Constructor
     *
     * @param OperatorPostDaoInterface
     * @return
     */
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }

    /**
     * Get Post List
     *
     * @return post list
     */
    public function getPostList()
    {
        return $this->postDao->getPostList();
    }

    /**
     * Create Post
     *
     * @param $request
     * @return boolean
     */
    public function createPost($request)
    {
        return $this->postDao->createPost($request);
    }

    /**
     * Update Post
     *
     * @param $request
     * @param $id
     * @return boolean
     */
    public function updatePost($request)
    {
        return $this->postDao->updatePost($request);
    }

    /**
     * Delete Post
     *
     * @param $request
     * @return boolean
     */
    public function deletePost($id)
    {
        return $this->postDao->deletePost($id);
    }

    // for web
    public function getUpdatePost($id)
    {
        return $this->postDao->getUpdatePost($id);
    }
}
