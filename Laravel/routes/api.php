<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Categorycontroller;
use App\Http\Controllers\ProductController;

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API Ajidabloom berjalan'
    ]);
});

// ==========================
// Category API
// ==========================
Route::get('/categories', [Categorycontroller::class, 'index']);
Route::post('/categories', [Categorycontroller::class, 'store']);
Route::get('/categories/{id}', [Categorycontroller::class, 'show']);
Route::put('/categories/{id}', [Categorycontroller::class, 'update']);
Route::delete('/categories/{id}', [Categorycontroller::class, 'destroy']);

// ==========================
// Product API
// ==========================
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);