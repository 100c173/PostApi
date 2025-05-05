<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthApiController::class)->group(function(){
    Route::post('register' , 'register');
    Route::post('login' , 'login');
});

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(AuthApiController::class)->group(function(){
        Route::post('logout','logout');
        Route::get('user','user') ;
    });

    Route::resource('posts',PostController::class);
});