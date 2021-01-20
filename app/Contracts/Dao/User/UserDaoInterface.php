<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
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
