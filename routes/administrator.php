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
// products
// reviews
// feedbacks

//stores
//feedbacks


// badges
Route::get('badges/{badgeId}', [BadgeController::class, 'show']);
Route::post('badges', [BadgeController::class, 'store']);
Route::get('badges', [BadgeController::class, 'index']);
Route::delete('badges/{badgeId}', [BadgeController::class, 'destroy']);
Route::put('badges/{badgeId}', [BadgeController::class, 'update']);


// tags
Route::get('tags/{tagId}', [TagController::class, 'show']);
Route::post('tags', [TagController::class, 'store']);
Route::get('tags', [TagController::class, 'index']);
Route::delete('tags/{tagId}', [TagController::class, 'destroy']);
Route::put('tags/{tagId}', [TagController::class, 'update']);


//roles
Route::get('roles/{roleId}', [RoleController::class, 'show']);
Route::post('roles', [RoleController::class, 'store']);
Route::get('roles', [RoleController::class, 'index']);
Route::delete('roles/{roleId}', [RoleController::class, 'destroy']);
Route::put('roles/{roleId}', [RoleController::class, 'update']);

//permissions
