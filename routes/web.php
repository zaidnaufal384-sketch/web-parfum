<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes (Versi Bersih & Final)
|--------------------------------------------------------------------------
*/

// --- HALAMAN DEPAN (PUBLIK) ---
Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/product/{slug}', [FrontController::class, 'details'])->name('front.details');
Route::get('/category/{slug}', [FrontController::class, 'category'])->name('front.category');

// --- DASHBOARD REDIRECT ---
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- PROFILE USER ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- AREA KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Kategori
    Route::resource('categories', CategoryController::class);

    // Manajemen Produk
    Route::resource('products', ProductController::class);
    
    Route::resource('notes', NoteController::class);

    Route::get('/collections', [FrontController::class, 'catalog'])->name('front.catalog');
});

Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/product/{slug}', [FrontController::class, 'details'])->name('front.details');

// 👇 TAMBAHKAN BARIS INI (PENTING)
Route::get('/collections', [FrontController::class, 'catalog'])->name('front.catalog');

Route::get('/category/{slug}', [FrontController::class, 'category'])->name('front.category');

// Buka routes/web.php, tambahkan baris ini di bawah route details:
Route::get('/collections', [FrontController::class, 'catalog'])->name('front.catalog');


// --- KERANJANG BELANJA (CART) ---
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'store'])->name('cart.add');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    Route::patch('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // --- CHECKOUT ---
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

    // --- ADMIN ORDERS ---
    Route::get('/admin/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('admin.orders.update');

    Route::middleware(['auth'])->group(function () {
    // ... route profile dll ...
    
    // Route Riwayat Pesanan
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
}



);

use App\Http\Controllers\CartController;

Route::middleware(['auth'])->group(function () {
    // ... route lainnya ...
    
    // Route Halaman Keranjang (Yang dibuka tombol hitam bawah)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Route Data Keranjang (Yang dipakai Sidebar Loading) - BARU
    Route::get('/cart/data', [CartController::class, 'api'])->name('cart.api');
    
    // Route untuk menampilkan halaman daftar wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    
    // Route toggle yang sudah kita buat sebelumnya
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    // ... route store, destroy, dll ...
});

Route::get('/orders/history', [OrderController::class, 'history'])->middleware('auth')->name('orders.history');

Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('auth')->name('orders.show');

// Tambahkan di dalam group middleware(['auth'])
Route::middleware(['auth'])->group(function () {
    // ...
    Route::get('/orders/{order}/payment', [OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/orders/{order}/payment', [OrderController::class, 'uploadPayment'])->name('orders.payment.upload');
});

require __DIR__.'/auth.php';