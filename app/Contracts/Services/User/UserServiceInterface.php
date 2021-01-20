<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
    // for api
    public function getUserList();

    public function userProfile($id);

    public function createUser($request);

    public function updateUser($request);

    public function deleteUser($id);

    public function changePassword($request);

    // for web
    public function getUpdateUser($id);

    public function searchUser($keyword);

    public function updateUserConfirm($request, $id);
}
