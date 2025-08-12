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
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->middleware('auth:api')->name('logout');

});


Route::group(['middleware' => "auth:api"], function () {

    Route::prefix('users')->as('users.')->group(function (){

        Route::prefix('groups')->as('groups.')->group(function (){
            Route::get('all',[\App\Http\Controllers\User_Groups\UserGroupController::class,'all'])->name('all');
            Route::get('searchable',[\App\Http\Controllers\User_Groups\UserGroupController::class,'searchable'])->name('searchable');
        });
        Route::apiResource('groups',\App\Http\Controllers\User_Groups\UserGroupController::class);


        Route::get('all',[\App\Http\Controllers\Users\UserController::class,'all'])->name('all');
        Route::get('doctors',[\App\Http\Controllers\Users\UserController::class,'doctors'])->name('doctors');
        Route::get('searchable',[\App\Http\Controllers\Users\UserController::class,'searchable'])->name('searchable');
    });
    Route::apiResource('users',\App\Http\Controllers\Users\UserController::class);

    Route::prefix('products')->as('products.')->group(function (){
        Route::get('all',[\App\Http\Controllers\Products\ProductController::class,'all'])->name('all');
        Route::get('searchable',[\App\Http\Controllers\Products\ProductController::class,'searchable'])->name('searchable');
    });
    Route::apiResource('products',\App\Http\Controllers\Products\ProductController::class);


    Route::prefix('carts')->as('carts.')->group(function (){
        Route::get('searchable',[\App\Http\Controllers\Carts\CartController::class,'searchable'])->name('searchable');
        Route::post('add',[\App\Http\Controllers\Carts\CartController::class,'add_to_cart'])->name('add_to_cart');
        Route::get('get',[\App\Http\Controllers\Carts\CartController::class,'get_cart'])->name('get_cart');
        Route::get('delete/{id}',[\App\Http\Controllers\Carts\CartController::class,'delete_cart'])->name('delete_cart');
    });
    Route::apiResource('carts',\App\Http\Controllers\Carts\CartController::class);

    Route::prefix('doctors')->as('doctors.')->group(function (){
        Route::apiResource('comments',\App\Http\Controllers\Doctors\Comments\CommentController::class);
    });
    Route::apiResource('doctors',\App\Http\Controllers\Doctors\DoctorController::class);

    Route::prefix('contacts')->as('contacts.')->group(function (){
        Route::apiResource('us',\App\Http\Controllers\Contact_us\ContactUsController::class);
    });
});


