<?php

// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rute untuk halaman utama, mengarahkan ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute untuk login sebagai tamu
Route::get('/login/guest', [AuthenticatedSessionController::class, 'loginAsGuest'])->name('login.guest');


Route::get('/dashboard', function () {
    // Logika untuk menampilkan halaman berbeda berdasarkan role
    if (Auth::check() && Auth::user()->role == 'admin') {
        // Jika admin, redirect ke halaman manajemen menu
        return redirect()->route('menu.index');
    } else {
        // Jika mahasiswa, tampilkan view daftar menu untuk order
        $menus = \App\Models\Menu::where('stok', '>', 0)->get();
        return view('dashboard', compact('menus'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// ======================================================================
// GRUP RUTE UNTUK SEMUA USER YANG SUDAH LOGIN (Mahasiswa & Admin)
// ======================================================================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Keranjang Belanja
    Route::post('/cart/add/{menu}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::delete('/cart/remove/{menuId}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Proses Pemesanan
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

    // ▼▼▼ RUTE BARU: RIWAYAT PESANAN UNTUK MAHASISWA ▼▼▼
    Route::get('/my-orders', [OrderController::class, 'historyUser'])->name('user.orders.history');
});

// ======================================================================
// GRUP RUTE HANYA UNTUK ADMIN
// ======================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    // CRUD Menu
    Route::resource('menu', MenuController::class);
    
    // Manajemen Pesanan Admin
    Route::get('/orders', [OrderController::class, 'indexAdmin'])->name('admin.orders.index');
    Route::patch('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('admin.orders.complete');
    
    // ▼▼▼ RUTE BARU: RIWAYAT PESANAN UNTUK ADMIN ▼▼▼
    Route::get('/admin/orders/history', [OrderController::class, 'historyAdmin'])->name('admin.orders.history');
});


require __DIR__.'/auth.php';