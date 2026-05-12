<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard.dashboard');

// Data Produk Routes
Route::prefix('produk')->group(function () {
    Route::get('/', function () {
        return view('produk.index');
    })->name('produk.index');

    Route::get('/kategori', function () {
        return view('produk.kategori');
    })->name('kategori.index');
});

// Transaksi Masuk Routes
Route::prefix('transaksi')->group(function () {
    Route::get('/', function () {
        return view('transaksi.index');
    })->name('transaksi.index');

    Route::get('/input', function () {
        return view('transaksi.input');
    })->name('transaksi.input');
});

// Supplier Route
Route::get('/supplier', function () {
    return view('supplier.index');
})->name('supplier.index');

// Proses Route
Route::get('/proses', function () {
    return view('proses');
})->name('proses.index');

// Stok Opname Routes
Route::prefix('stok-opname')->group(function () {
    Route::get('/periode', function () {
        return view('stok.opname1');
    })->name('stok.opname1');

    Route::get('/input', function () {
        return view('stok.opname2');
    })->name('stok.opname2');

    Route::get('/laporan', function () {
        return view('stok.opname3');
    })->name('stok.opname3');
});

// Laporan Route
Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan.index');

// Pengaturan Route
Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan.index');
