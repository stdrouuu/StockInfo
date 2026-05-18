<?php

namespace Database\Seeders;

use App\Models\StokOpnamePeriode;
use App\Models\StokOpnameItem;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class StokOpnameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $produks = Produk::all();

        // Periode 1 - Oktober 2025 (Lengkap, Tidak Aktif)
        $periode1 = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2025-10-01',
            'tanggal_selesai'  => '2025-10-30',
            'keterangan'       => 'Stok Opname Gudang A - Oktober 2025',
            'status_kerja'     => 'tidak_aktif',
            'status_pelaporan' => 'lengkap',
            'user_id'          => $admin->id,
        ]);

        // Semua barang sesuai di periode 1
        foreach ($produks->take(5) as $produk) {
            StokOpnameItem::create([
                'periode_id'  => $periode1->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok,
                'selisih'     => 0,
            ]);
        }

        // Periode 2 - September 2025 (Lengkap, ada selisih)
        $periode2 = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2025-09-01',
            'tanggal_selesai'  => '2025-09-29',
            'keterangan'       => 'Stok Opname Gudang B - September 2025',
            'status_kerja'     => 'tidak_aktif',
            'status_pelaporan' => 'lengkap',
            'user_id'          => $admin->id,
        ]);

        foreach ($produks->take(4) as $index => $produk) {
            $selisih = ($index === 1 || $index === 3) ? 2 : 0;
            StokOpnameItem::create([
                'periode_id'  => $periode2->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok + $selisih,
                'selisih'     => $selisih,
                'catatan'     => $selisih > 0 ? 'Ditemukan selisih saat pengecekan fisik' : null,
            ]);
        }

        // Periode 3 - Aktif, Belum Lengkap
        $periode3 = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2025-11-01',
            'tanggal_selesai'  => '2025-11-30',
            'keterangan'       => 'Stok Opname Gudang A - November 2025',
            'status_kerja'     => 'aktif',
            'status_pelaporan' => 'belum_lengkap',
            'user_id'          => $admin->id,
        ]);

        // Baru sebagian yang diinput
        foreach ($produks->take(3) as $produk) {
            StokOpnameItem::create([
                'periode_id'  => $periode3->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok,
                'selisih'     => 0,
            ]);
        }

        // Periode 4 - Selesai
        $periode4 = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2025-08-01',
            'tanggal_selesai'  => '2025-08-31',
            'keterangan'       => 'Stok Opname Tahunan - Agustus 2025',
            'status_kerja'     => 'tidak_aktif',
            'status_pelaporan' => 'selesai',
            'user_id'          => $admin->id,
        ]);

        foreach ($produks->take(8) as $produk) {
            StokOpnameItem::create([
                'periode_id'  => $periode4->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok,
                'selisih'     => 0,
            ]);
        }
    }
}
