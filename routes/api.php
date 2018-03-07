<?php

use App\User;
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

// To create a user
Route::post('users', function (Request $request) {
    return User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => bcrypt($request['password']),
    ]);
});

Route::resource('categories', 'CategoryController');
Route::resource('tasks', 'TaskController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});