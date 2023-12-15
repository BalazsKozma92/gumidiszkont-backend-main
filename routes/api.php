<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarouselImageController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EmailController;

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

// ADD ADMIN MIDDLEWARE

// USERS
Route::get('/users', [UserController::class, 'index']);

// COUPONS
Route::get('/coupons/{coupon}', [CouponController::class, 'show']);
Route::get('/coupons', [CouponController::class, 'index']);
Route::get('/my-coupons/{user}', [CouponController::class, 'myCoupons']);
Route::post('/coupons/generate', [CouponController::class, 'generateCoupons']);
Route::post('/coupons/delete', [CouponController::class, 'deleteCoupons']);
Route::put('/coupons/{coupon}/use', [CouponController::class, 'markAsUsed']);

// CAROUSEL IMAGES
Route::post('/carousel-images', [CarouselImageController::class, 'store']);
Route::get('/carousel-images', [CarouselImageController::class, 'index']);
Route::delete('/carousel-images/{carouselImage}', [CarouselImageController::class, 'destroy']);
Route::put('/carousel-images/{carouselImage}', [CarouselImageController::class, 'update']);

// NEWS
Route::get('/all-news', [NewsController::class, 'index']);
Route::get('/news/{news}', [NewsController::class, 'show']);
Route::post('/news', [NewsController::class, 'store']);
Route::delete('/news/{news}', [NewsController::class, 'destroy']);
Route::put('/news/{news}', [NewsController::class, 'update']);

// SEGITSEG
Route::post('/send-email', [EmailController::class, 'sendEmail']);


// PUBLIC
Route::get('/email-verification/{token}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/password-request', [AuthController::class, 'passwordRequest']);
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);

Route::middleware(['addcorsheaders'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/admin-login', [AuthController::class, 'adminLogin']);
});
