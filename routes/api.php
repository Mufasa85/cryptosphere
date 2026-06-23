<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoanApplicationController;
use App\Http\Controllers\Webhook\MobileMoneyWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::post('/webhooks/mobile-money', MobileMoneyWebhookController::class)->name('webhooks.mobile-money');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::apiResource('loan-applications', LoanApplicationController::class);
});
