<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderItemController;

//Route::apiResource('customers', CustomerController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('order-items', OrderItemController::class);

Route::apiResource('customers', CustomerController::class)
     ->only(['index', 'store', 'update', 'destroy']);
     Route::get('/order-items/{klient_id}', [OrderItemController::class, 'show']);
Route::patch('order-items/{id}', [OrderItemController::class, 'update']);



// opcjonalnie jakiś prosty ping
Route::get('ping', fn() => response()->json(['message' => 'pong']));
