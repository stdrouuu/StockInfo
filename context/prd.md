# Product Requirements Document (PRD): Materia (Sistem Inventaris Toko Material)

## 1. Ringkasan Proyek

Sistem ini dirancang untuk mendigitalisasi operasional toko bangunan (toko material) di Indonesia. Fokus utamanya adalah manajemen stok yang akurat, pemantauan *real-time*, dan kemudahan penggunaan baik di desktop maupun perangkat mobile (lapangan) -> responsiveness

---

## 2. Profil Pengguna & Role-Based Access Control (RBAC)

| Role | Deskripsi | Izin Utama |
| --- | --- | --- |
| **Owner** | Pemilik Toko | Melihat laporan keuangan, total aset stok, analitik performa, dan log aktivitas. |
| **SuperAdmin** | IT/Admin Sistem | Manajemen user, konfigurasi sistem, backup data, dan integrasi API. |
| **Warehouse Staff** | Staf Gudang | Input barang masuk/keluar, update stok, upload foto produk, dan manajemen supplier. |

---

## 3. Fitur Utama & Modul

### 3.1. Modul Inventaris (CRUD)

* **Data Material:** Nama barang (Semen Gresik, Pasir Putih, Besi 10, dll), SKU/Barcode, Kategori, Satuan (Sakti, m3, Batang, Pail).
* **Media:** Upload foto produk langsung via kamera smartphone.
* **Validasi Bisnis:** * Input stok, harga, dan kuantitas dilarang negatif.
* Field wajib: Nama barang, Kategori, dan Stok Minimum.



### 3.2. Pergerakan Stok (Stock Movement)

* **Stock In:** Pencatatan barang masuk dari supplier atau retur pelanggan.
* **Stock Out:** Pencatatan barang keluar untuk penjualan atau pemakaian internal.
* **Adjustment:** Penyesuaian stok jika ada selisih saat *stock opname*.

### 3.3. Inventory Intelligence

* **Status Indikator:** * `Normal`: Stok mencukupi.
* `Low`: Stok di bawah ambang batas (Warning).
* `Critical`: Stok hampir habis/kosong (Danger).


* **Automatic Buffer Stock:** Kalkulasi otomatis untuk stok aman berdasarkan rata-rata penjualan bulanan.

### 3.4. Supplier & Purchase Order (PO)

* **Database Supplier:** Nama vendor, kontak, alamat, dan histori pengiriman.
* **PO System:** Generate dokumen pesanan barang ke supplier saat stok menyentuh level *critical*.

---

## 4. Arsitektur Teknis & UI/UX

### 4.1. Tech Stack

* **Backend:** Laravel (MVC Architecture).
* **Frontend:** Tailwind CSS & Blade Templates.
* **API:** RESTful API untuk komunikasi data.
* **Database:** MySQL dengan PHPMyAdmin.

### 4.2. Desain Antarmuka (UI/UX)

* **Layout:** Sidebar navigasi, Topbar (search, profile, notifications).
* **Theme:** Toggle Light & Dark Mode.
* **Responsive:** Grid sistem yang menyesuaikan dari desktop ke layar sentuh mobile.
* **Controls:** Tombol besar yang *touch-friendly* untuk staf gudang yang menggunakan smartphone di lapangan.

---

## 5. Analitik & Laporan

### 5.1. Dashboard Real-time

* **Metrics Cards:** Total Nilai Stok (Rp), Jumlah Barang Low-Stock, Transaksi Hari Ini.
* **Charts:** Grafik tren keluar masuk barang (Area Chart) dan Top 5 Material Terlaris (Bar Chart).

### 5.2. Pelaporan & Audit

* **Export:** Fitur cetak laporan ke Excel (`.xlsx`) yang disesuaikan dengan format akuntansi bisnis di Indonesia.
* **Audit Trail:** Log aktivitas (siapa mengubah apa dan kapan), histori harga beli/jual, dan pelacakan perubahan stok.

---

## 6. Integrasi

* **Camera Integration:** Akses langsung ke kamera perangkat untuk mempermudah dokumentasi fisik barang saat diterima di gudang.

---

## 7. Business Rules (Validasi)

1. **Stok Tidak Boleh Negatif:** Sistem harus menolak transaksi keluar jika jumlahnya melebihi stok yang tersedia.
2. **Required Fields:** Nama, kategori, dan harga beli adalah data wajib untuk menghindari data "sampah".
3. **Role Restriction:** Warehouse Staff tidak diperbolehkan melihat total nilai aset toko atau laporan laba-rugi.

---