<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Frontend Routes
Route::get('/', [\App\Http\Controllers\Front\HomeController::class, 'index']);
Route::prefix('shop')->group(function () {
    Route::get('product/{id}', [App\Http\Controllers\Front\ShopController::class, 'show']);
    Route::post('/shop/comment', [App\Http\Controllers\Front\ShopController::class, 'postComment'])
        ->name('shop.comment')
        ->middleware('auth');
    Route::get('', [App\Http\Controllers\Front\ShopController::class, 'index']);
    Route::get('category/{categoryName}', [App\Http\Controllers\Front\ShopController::class, 'category']);
});
Route::get('/vouchers', [App\Http\Controllers\Front\VoucherController::class, 'index'])->name('front.vouchers');
Route::prefix('cart')->group(function () {
    Route::get('add', [App\Http\Controllers\Front\CartController::class, 'add']);
    Route::get('/', [App\Http\Controllers\Front\CartController::class, 'index']);
    Route::get('delete', [App\Http\Controllers\Front\CartController::class, 'delete']);
    Route::get('destroy', [App\Http\Controllers\Front\CartController::class, 'destroy']);
    Route::get('update', [App\Http\Controllers\Front\CartController::class, 'update']);
});
Route::prefix('checkout')->group(function (){
    Route::get('', [App\Http\Controllers\Front\CheckOutController::class, 'index'])->name('checkout.index')->middleware('auth');                  
    Route::post('', [App\Http\Controllers\Front\CheckOutController::class, 'addOrder'])->name('checkout.addOrder');
    Route::get('/result', [App\Http\Controllers\Front\CheckOutController::class, 'result']);
    Route::get('/vnPayCheck', [App\Http\Controllers\Front\CheckOutController::class, 'vnPayCheck']);
    Route::post('/apply-voucher', [App\Http\Controllers\Front\CheckOutController::class, 'applyVoucher'])
        ->name('checkout.applyVoucher')
        ->middleware('auth');
});
Route::prefix('account')->group(function () {
    Route::get('login', [App\Http\Controllers\Front\AccountController::class, 'login'])->name('login');
    Route::post('login', [App\Http\Controllers\Front\AccountController::class, 'checkLogin']);
    Route::get('logout', [App\Http\Controllers\Front\AccountController::class, 'logout']);
    Route::get('register', [App\Http\Controllers\Front\AccountController::class, 'register']);
    Route::post('register', [App\Http\Controllers\Front\AccountController::class, 'postRegister']);
    // Route xác minh email
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Front\AccountController::class, 'verifyEmail'])
        ->middleware(['signed'])
        ->name('verification.verify');
    // Route gửi lại email xác minh
    Route::post('/email/verification-notification', [App\Http\Controllers\Front\AccountController::class, 'resendVerificationEmail'])
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');
    Route::post('/account/change-password', [App\Http\Controllers\Front\AccountController::class, 'changePassword'])->name('account.change-password');
    // Forgot Password
    Route::get('/account/forgot-password', [App\Http\Controllers\Front\AccountController::class, 'forgotPassword'])->name('password.request');
    Route::post('/account/forgot-password', [App\Http\Controllers\Front\AccountController::class, 'sendResetLink'])->name('password.email');
    // Reset Password
    Route::get('/account/reset-password/{token}', [App\Http\Controllers\Front\AccountController::class, 'resetPassword'])->name('password.reset');
    Route::post('/account/reset-password', [App\Http\Controllers\Front\AccountController::class, 'updatePassword'])->name('password.update');
    Route::get('profile-info', [App\Http\Controllers\Front\AccountController::class, 'profileInfo']);
    Route::post('profile-info', [App\Http\Controllers\Front\AccountController::class, 'updateProfile']);
    Route::middleware(['auth'])->group(function () {
        Route::get('user-orders', [App\Http\Controllers\Front\AccountController::class, 'userOrders'])->name('user.orders');
        Route::get('user-orders/{id}', [App\Http\Controllers\Front\AccountController::class, 'orderDetail'])->name('user.order.detail');
        Route::post('orders/{id}/cancel', [App\Http\Controllers\Front\AccountController::class, 'cancelOrder'])->name('user.orders.cancel');
    });
});

// Admin Routes
Route::prefix('admin')->group(function () {
    
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'getLogin'])->name('admin.login');
    Route::post('/', [App\Http\Controllers\Admin\HomeController::class, 'postLogin'])->name('admin.postLogin');
    Route::get('logout', [App\Http\Controllers\Admin\HomeController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['admin'])->group(function () {
        Route::post('order/{id}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('brand', App\Http\Controllers\Admin\BrandController::class);       
        Route::resource('order', App\Http\Controllers\Admin\OrderController::class); 
        Route::resource('product/{product_id}/image', App\Http\Controllers\Admin\ProductImageController::class);
        Route::resource('product/{product_id}/detail', App\Http\Controllers\Admin\ProductDetailController::class);
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('voucher', App\Http\Controllers\Admin\VoucherController::class);
        Route::get('revenue', [App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('revenue.index');
        // Route::get('revenue/export', [App\Http\Controllers\Admin\RevenueController::class, 'export'])->name('revenue.export');
    });
});