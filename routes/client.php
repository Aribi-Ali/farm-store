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



//products


//reviews
Route::post('products/reviews/{productId}', [ProductReviewController::class, 'store']);
Route::get('products/reviews/{productReviewId}', [ProductReviewController::class, 'show']);
Route::put('products/reviews/{productReviewId}', [ProductReviewController::class, 'update']);
Route::delete('products/reviews/{productReviewId}', [ProductReviewController::class, 'destroy']);



//feedbacks
Route::post('stores/feedbacks/{storeId}', [StoreFeedbackController::class, 'store']);
Route::get('stores/feedbacks/{storeFeedbackId}', [StoreFeedbackController::class, 'show']);
Route::put('stores/feedbacks/{storeFeedbackId}', [StoreFeedbackController::class, 'update']);
Route::delete('stores/feedbacks/{storeFeedbackId}', [StoreFeedbackController::class, 'destroy']);




//roles
Route::get('roles/{roleId}', [RoleController::class, 'show']);
Route::post('roles', [RoleController::class, 'store']);
Route::get('roles', [RoleController::class, 'index']);
Route::delete('roles/{roleId}', [RoleController::class, 'destroy']);
Route::put('roles/{roleId}', [RoleController::class, 'update']);





// orders
// Route::get('orders', [ProductController::class, 'index']);
// Route::post('orders', [ProductController::class, 'store']);
// Route::get('orders/{orderId}', [ProductController::class, 'show']);
// Route::put('orders/{orderId}', [ProductController::class, 'update']);
// Route::delete('orders/{orderId}', [ProductController::class, 'delete']);
