<?php

use App\Events\UserOrder;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ExportController;
use App\Http\Controllers\API\OrderController as APIOrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\BannerAndSlideController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\MailController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReviewController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('edit_profile', [AuthController::class, 'edit_profile'])->name('edit_profile');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('change_password', [AuthController::class, 'change_password'])->name('change_password');

        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    });

    Route::prefix('product')->group(function () {
        Route::get('category', [CategoryController::class, 'category'])->name('category');
        Route::post('allproduct', [ProductController::class, 'allproduct'])->name('allproduct');
        Route::post('product_details', [ProductController::class, 'product_details'])->name('product_details');
        Route::post('search_product', [ProductController::class, 'search_product'])->name('search_product');
        Route::get('highest_rating_products', [ProductController::class, 'highest_rating_products'])->name('highest_rating_products');
        Route::get('featured_products', [ProductController::class, 'featured_products'])->name('featured_products');
    });

    Route::prefix('order')->group(function () {
        Route::post('order', [OrderController::class, 'order'])->name('order');
        Route::post('history_order', [OrderController::class, 'history_order'])->name('history_order');
        // Route::post('history_order_details', [OrderController::class, 'history_order_details'])->name('history_order_details');
    });

    Route::prefix('banner_and_slide')->group(function () {
        Route::post('banner_and_slide', [BannerAndSlideController::class, 'banner_and_slide'])->name('banner_and_slide');
    });

    Route::prefix('review')->group(function () {
        Route::post('review', [ReviewController::class, 'review'])->name('review');
        Route::post('check', [ReviewController::class, 'check'])->name('check');
    });

    Route::prefix('feedback')->group(function () {
        Route::post('feedback', [FeedbackController::class, 'feedback'])->name('feedback');
    });

    Route::prefix('vnpay')->group(function () {
        Route::post('vnpay_payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay_payment');
        Route::get('check_payment', [PaymentController::class, 'check_payment'])->name('check_payment');
    });
});
