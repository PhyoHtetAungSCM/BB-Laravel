<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
{
    public function getUserList();

    public function getUpdateUser($id);

    public function userProfile();

    public function createUser($request);

    public function searchUser($keyword);

    public function updateUser($request, $id);

    public function updateUserConfirm($request, $id);

    public function deleteUser($request);

    public function changePassword($request);
}
