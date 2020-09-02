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

Route::namespace('api')->group(function(){
    Route::get('/test/{id}','ApiController@test');
    Route::post('/getFriendsInvitation','ApiController@getFriendInvitation');
    Route::post('/changeFriendInvitation','ApiController@changeFriendInvitation');

    Route::group(['prefix' => 'users'],function(){
        Route::get('/getFriendsList/{id}','ApiController@getFriendsList');
        Route::get('/getChatList/{id}','ApiController@getChatList');
        Route::post('/chat','ApiController@addChat');
        Route::post('/login','ApiController@login');
        Route::post('/register','ApiController@register');
        Route::post('/logout','ApiController@logout');
    });
});
