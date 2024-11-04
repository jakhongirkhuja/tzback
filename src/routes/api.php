<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/buy-products', [ProductController::class, 'buyProducts']);
Route::post('/refund-batch', [ProductController::class, 'refundBatch']);
Route::get('/available-products', [ProductController::class, 'getAvailableProducts']);
Route::post('/order-products', [ProductController::class, 'orderProducts']);
Route::get('/batch-profit', [ProductController::class, 'calculateBatchProfit']);