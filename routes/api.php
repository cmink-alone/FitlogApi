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
Route::post('limit', 'API\ActivityController@allLimit');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('types', 'API\TypeController@all');
    Route::prefix('user')->group(function(){
        Route::get('all', 'API\UserController@getAll');
        Route::post('detail', 'API\UserController@details');
    });
    Route::prefix('follow')->group(function(){
        Route::get('all', 'API\FollowController@getAll');
    });
    Route::prefix('activity')->group(function(){
        Route::get('following', 'API\ActivityController@allFollowing');
        Route::post('add', 'API\ActivityController@add');
        Route::post('update', 'API\ActivityController@update');
        Route::post('delete', 'API\ActivityController@delete');
    });
});