<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/product',[ProductController::class, 'index']);
    Route::get('/category',[CategoriesController::class, 'index']);
    Route::post('/product',[ProductController::class, 'store']);
    Route::get('/product/seller/{id}',[ProductController::class, 'getProductBySeller']);
    Route::post('/product/image',[ProductController::class, 'upload']);
    Route::post('/product/{id}',[ProductController::class, 'update']);
    Route::get('/product/{id}',[ProductController::class, 'edit']);
    Route::delete('/product/{id}',[ProductController::class, 'destroy']);
    Route::get('/logout',[AuthController::class, 'logout']);
    Route::get('/user/{id}', [UserController::class, 'edit']);
});

Route::post('/login',[AuthController::class, 'login']);

// product