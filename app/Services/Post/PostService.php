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
    public function getPostList($request)
    {
        return $this->postDao->getPostList($request);
    }

    /**
     * Get Update Post
     *
     * @param $id
     * @return updated post model
     */
    public function getUpdatePost($id)
    {
        return $this->postDao->getUpdatePost($id);
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
    public function updatePost($request, $id)
    {
        return $this->postDao->updatePost($request, $id);
    }

    /**
     * Delete Post
     *
     * @param $request
     * @return boolean
     */
    public function deletePost($request)
    {
        return $this->postDao->deletePost($request);
    }
}
