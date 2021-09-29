<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;

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
    Route::post('/product/input',[ProductController::class, 'store']);
    Route::post('/product/image',[ProductController::class, 'upload']);
    Route::post('/product/edit/{id}',[ProductController::class, 'update']);
    Route::delete('/product/delete/{id}',[ProductController::class, 'destroy']);
    Route::get('/logout',[AuthController::class, 'logout']);
});

Route::post('/login',[AuthController::class, 'login']);

// product