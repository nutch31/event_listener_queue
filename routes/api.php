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

Route::post('/laravel_event/insert', 'ProfileController@insert');
Route::get('/laravel_event/select/{id}', 'ProfileController@select');
Route::put('/laravel_event/update', 'ProfileController@update');
Route::delete('/laravel_event/delete', 'ProfileController@delete');