<?php

use App\Models\roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api;

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

Route::prefix('categories')
    ->group(function () {
        Route::get('/',[Api\CategoryController::class, 'index']);
        Route::get('/{id}',[Api\CategoryController::class, 'show']);
        Route::post('/',[Api\CategoryController::class, 'store']);
        Route::delete('/{id}',[Api\CategoryController::class, 'destroy']);
        Route::put('/{id}',[Api\CategoryController::class, 'update']);
    });

Route::prefix('dishes')
    ->group(function () {
        Route::get('/',[Api\DishesController::class, 'index']);
        Route::get('/{id}',[Api\DishesController::class, 'show']);
        Route::post('/',[Api\DishesController::class, 'store']);
        Route::delete('/{id}',[Api\DishesController::class, 'destroy']);
        Route::put('/{id}',[Api\DishesController::class, 'update']);
    });

Route::prefix('dishes_structures')
    ->group(function () {
        Route::get('/',[Api\Dishes_StructuresController::class, 'index']);
        Route::get('/{id}',[Api\Dishes_StructuresController::class, 'show']);
        Route::post('/',[Api\Dishes_StructuresController::class, 'store']);
        Route::delete('/{id}',[Api\Dishes_StructuresController::class, 'destroy']);
        Route::put('/{id}',[Api\Dishes_StructuresController::class, 'update']);
    });

Route::prefix('orders')
    ->group(function () {
        Route::get('/',[Api\OrderController::class, 'index']);
        Route::get('/{id}',[Api\OrderController::class, 'show']);
       Route::post('/create',[Api\OrderController::class, 'store']);
       Route::put('/close/{id}',[Api\OrderController::class, 'update']);
    });

Route::prefix('order_dishes')
    ->group(function () {
        Route::post('/',[Api\Order_DishesController::class, 'store']);
        Route::get('/',[Api\Order_DishesController::class, 'index']);
        Route::delete('/{order_id}/{dishes_id}',[Api\Order_DishesController::class, 'destroy']);
    });

Route::prefix('users')
    ->group(function () {
        Route::get('/', [Api\UserController::class, 'index']);
        Route::post('/', [Api\UserController::class, 'store']);
        Route::put('/{id}', [Api\UserController::class, 'update']);
        Route::delete('/{id}', [Api\UserController::class, 'destroy']);
    });

Route::prefix('auth')
    ->group(function () {
        Route::post('/login', [Api\AuthController::class, 'login']);
        Route::get('/' ,[Api\AuthController::class,'test']);
    });


    Route::apiResource('users', Api\UserController::class)->middleware('auth:sanctum');
    Route::apiResource('dishes_structures', Api\Dishes_StructuresController::class)->middleware('auth:sanctum');
    Route::apiResource('dishes', Api\DishesController::class)->middleware('auth:sanctum');
    Route::apiResource('category', Api\CategoryController::class)->middleware('auth:sanctum');
    Route::apiResource('orders', Api\OrderController::class)->middleware('auth:sanctum');
    Route::apiResource('orders_dishes', Api\Order_DishesController::class)->middleware('auth:sanctum');





