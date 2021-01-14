<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
    public function getUserList();

    public function userProfile();

    public function getUpdateUser($id);

    public function createUser($request);

    public function searchUser($keyword);

    public function updateUser($request, $id);

    public function updateUserConfirm($request, $id);

    public function deleteUser($request);

    public function changePassword($request);
}
