<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;

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

//ADD ADMIN MIDDLEWARE

Route::get('/users', [UserController::class, 'index']);
Route::get('/coupons/{coupon}', [CouponController::class, 'show']);
Route::get('/coupons', [CouponController::class, 'index']);
Route::get('/my-coupons/{user}', [CouponController::class, 'myCoupons']);
Route::post('/coupons/generate', [CouponController::class, 'generateCoupons']);
Route::post('/coupons/delete', [CouponController::class, 'deleteCoupons']);
Route::put('/coupons/{coupon}/use', [CouponController::class, 'markAsUsed']);


Route::get('/email-verification/{token}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/password-request', [AuthController::class, 'passwordRequest']);
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);

Route::middleware(['addcorsheaders'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin-login', [AuthController::class, 'adminLogin']);
});
