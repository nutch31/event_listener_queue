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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/profile/insert', 'ProfileController@insert');
Route::get('/profile/select/{id}', 'ProfileController@select');
Route::put('/profile/update', 'ProfileController@update');
Route::delete('/profile/delete', 'ProfileController@delete');

Route::post('/post/insert', 'PostController@insert');
Route::get('/post/select/{id}', 'PostController@select');
Route::put('/post/update', 'PostController@update');
Route::delete('/post/delete', 'PostController@delete');

Route::post('/comment/insert', 'CommentController@insert');
Route::get('/comment/select/{id}', 'CommentController@select');
Route::put('/comment/update', 'CommentController@update');
Route::delete('/comment/delete', 'CommentController@delete');

Route::post('/sendnotification', 'SendNotificationEmailController@sendnotification');