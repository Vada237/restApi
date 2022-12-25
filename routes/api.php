<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categories')
    ->name('categories.')
    ->group(function () {
        Route::get('/',[Api\CategoryController::class, 'index']);
        Route::get('/{id}', [Api\CategoryController::class, 'show']);
        Route::post('/',[Api\CategoryController::class, 'store']);
        Route::delete('/{id}', [Api\CategoryController::class, 'destroy']);
        Route::put('/{id}',[Api\CategoryController::class, 'update']);
    });

Route::resource('category',Api\CategoryController::class);

