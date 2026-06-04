# 🔐 Role-Based Access Control (RBAC) — Admin Panel

> Dokumen ini menjabarkan pembagian hak akses berdasarkan peran (role) dalam sistem Admin Panel toko ini.
> Terdapat **2 role**: `admin` dan `staff`.

---

## 📋 Daftar Isi

1. [Filosofi Pembagian Akses](#filosofi)
2. [Ringkasan Role](#ringkasan-role)
3. [Matriks Hak Akses Per Fitur](#matriks-hak-akses)
4. [Detail Pembatasan Staff](#detail-pembatasan-staff)
5. [Alasan & Pencegahan Kecurangan](#alasan--pencegahan-kecurangan)
6. [Rencana Implementasi Teknis](#rencana-implementasi-teknis)

---

## Filosofi

Pembagian akses mengikuti prinsip **Least Privilege** (hak minimum yang diperlukan) dan **Separation of Duties** (pemisahan tanggung jawab):

- **Staff** bertugas operasional harian: input transaksi, input stok opname, dan melihat data.
- **Admin** adalah pengawas dan pengambil keputusan: menyetujui penyesuaian, mengelola master data, melihat laporan keuangan, dan mengatur sistem.
- Tidak ada satu pihak pun yang bisa melakukan seluruh alur kerja sendirian tanpa jejak audit → **mencegah kolusi dan fraud**.

---

## Ringkasan Role

| Role    | Deskripsi                                                                 |
|---------|---------------------------------------------------------------------------|
| `admin` | Pemilik toko / manajer. Akses penuh ke semua fitur termasuk laporan dan pengaturan sistem. |
| `staff` | Karyawan operasional. Hanya bisa melakukan pekerjaan harian, tidak bisa mengubah data sensitif atau menyetujui penyesuaian. |

---

## Matriks Hak Akses

### 🏠 Dashboard

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat dashboard (statistik umum) | ✅ | ✅ |
| Lihat total nilai inventori (Rp) | ✅ | ❌ |
| Filter chart (Daily / Weekly / Monthly) | ✅ | ✅ |
| Lihat produk stok rendah | ✅ | ✅ |

> **Alasan**: Staff tidak perlu tahu total nilai aset inventori. Informasi keuangan sensitif hanya untuk admin/pemilik.

---

### 📦 Produk

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar produk | ✅ | ✅ |
| Tambah produk baru | ✅ | ❌ |
| Edit data produk (nama, harga, stok minimum) | ✅ | ❌ |
| Hapus produk | ✅ | ❌ |

> **Alasan**: Staff tidak boleh mengubah harga atau menghapus produk. Ini mencegah manipulasi harga (misal staff menurunkan harga lalu membeli sendiri) dan penghapusan jejak produk yang sudah dijual.

---

### 🏷️ Kategori

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar kategori | ✅ | ✅ |
| Tambah kategori baru | ✅ | ❌ |
| Edit kategori | ✅ | ❌ |
| Hapus kategori | ✅ | ❌ |

> **Alasan**: Kategori adalah master data. Perubahan master data harus dikontrol admin agar tidak terjadi pengkategorian ulang yang menyembunyikan produk dari laporan.

---

### 🔄 Transaksi (Stok Masuk & Keluar)

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar transaksi | ✅ | ✅ |
| Input transaksi baru (masuk/keluar) | ✅ | ✅ |
| Cetak surat jalan | ✅ | ✅ |
| **Hapus transaksi** | ✅ | ❌ |

> **Alasan kritis**: Penghapusan transaksi adalah tindakan berisiko tinggi. Staff yang bisa menghapus transaksi bisa menyembunyikan pengambilan barang ilegal (misal: keluar 10 unit → dihapus → tidak terlacak). Hanya admin yang boleh menghapus, dan sebaiknya disertai konfirmasi password.

---

### 🏭 Supplier

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar supplier | ✅ | ✅ |
| Tambah supplier baru | ✅ | ❌ |
| Edit data supplier | ✅ | ❌ |
| Hapus supplier | ✅ | ❌ |

> **Alasan**: Manipulasi data supplier bisa digunakan untuk skema penipuan (ghost supplier), di mana staff membuat supplier palsu untuk mencatat transaksi masuk fiktif. Pengelolaan supplier hanya boleh dilakukan admin.

---

### 🔁 Proses (Retur / Proses Internal)

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar proses | ✅ | ✅ |
| Tambah proses baru | ✅ | ✅ |
| Edit proses | ✅ | ❌ |
| Hapus proses | ✅ | ❌ |

> **Alasan**: Staff diperbolehkan menginput proses baru sebagai bagian dari operasional harian (misal: cacat produk, retur). Namun edit dan hapus dibatasi ke admin untuk mencegah manipulasi data setelah fakta.

---

### 📊 Stok Opname

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar periode opname | ✅ | ✅ |
| **Buat periode opname baru** | ✅ | ❌ |
| **Edit keterangan periode** | ✅ | ❌ |
| **Hapus periode opname** | ✅ | ❌ |
| Input stok fisik (opname2) | ✅ | ✅ |
| Lihat laporan hasil opname | ✅ | ✅ |
| **Sinkronisasi / Adjust Stok** | ✅ | ❌ |

> **Alasan kritis — dua lapis pengamanan**:
> 1. **Staff boleh input stok fisik** → ini adalah pekerjaan mereka di lapangan (menghitung fisik barang).
> 2. **Staff TIDAK bisa membuat periode opname** → mencegah staff membuat opname bodong atau mengatur timing opname untuk menutupi selisih.
> 3. **Staff TIDAK bisa menekan tombol "Sesuaikan Stok"** → penyesuaian stok bersifat permanen dan mengubah data inventori utama. Harus diverifikasi admin setelah meninjau laporan selisih.
>
> Alur yang aman: **Admin buka periode → Staff input fisik → Admin review → Admin adjust stok**.

---

### 📈 Laporan

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat halaman laporan | ✅ | ❌ |
| Export laporan produk (Excel) | ✅ | ❌ |
| Export laporan transaksi (PDF/Excel) | ✅ | ❌ |
| Export laporan stok opname (PDF/Excel) | ✅ | ❌ |

> **Alasan**: Laporan berisi data keuangan dan performa bisnis yang bersifat rahasia. Staff tidak memerlukan akses laporan untuk menjalankan tugas harian. Membatasi akses laporan juga mencegah kebocoran informasi kompetitif.

---

### ⚙️ Pengaturan Sistem

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Akses halaman pengaturan | ✅ | ❌ |
| Ubah pengaturan aplikasi | ✅ | ❌ |

---

### 👤 Manajemen User (Fitur yang Perlu Ditambahkan)

| Fitur | Admin | Staff |
|-------|:-----:|:-----:|
| Lihat daftar user | ✅ | ❌ |
| Tambah user baru | ✅ | ❌ |
| Edit role / password user lain | ✅ | ❌ |
| Hapus user | ✅ | ❌ |
| Ubah password sendiri | ✅ | ✅ |

> **Catatan**: Fitur manajemen user belum ada di sistem saat ini, namun **wajib ditambahkan** agar admin bisa mengelola akun staff tanpa perlu akses langsung ke database.

---

## Detail Pembatasan Staff

Berikut ringkasan fitur yang **TIDAK** dapat diakses staff, beserta alasan singkatnya:

| ❌ Fitur yang Dibatasi | Risiko Jika Staff Bisa Akses |
|------------------------|------------------------------|
| Hapus transaksi | Menutupi pengambilan barang ilegal |
| Tambah/edit/hapus produk | Manipulasi harga, penghapusan jejak produk |
| Tambah/edit/hapus supplier | Skema ghost supplier / fraud pengadaan |
| Buat & hapus periode opname | Manipulasi timing dan cakupan opname |
| Sesuaikan stok (Adjust) | Mengubah data inventori tanpa persetujuan |
| Lihat nilai inventori di dashboard | Kebocoran informasi keuangan sensitif |
| Semua laporan (export) | Kebocoran data bisnis dan keuangan |
| Pengaturan sistem | Sabotase konfigurasi aplikasi |
| Manajemen user | Buat akun admin baru / ubah hak akses sendiri |

---

## Alasan & Pencegahan Kecurangan

### Mencegah Kecurangan dari Sisi Staff

1. **Tidak bisa hapus transaksi** → setiap gerakan barang tercatat permanen.
2. **Tidak bisa mengubah harga** → tidak bisa menjual dengan harga di bawah modal.
3. **Tidak bisa adjust stok sendiri** → pencurian fisik akan terdeteksi saat opname karena staff tidak bisa memanipulasi hasil akhir.
4. **Tidak bisa buat periode opname** → admin yang menentukan kapan dan bagaimana opname dilakukan.
5. **Tidak bisa akses laporan** → tidak ada gambaran "batas aman" untuk melakukan kecurangan.

### Mencegah Kecurangan dari Sisi Admin

> Meskipun admin punya akses penuh, kecurangan dari admin bisa diminimalisir dengan:

1. **Audit Trail / Activity Log** *(disarankan ditambahkan)*: Setiap aksi admin (hapus transaksi, adjust stok, ubah harga) harus dicatat dengan timestamp dan user ID.
2. **Double Confirmation** untuk aksi destruktif: Hapus data dan Adjust Stok harus meminta konfirmasi ulang (misal: ketik password).
3. **Notifikasi ke Pemilik** *(opsional)*: Jika ada admin lain, penyesuaian stok bisa dikirim notifikasi ke email pemilik.
4. **Read-Only Audit Role** *(opsional, jika perlu)*: Pemilik toko sebagai role `owner` yang hanya bisa lihat semua data tapi tidak bisa ubah apapun — ideal untuk audit eksternal.

---

## Rencana Implementasi Teknis

### 1. Middleware RBAC

Buat middleware `CheckRole` di Laravel:

```php
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, string ...$roles): Response
{
    if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
        abort(403, 'Akses ditolak.');
    }
    return $next($request);
}
```

### 2. Registrasi Middleware

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

### 3. Proteksi Route

```php
// routes/web.php — contoh

// Hanya admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy']);
    Route::post('/stok-opname/periode', [StokOpnameController::class, 'storePeriode']);
    Route::post('/stok-opname/periode/{periode}/adjust', [StokOpnameController::class, 'adjustStock']);
    Route::prefix('laporan')->group(function () { /* semua laporan */ });
    Route::get('/pengaturan', [PengaturanController::class, 'index']);
});

// Admin dan staff
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::post('/stok-opname/item/{item}/report', [StokOpnameController::class, 'reportItem']);
});
```

### 4. Sembunyikan Elemen UI Berdasarkan Role

Di Blade template, gunakan helper `isAdmin()` yang sudah ada di model User:

```blade
{{-- Tombol hapus hanya untuk admin --}}
@if(auth()->user()->isAdmin())
    <button class="btn-delete">Hapus</button>
@endif

{{-- Link laporan hanya untuk admin --}}
@if(auth()->user()->isAdmin())
    <a href="{{ route('laporan.index') }}">Laporan</a>
@endif
```

### 5. Validasi di Controller (Defense in Depth)

Selain route middleware, tambahkan validasi di controller sebagai lapisan kedua:

```php
public function destroy(Transaksi $transaksi)
{
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Hanya admin yang dapat menghapus transaksi.');
    }
    // ...
}
```

---

## 📌 Catatan Penting

> [!IMPORTANT]
> Pembatasan UI saja **tidak cukup**. Selalu lindungi route di backend menggunakan middleware, karena user yang paham teknis bisa mengakses URL langsung.

> [!WARNING]
> Saat ini semua route tidak menggunakan middleware `auth`. Sebelum mengimplementasi RBAC, pastikan middleware `auth` sudah dipasang di semua route yang perlu proteksi.

> [!TIP]
> Pertimbangkan menambahkan **activity log** (paket: `spatie/laravel-activitylog`) untuk merekam setiap aksi penting (hapus transaksi, adjust stok, ubah harga produk) sebagai lapisan audit tambahan.

---

*Dokumen ini dibuat berdasarkan analisis route dan controller pada proyek AdminPanel.*  
*Terakhir diperbarui: Juni 2026*
