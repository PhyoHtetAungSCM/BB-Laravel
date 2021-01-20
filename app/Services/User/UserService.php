<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;

/**
 * System Name: Bulletinboard
 * Module Name: User Service
 */
class UserService implements UserServiceInterface
{
    private $userDao;

    /**
     * Class Constructor
     *
     * @param OperatorUserDaoInterface
     * @return
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Get User List
     *
     * @return userDao's getUserList function
     */
    public function getUserList()
    {
        return $this->userDao->getUserList();
    }

    /**
     * Get User Profile
     *
     * @return userDao's getUserProfile function
     */
    public function userProfile($id)
    {
        return $this->userDao->userProfile($id);
    }

    /**
     * Create User
     *
     * @return userDao's createUser function
     */
    public function createUser($request)
    {
        return $this->userDao->createUser($request);
    }

    /**
     * Update User
     *
     * @return userDao's updateUser function
     */
    public function updateUser($request)
    {
        return $this->userDao->updateUser($request);
    }

    /**
     * Delete User
     *
     * @return userDao's deleteUser function
     */
    public function deleteUser($id)
    {
        return $this->userDao->deleteUser($id);
    }

    /**
     * Change Password
     *
     * @return userDao's changePassword function
     */
    public function changePassword($request)
    {
        return $this->userDao->changePassword($request);
    }

    // for web
    public function getUpdateUser($id)
    {
        return $this->userDao->getUpdateUser($id);
    }

    // for web
    public function searchUser($keyword)
    {
        return $this->userDao->searchUser($keyword);
    }

    // for web
    public function updateUserConfirm($request, $id)
    {
        return $this->userDao->updateUserConfirm($request, $id);
    }
}
