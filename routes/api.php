<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', 'api\AuthApiController@login');

Route::middleware('auth:api')->post('/auth/logout', 'api\AuthApiController@logout');

Route::middleware('auth:api')->get('/user/list', 'api\UserApiController@getUserList');

Route::middleware('auth:api')->get('/user/profile/{id}', 'api\UserApiController@getUserProfile');

Route::middleware('auth:api')->post('/user/delete', 'api\UserApiController@deleteUser');

Route::middleware('auth:api')->post('/user/create-confirm', 'api\UserApiController@createUserConfirm');

Route::middleware('auth:api')->post('/user/create', 'api\UserApiController@createUser');

Route::middleware('auth:api')->post('/user/update-confirm', 'api\UserApiController@updateUserConfirm');

Route::middleware('auth:api')->post('/user/update', 'api\UserApiController@updateUser');

Route::middleware('auth:api')->post('/user/change-password', 'api\UserApiController@changePassword');


Route::middleware('auth:api')->get('/post/list', 'api\PostApiController@getPostList');

Route::middleware('auth:api')->get('/post/download', 'api\PostApiController@download');

Route::middleware('auth:api')->post('/post/create', 'api\PostApiController@createPost');

Route::middleware('auth:api')->post('/post/create-confirm', 'api\PostApiController@createPostConfirm');

Route::middleware('auth:api')->post('/post/update', 'api\PostApiController@updatePost');

Route::middleware('auth:api')->post('/post/update-confirm', 'api\PostApiController@updatePostConfirm');

Route::middleware('auth:api')->post('/post/delete', 'api\PostApiController@deletePost');