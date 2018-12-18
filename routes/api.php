<?php

use Illuminate\Http\Request;

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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('limit', 'API\ActivityController@allLimit');
Route::get('updateActivity', 'API\ActivityController@update');
Route::post('update_sync', 'API\ActivityController@updateFromLocals');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('types', 'API\TypeController@all');
    Route::prefix('user')->group(function(){
        Route::get('all', 'API\UserController@getAll');
        Route::get('followers', 'API\FollowController@getFollowers');
        Route::get('following', 'API\FollowController@getFollowing');
        Route::post('detail', 'API\UserController@details');
    });
    Route::get('unfollow/{id}', 'API\FollowController@unfollow');
    Route::get('follow/{id}', 'API\FollowController@follow');
    Route::get('follower/remove/{id}', 'API\FollowController@removeFollower');
    Route::prefix('follow')->group(function(){
        Route::get('all', 'API\FollowController@getAll');
        Route::get('search/{q}', 'API\FollowController@search');
    });
    Route::prefix('activity')->group(function(){
        Route::get('following', 'API\ActivityController@allFollowing');
        Route::post('add', 'API\ActivityController@add');
        Route::post('update', 'API\ActivityController@update');
        Route::post('delete', 'API\ActivityController@delete');
        Route::post('add/sync', 'API\ActivityController@addFromLocals');
        Route::post('update/sync', 'API\ActivityController@updateFromLocals');
    });
});