<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\ContactController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/contact', [ContactController::class, 'send']);

Route::get('/promotions/active', [PromotionController::class, 'active']);

Route::middleware(['auth:sanctum'])->group(function () {

    // Promotions
    Route::get('/promotions', [PromotionController::class, 'index']);
    Route::get('/promotions/{id}', [PromotionController::class, 'show']);

    Route::post('/promotions', [PromotionController::class, 'store']);
    Route::put('/promotions/{id}', [PromotionController::class, 'update']);

    Route::patch('/promotions/{id}/toggle', [PromotionController::class, 'toggle']);
    Route::delete('/promotions/{id}', [PromotionController::class, 'destroy']);
});
