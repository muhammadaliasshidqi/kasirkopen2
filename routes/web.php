<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;

// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Protected routes
Route::middleware(['kasir.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/nama', [ProfileController::class, 'updateNamaKasir'])->name('profile.updateNamaKasir');
    Route::put('/profile/username', [ProfileController::class, 'updateUsername'])->name('profile.updateUsername');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/profile/account/create', [ProfileController::class, 'createAccount'])->name('profile.createAccount');
    Route::delete('/profile/account/{id}', [ProfileController::class, 'deleteAccount'])->name('profile.deleteAccount');

    // Menu Management
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menu}', [MenuController::class, 'show'])->name('show');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
        Route::post('/{menu}/stok', [MenuController::class, 'updateStok'])->name('updateStok');
    });
    
    // Transaksi (POS & History)
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index'); // POS Page
        Route::post('/', [TransaksiController::class, 'store'])->name('store'); // Process Transaction
        Route::get('/history', [TransaksiController::class, 'history'])->name('history'); // Transaction History
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show'); // Detail Transaction
        Route::get('/{transaksi}/print', [TransaksiController::class, 'printStruk'])->name('print'); // Print Receipt
        Route::delete('/{transaksi}', [TransaksiController::class, 'cancel'])->name('cancel'); // Cancel Transaction
    });
    
    // Laporan (Reports)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/pdf', [LaporanController::class, 'exportPdf'])->name('pdf');
        Route::get('/excel', [LaporanController::class, 'exportExcel'])->name('excel');
        Route::post('/save', [LaporanController::class, 'save'])->name('save');
    });
});