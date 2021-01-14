<?php

use Illuminate\Support\Facades\Route;

/** Authentication routes */
    Route::get('/', ['uses' => 'PostController@index', 'as' => 'post.index']);

    Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);

    Route::get('password/reset', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'password.forget']);

    Route::post('login', ['uses' => 'Auth\LoginController@login', 'as' => 'login']);

    Route::post('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);

    Route::post('password/email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail', 'as' => 'password.email']);

/** For post screens */
Route::group(['middleware' => 'auth.basic', 'prefix' => 'post'], function () {
    Route::get('/post_list', ['uses' => 'PostController@index', 'as' => 'post.getPostList']);
    
    Route::get('/create_post', ['uses' => 'PostController@getCreatePost', 'as' => 'post.getCreatePost']);
    
    Route::get('/update_post/{id}', ['uses' => 'PostController@getUpdatePost', 'as' => 'post.getUpdatePost']);
    
    Route::get('/upload_post', ['uses' => 'PostController@getUploadPost', 'as' => 'post.getUploadPost']);

    Route::get('/post_list/export', ['uses' => 'PostController@xlsxExport', 'as' => 'post.export']);
    
    Route::post('/create_post', ['uses' => 'PostController@createPost', 'as' => 'post.createPost']);

    Route::post('/create_post_confirm', ['uses' => 'PostController@createPostConfirm', 'as' => 'post.createPostConfirm']);

    Route::post('/update_post/{id}', ['uses' => 'PostController@updatePost', 'as' => 'post.updatePost']);

    Route::post('/update_post_confirm/{id}', ['uses' => 'PostController@updatePostConfirm', 'as' => 'post.updatePostConfirm']);

    Route::delete('/post_list', ['uses' => 'PostController@deletePost', 'as' => 'post.deletePost']);

    Route::post('/upload_post/import', ['uses' => 'PostController@csvImport', 'as' => 'post.import']);
});

/** For user screens */
Route::group(['middleware' => 'auth.basic', 'prefix' => 'user'], function () {
    Route::get('/user_list', ['uses' => 'UserController@index', 'as' => 'user.index']);

    Route::get('/search_user', ['uses' => 'UserController@searchUser', 'as' => 'user.searchUser']);

    Route::get('/create_user', ['uses' => 'UserController@getCreateUser', 'as' => 'user.getCreateUser']);
    
    Route::get('/update_user/{id}', ['uses' => 'UserController@getUpdateUser', 'as' => 'user.getUpdateUser']);

    Route::get('/change_password', ['uses' => 'UserController@getChangePassword', 'as' => 'user.getChangePassword']);

    Route::get('/user_profile', ['uses' => 'UserController@getUserProfile', 'as' => 'user.getUserProfile']);

    Route::post('/create_user', ['uses' => 'UserController@createUser', 'as' => 'user.createUser']);

    Route::post('/create_user_confirm', ['uses' => 'UserController@createUserConfirm', 'as' => 'user.createUserConfirm']);

    Route::post('/update_user/{id}', ['uses' => 'UserController@updateUser', 'as' => 'user.updateUser']);

    Route::post('/update_user_confirm/{id}', ['uses' => 'UserController@updateUserConfirm', 'as' => 'user.updateUserConfirm']);

    Route::delete('/user_list', ['uses' => 'UserController@deleteUser', 'as' => 'user.deleteUser']);

    Route::post('/change_password', ['uses' => 'UserController@changePassword', 'as' => 'user.changePassword']);
});
