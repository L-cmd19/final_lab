<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Import Controllers (Sesuai Folder Namespace)
|--------------------------------------------------------------------------
*/

// 1. Controller PUBLIC (Di luar folder)
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// 2. Controller BUYER (Folder: app/Http/Controllers/Buyer)
use App\Http\Controllers\Buyer\ProfileController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\OrderHistoryController;
use App\Http\Controllers\Buyer\ReviewController;

// 3. Controller SELLER (Folder: app/Http/Controllers/Seller)
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;

// 4. Controller ADMIN (Folder: app/Http/Controllers/Admin)
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\SellerVerificationController;
use App\Http\Controllers\Admin\AdminProductModerationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('product.list');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.detail');


// --- AUTHENTICATED ROUTES (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // Profile Management (Bisa diakses Buyer & Seller)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');


    // --- BUYER ROUTES ---
    Route::middleware('role:buyer')->group(function () {
        // Cart
        Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);
        
        // Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
        
        // Order History
        Route::get('/orders/history', [OrderHistoryController::class, 'index'])->name('order.history.index');
        Route::get('/orders/history/{order}', [OrderHistoryController::class, 'show'])->name('order.history.show');
        
        // Review
        Route::get('/review/create/{order}', [ReviewController::class, 'create'])->name('review.create');
        Route::post('/review/store/{order}', [ReviewController::class, 'store'])->name('review.store');
    });


    // --- SELLER ROUTES ---
    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        
        // Halaman Pending (Bisa diakses meski belum diapprove)
        Route::get('/pending', function () {
            return view('seller.pending');
        })->name('pending');

        // Area Seller yang Disetujui
        Route::middleware('status:approved')->group(function () {
            
            Route::get('/dashboard', function () {
                return view('seller.dashboard');
            })->name('dashboard');

            // Store Management
            Route::get('/store', [StoreController::class, 'index'])->name('store.index');
            Route::post('/store', [StoreController::class, 'update'])->name('store.update');

            // Product CRUD
            Route::resource('products', SellerProductController::class);

            // Order Management
            Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
            Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update_status');
        });
    });


    // --- ADMIN ROUTES ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // User & Category Management
        Route::resource('users', AdminUserController::class);
        Route::resource('categories', AdminCategoryController::class);

        // Seller Verification
        Route::get('/verification', [SellerVerificationController::class, 'index'])->name('verification.index');
        Route::post('/verification/{user}', [SellerVerificationController::class, 'update'])->name('verification.update');

        // Product Moderation
        Route::get('/moderation/products', [AdminProductModerationController::class, 'index'])->name('moderation.products.index');
        Route::delete('/moderation/products/{product}', [AdminProductModerationController::class, 'destroy'])->name('moderation.products.destroy');
    });

});

// Load Auth Routes (Login, Register, dll)
require __DIR__.'/auth.php';