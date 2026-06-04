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

// Protected Routes - Semua route di dalam grup ini wajib LOGIN (middleware auth)
// Pembagian Hak Akses (RBAC) dalam grup ini:
// - 'admin': Akses penuh ke semua modul, termasuk manajemen data master, laporan keuangan/bisnis, pengaturan, dan tindakan berisiko tinggi (hapus, sesuaikan stok).
// - 'staff': Akses terbatas untuk operasional harian. Bisa membaca data master (produk, kategori, supplier) dan melakukan input (transaksi baru, input opname fisik, proses), tetapi dilarang menghapus atau memanipulasi data yang krusial.
Route::middleware(['auth'])->group(function () {
    // Dashboard Route (Bisa diakses oleh Admin & Staff yang sudah login)
    // Catatan RBAC: Halaman dashboard menampilkan statistik umum untuk semua role. Namun, total nilai aset inventori (keuangan sensitif) akan disembunyikan di sisi view jika user adalah 'staff'.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.dashboard');

    // Data Produk Routes (Menu produk dasar)
    Route::prefix('produk')->group(function () {
        // Melihat daftar produk dan kategori (Bisa diakses Admin & Staff untuk operasional harian)
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

        // Proteksi Tambahan (RBAC: Admin Only)
        // Hanya Admin yang diperbolehkan memodifikasi master data produk & kategori.
        // Hal ini untuk mencegah staff memanipulasi harga barang atau menghapus riwayat produk.
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/', [ProdukController::class, 'store'])->name('produk.store');
            Route::put('/{produk}', [ProdukController::class, 'update'])->name('produk.update');
            Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

            Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
            Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
            Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        });
    });

    // Transaksi Routes (Stok Masuk & Keluar)
    Route::prefix('transaksi')->group(function () {
        // RBAC: Admin & Staff bisa melihat daftar transaksi, menginput transaksi baru, dan mencetak surat jalan.
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/{transaksi}/cetak-surat-jalan', [TransaksiController::class, 'cetakSuratJalan'])->name('transaksi.cetak-surat-jalan');

        Route::get('/input', function () {
            return redirect()->route('transaksi.index');
        })->name('transaksi.input');

        // RBAC: Admin Only
        // Tindakan menghapus transaksi dibatasi khusus untuk Admin demi mencegah penipuan/fraud (misalnya staff menghapus transaksi keluar untuk menyembunyikan hilangnya barang).
        Route::middleware(['role:admin'])->group(function () {
            Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
        });
    });

    // Supplier Routes
    Route::prefix('supplier')->group(function () {
        // RBAC: Admin & Staff bisa melihat daftar supplier untuk kebutuhan pencatatan transaksi masuk.
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');

        // RBAC: Admin Only
        // Menambah, mengedit, atau menghapus supplier dibatasi hanya untuk Admin demi menghindari penipuan supplier fiktif (ghost supplier).
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/', [SupplierController::class, 'store'])->name('supplier.store');
            Route::put('/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
            Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        });
    });

    // Proses Routes (Retur & Proses Internal)
    Route::prefix('proses')->group(function () {
        // RBAC: Admin & Staff bisa melihat list proses dan mencatat proses baru (misalnya retur atau barang rusak).
        Route::get('/', [ProsesController::class, 'index'])->name('proses.index');
        Route::post('/', [ProsesController::class, 'store'])->name('proses.store');

        // RBAC: Admin Only
        // Mengedit dan menghapus catatan proses yang telah terjadi hanya boleh dilakukan oleh Admin untuk menjaga integritas riwayat audit.
        Route::middleware(['role:admin'])->group(function () {
            Route::put('/{prose}', [ProsesController::class, 'update'])->name('proses.update');
            Route::delete('/{prose}', [ProsesController::class, 'destroy'])->name('proses.destroy');
        });
    });

    // Stok Opname Routes
    Route::prefix('stok-opname')->group(function () {
        // RBAC: Admin & Staff bisa mengakses menu periode opname, input opname (opname2), mencatat laporan opname per item, dan melihat hasil opname (opname3).
        // Staff bertugas di lapangan untuk menginput hasil penghitungan fisik barang.
        Route::get('/periode', [StokOpnameController::class, 'opname1'])->name('stok.opname1');
        Route::get('/input', [StokOpnameController::class, 'opname2'])->name('stok.opname2');
        Route::post('/item/{item}/report', [StokOpnameController::class, 'reportItem'])->name('stok.reportItem');
        Route::get('/laporan', [StokOpnameController::class, 'opname3'])->name('stok.opname3');

        // RBAC: Admin Only
        // Tindakan membuat periode opname baru, mengedit keterangan, menghapus periode, dan menyetujui penyesuaian stok (adjust stock)
        // dibatasi khusus untuk Admin. Ini memastikan penyesuaian inventori permanen harus diverifikasi oleh pemilik/manajer.
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/periode', [StokOpnameController::class, 'storePeriode'])->name('stok.storePeriode');
            Route::put('/periode/{periode}', [StokOpnameController::class, 'updatePeriode'])->name('stok.updatePeriode');
            Route::delete('/periode/{periode}', [StokOpnameController::class, 'destroyPeriode'])->name('stok.destroyPeriode');
            Route::post('/periode/{periode}/adjust', [StokOpnameController::class, 'adjustStock'])->name('stok.adjustStock');
        });
    });

    // Laporan Route Group (RBAC: Admin Only)
    // Laporan berisi data keuangan, performa bisnis, dan ringkasan inventori bernilai Rp yang bersifat rahasia/sensitif.
    Route::middleware(['role:admin'])->prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/produk/excel', [LaporanController::class, 'exportProdukExcel'])->name('laporan.produk.excel');
        Route::get('/transaksi/pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('laporan.transaksi.pdf');
        Route::get('/transaksi/excel', [LaporanController::class, 'exportTransaksiExcel'])->name('laporan.transaksi.excel');
        Route::get('/stok-opname/pdf', [LaporanController::class, 'exportStokOpnamePdf'])->name('laporan.stok-opname.pdf');
        Route::get('/stok-opname/excel', [LaporanController::class, 'exportStokOpnameExcel'])->name('laporan.stok-opname.excel');
    });

    // Pengaturan Routes (RBAC: Admin Only)
    // Hanya Admin yang dapat mengubah konfigurasi dasar sistem untuk mencegah sabotase aplikasi.
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    // User Management Routes (RBAC: Admin Only)
    // Mengelola user, menambah staff baru, mengubah role, atau menghapus user sepenuhnya merupakan kewenangan eksklusif Admin.
    Route::middleware(['role:admin'])->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Own Profile Password Update Route (RBAC: Admin & Staff)
    // Semua user (Admin & Staff) diperbolehkan memperbarui password mereka sendiri demi keamanan akun masing-masing.
    Route::put('/profile/password', [UserController::class, 'updateOwnPassword'])->name('profile.password.update');
});
