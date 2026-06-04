<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
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

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.dashboard');

    // Data Produk Routes
    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

        // Admin-only Produk operations
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/', [ProdukController::class, 'store'])->name('produk.store');
            Route::put('/{produk}', [ProdukController::class, 'update'])->name('produk.update');
            Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

            Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
            Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
            Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        });
    });

    // Transaksi Routes
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/{transaksi}/cetak-surat-jalan', [TransaksiController::class, 'cetakSuratJalan'])->name('transaksi.cetak-surat-jalan');

        Route::get('/input', function () {
            return redirect()->route('transaksi.index');
        })->name('transaksi.input');

        // Admin-only Transaksi operations
        Route::middleware(['role:admin'])->group(function () {
            Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
        });
    });

    // Supplier Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');

        // Admin-only Supplier operations
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/', [SupplierController::class, 'store'])->name('supplier.store');
            Route::put('/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
            Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        });
    });

    // Proses Routes
    Route::prefix('proses')->group(function () {
        Route::get('/', [ProsesController::class, 'index'])->name('proses.index');
        Route::post('/', [ProsesController::class, 'store'])->name('proses.store');

        // Admin-only Proses operations
        Route::middleware(['role:admin'])->group(function () {
            Route::put('/{prose}', [ProsesController::class, 'update'])->name('proses.update');
            Route::delete('/{prose}', [ProsesController::class, 'destroy'])->name('proses.destroy');
        });
    });

    // Stok Opname Routes
    Route::prefix('stok-opname')->group(function () {
        Route::get('/periode', [StokOpnameController::class, 'opname1'])->name('stok.opname1');
        Route::get('/input', [StokOpnameController::class, 'opname2'])->name('stok.opname2');
        Route::post('/item/{item}/report', [StokOpnameController::class, 'reportItem'])->name('stok.reportItem');
        Route::get('/laporan', [StokOpnameController::class, 'opname3'])->name('stok.opname3');

        // Admin-only Stok Opname operations
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/periode', [StokOpnameController::class, 'storePeriode'])->name('stok.storePeriode');
            Route::put('/periode/{periode}', [StokOpnameController::class, 'updatePeriode'])->name('stok.updatePeriode');
            Route::delete('/periode/{periode}', [StokOpnameController::class, 'destroyPeriode'])->name('stok.destroyPeriode');
            Route::post('/periode/{periode}/adjust', [StokOpnameController::class, 'adjustStock'])->name('stok.adjustStock');
        });
    });

    // Laporan Route Group (Admin Only)
    Route::middleware(['role:admin'])->prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/produk/excel', [LaporanController::class, 'exportProdukExcel'])->name('laporan.produk.excel');
        Route::get('/transaksi/pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('laporan.transaksi.pdf');
        Route::get('/transaksi/excel', [LaporanController::class, 'exportTransaksiExcel'])->name('laporan.transaksi.excel');
        Route::get('/stok-opname/pdf', [LaporanController::class, 'exportStokOpnamePdf'])->name('laporan.stok-opname.pdf');
        Route::get('/stok-opname/excel', [LaporanController::class, 'exportStokOpnameExcel'])->name('laporan.stok-opname.excel');
    });

    // Pengaturan Routes (Admin Only)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    // User Management Routes (Admin Only)
    Route::middleware(['role:admin'])->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Own Profile Password Update Route
    Route::put('/profile/password', [UserController::class, 'updateOwnPassword'])->name('profile.password.update');
});
