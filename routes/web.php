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

// Shortcut khusus dev untuk logout cepat via GET url (diketik manual)
Route::get('/logout-cepat', function () {
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login')->with('status', 'Anda telah otomatis logout dari sesi sebelumnya.');
});

// Dashboard Route
Route::get('/dashboard', function () {
    if (!session('is_logged_in')) {
        return redirect('/login');
    }
    return view('dashboard');
})->name('dashboard');
