<?php

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

/*Route::group(['prefix' => 'v1'], function () {
    Route::resource('categories', 'CategoryController');
    Route::resource('categories.tasks', 'TaskController');
})->middleware('auth:api');*/


Route::get('/test', function() {
	return "Hola mundo";
})->middleware('auth:api');