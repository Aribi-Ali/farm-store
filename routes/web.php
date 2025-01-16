<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/health', function () {
    return response()->json(['status' => 'UP']);
});

Route::get('/status', function () {
    return response()->json(['status' => 'Application is running']);
});
