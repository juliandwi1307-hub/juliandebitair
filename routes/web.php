<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DBAdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\TagihController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DBPenggunaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\WaterUsageController;

Route::get('/', function () {
    return view('layout/login');
});

// Login & Logout
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/keluar', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard-admin', [DBAdminController::class, 'index'])->name('dashboard-admin');
    // Kelola Pengguna
    Route::prefix('pengguna')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/create', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('/', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/{id}/meter', [PenggunaController::class, 'getMeter'])->name('pengguna.meter');
        Route::get('/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
        Route::put('/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    });
    // Kelola Admin
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });
    // Kelola Tagihan
    Route::prefix('tagihan')->group(function () {
        Route::get('/', [TagihController::class, 'index'])->name('tagihan.index');
        Route::get('/create', [TagihController::class, 'create'])->name('tagihan.create');
        Route::post('/', [TagihController::class, 'store'])->name('tagihan.store');
        Route::get('/{id}', [TagihController::class, 'edit'])->name('tagihan.edit');
        Route::put('/{id}', [TagihController::class, 'update'])->name('tagihan.update');
        Route::delete('/{id}', [TagihController::class, 'destroy'])->name('tagihan.destroy');
    });
    // Water Usage Admin
    Route::get('/waterusage', [WaterUsageController::class, 'adminIndex'])->name('waterusage.admin.index');
    Route::get('/waterusage/{id}', [WaterUsageController::class, 'adminShow'])->name('waterusage.admin.show');
    Route::post('/waterusage/{id}/toggle-status', [WaterUsageController::class, 'toggleStatus'])->name('waterusage.admin.toggle');

    // Pengaturan Sistem
    Route::prefix('pengaturan')->group(function () {
        Route::get('/', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/info/{id}', [PengaturanController::class, 'updateInfo'])->name('pengaturan.updateInfo');
        Route::put('/tarif/{id}', [PengaturanController::class, 'updateTarif'])->name('pengaturan.updateTarif');
    });
});

Route::middleware(['auth:web'])->group(function () {

    // Dashboard Pengguna
    Route::get('/dashboard-pengguna', [DBPenggunaController::class, 'index'])->name('dashboard-pengguna');

    // Water Usage Pengguna
    Route::get('/pemakaian-air', [WaterUsageController::class, 'userIndex'])->name('waterusage.user.index');

    // Riwayat dan Proses Pembayaran
    Route::prefix('infobayar')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('infobayar.index');
    });

    // Payment Midtrans
    Route::get('/pembayaran/{id}/bayar', [\App\Http\Controllers\PaymentController::class, 'pay'])->name('pembayaran.bayar');
    Route::post('/pembayaran/{id}/cancel', [\App\Http\Controllers\PaymentController::class, 'cancelPayment'])->name('pembayaran.cancel');
});

// Midtrans Webhook (No Auth Required)
Route::post('/midtrans/callback', [\App\Http\Controllers\PaymentController::class, 'callback']);
