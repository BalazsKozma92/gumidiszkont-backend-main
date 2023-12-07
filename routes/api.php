<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/coupons', [CouponController::class, 'index']);
    Route::post('/coupons/generate', [CouponController::class, 'generateCoupon']);
    Route::put('/coupons/{coupon}/use', [CouponController::class, 'markAsUsed']);
});

Route::get('/email-verification/{token}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['addcorsheaders'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
