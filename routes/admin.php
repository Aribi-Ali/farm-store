<?php

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreFeedbackController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;


//categories
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/list', [CategoryController::class, 'getAllCategories']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{category}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);


//products
Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{productId}', [ProductController::class, 'show']);
Route::put('products/{productId}', [ProductController::class, 'update']);
Route::delete('products/{productId}', [ProductController::class, 'delete']);


//stores
Route::post('stores', [StoreController::class, 'store']);
Route::get('stores', [StoreController::class, 'index']);
Route::delete('stores/{id}', [StoreController::class, 'destroy']);
Route::get('stores/{id}', [StoreController::class, 'getStoreById'])->where('id', '[0-9]+');
Route::get('stores/{slug}', [StoreController::class, 'getStoreBySlug'])->where('slug', '[a-zA-Z0-9-_]+');
Route::put('stores/{id}', [StoreController::class, 'update']);


//roles
Route::get('roles/{roleId}', [RoleController::class, 'show']);
Route::post('roles', [RoleController::class, 'store']);
Route::get('roles', [RoleController::class, 'index']);
Route::delete('roles/{roleId}', [RoleController::class, 'destroy']);
Route::put('roles/{roleId}', [RoleController::class, 'update']);

//permissions
Route::get('permissions/{permissionId}', [PermissionController::class, 'show']);
Route::post('permissions', [PermissionController::class, 'store']);
Route::get('permissions', [PermissionController::class, 'index']);
Route::delete('permissions/{permissionId}', [PermissionController::class, 'destroy']);
Route::put('permissions/{permissionId}', [PermissionController::class, 'update']);
  