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

Route::middleware('auth:api')->get('/post/list', 'api\PostApiController@getPostList');

Route::middleware('auth:api')->post('/post/create', 'api\PostApiController@createPost');

Route::middleware('auth:api')->post('/post/create-confirm', 'api\PostApiController@createPostConfirm');

Route::middleware('auth:api')->post('/post/update', 'api\PostApiController@updatePost');

Route::middleware('auth:api')->post('/post/update-confirm', 'api\PostApiController@updatePostConfirm');

Route::middleware('auth:api')->delete('/post/delete/{id}', 'api\PostApiController@deletePost');
