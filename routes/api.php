<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('auth')->group(function (){

    Route::post('register',[\App\Http\Controllers\Auth\AuthController::class,'register'])->name('auth.register');
    Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('auth.login');
//    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->middleware('auth:api')->name('logout');

});

Route::middleware('auth:api')->group(function (){

    Route::prefix('users')->group(function (){

        Route::apiResource('groups',\App\Http\Controllers\User_Groups\UserGroupController::class);

    });

});
