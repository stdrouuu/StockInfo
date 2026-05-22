<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes (can be placed under middleware auth if desired, but kept open as requested for consistency)
Route::middleware([])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.dashboard');

    // Data Produk Routes
    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::post('/', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    // Transaksi Routes
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

        Route::get('/input', function () {
            return redirect()->route('transaksi.index');
        })->name('transaksi.input');
    });

    // Supplier Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('/', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    });

    // Proses Routes
    Route::prefix('proses')->group(function () {
        Route::get('/', [ProsesController::class, 'index'])->name('proses.index');
        Route::post('/', [ProsesController::class, 'store'])->name('proses.store');
        Route::put('/{prose}', [ProsesController::class, 'update'])->name('proses.update');
        Route::delete('/{prose}', [ProsesController::class, 'destroy'])->name('proses.destroy');
    });

    // Stok Opname Routes
    Route::prefix('stok-opname')->group(function () {
        Route::get('/periode', [StokOpnameController::class, 'opname1'])->name('stok.opname1');
        Route::post('/periode', [StokOpnameController::class, 'storePeriode'])->name('stok.storePeriode');

        Route::get('/input', [StokOpnameController::class, 'opname2'])->name('stok.opname2');
        Route::post('/item/{item}/report', [StokOpnameController::class, 'reportItem'])->name('stok.reportItem');

        Route::get('/laporan', [StokOpnameController::class, 'opname3'])->name('stok.opname3');
    });

    // Laporan Route
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Pengaturan Route
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
});
