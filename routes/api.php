<?php

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
Route::group(['prefix' => '/auth'], function (){
    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
});

Route::group(['prefix' => '/', 'middleware' => 'jwt'], function (){
    Route::get('/posts', [\App\Http\Controllers\Customer\CustomerController::class, 'index']);
    Route::post('/posts/{post}/comment', [\App\Http\Controllers\Customer\CustomerController::class, 'comment']);
    Route::post('/posts/{post}/like', [\App\Http\Controllers\Customer\CustomerController::class, 'like']);
    Route::group(['prefix' => '/admin'], function (){
        Route::apiResource('posts', \App\Http\Controllers\Admin\PostController::class);
    });
});
