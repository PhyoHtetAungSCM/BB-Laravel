<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// login
Route::post('/auth/login', 'api\AuthApiController@login');

// logout
Route::middleware('auth:api')->post('/auth/logout', 'api\AuthApiController@logout');

// user
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user/list', 'api\UserApiController@getUserList');

    Route::get('/user/profile/{id}', 'api\UserApiController@getUserProfile');

    Route::post('/user/create', 'api\UserApiController@createUser');

    Route::post('/user/create-confirm', 'api\UserApiController@createUserConfirm');

    Route::post('/user/update', 'api\UserApiController@updateUser');

    Route::post('/user/update-confirm', 'api\UserApiController@updateUserConfirm');

    Route::delete('/user/delete/{id}', 'api\UserApiController@deleteUser');

    Route::post('/user/change-password', 'api\UserApiController@changePassword');
});

// post
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/post/list', 'api\PostApiController@getPostList');

    Route::post('/post/create', 'api\PostApiController@createPost');

    Route::post('/post/create-confirm', 'api\PostApiController@createPostConfirm');

    Route::post('/post/update', 'api\PostApiController@updatePost');

    Route::post('/post/update-confirm', 'api\PostApiController@updatePostConfirm');

    Route::delete('/post/delete/{id}', 'api\PostApiController@deletePost');

    Route::post('/post/upload', 'api\PostApiController@upload');
});
