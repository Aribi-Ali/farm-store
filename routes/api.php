<?php

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


//Route::apiResource('/categories', CategoryController::class);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/list', [CategoryController::class, 'getAllCategories']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{category}', [CategoryController::class, 'update']);
Route::delete('categories/{category}', [CategoryController::class, 'delete']);

Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::put('products/{product}', [ProductController::class, 'update']);
Route::delete('products/{product}', [ProductController::class, 'delete']);




// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
/*
Route::get('/user/{user}', [StoreController::class, "getUser"]);
Route::prefix('auth')->group(function () {
  Route::post('register', [AuthenticationController::class, 'register']);
  Route::post('login', [AuthenticationController::class, 'login']);

  Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthenticationController::class, 'getAuthenticatedUser']);
    Route::post('logout', [AuthenticationController::class, 'logout']);
  });
});*/
// category routes

// Route::resource('/categories', CategoryController::class);
/*Route::group([
  'prefix' => 'admin',        // URL prefix
  'middleware' => ['auth'],   // Middleware for the group
  'as' => 'admin.'            // Route name prefix
], function () {});*/