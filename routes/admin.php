<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\UserController;

Route::get("/hi", function () {
  return "ee";
});
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