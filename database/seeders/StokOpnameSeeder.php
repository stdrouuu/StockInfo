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

        // 1. Maret 2026 (Tidak Aktif, Selesai, 15 Sesuai, 0 Selisih, Sinkron) - ID Terkecil
        $periodeMar = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2026-03-01',
            'tanggal_selesai'  => '2026-03-31',
            'keterangan'       => 'MARET - Stok Opname Gudang 2026',
            'status_kerja'     => 'tidak_aktif',
            'status_pelaporan' => 'selesai',
            'is_adjusted'      => true,
            'user_id'          => $admin->id,
        ]);

        foreach ($produks as $produk) {
            StokOpnameItem::create([
                'periode_id'  => $periodeMar->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok,
                'selisih'     => 0,
                'catatan'     => 'sesuai',
            ]);
        }

        // 2. April 2026 (Tidak Aktif, Selesai, 14 Sesuai, 1 Selisih, Sinkron)
        $periodeApr = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2026-04-01',
            'tanggal_selesai'  => '2026-04-30',
            'keterangan'       => 'APRIL - Stok Opname Gudang 2026',
            'status_kerja'     => 'tidak_aktif',
            'status_pelaporan' => 'selesai',
            'is_adjusted'      => true,
            'user_id'          => $admin->id,
        ]);

        foreach ($produks as $index => $produk) {
            $hasDiff = $index === 0; // 1 item has difference
            $selisih = $hasDiff ? 1 : 0;
            StokOpnameItem::create([
                'periode_id'  => $periodeApr->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok + $selisih,
                'selisih'     => $selisih,
                'catatan'     => $hasDiff ? 'kelebihan 1 unit' : 'sesuai',
            ]);
        }

        // 3. Mei 2026 (Tidak Aktif, Selesai, 15 Sesuai, 0 Selisih, Siap Sinkron)
        $periodeMei = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2026-05-01',
            'tanggal_selesai'  => '2026-05-31',
            'keterangan'       => 'MEI - Stok Opname Gudang 2026',
            'status_kerja'     => 'tidak_aktif',
            'status_pelaporan' => 'selesai',
            'is_adjusted'      => false,
            'user_id'          => $admin->id,
        ]);

        foreach ($produks as $produk) {
            StokOpnameItem::create([
                'periode_id'  => $periodeMei->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok,
                'selisih'     => 0,
                'catatan'     => 'sesuai',
            ]);
        }

        // 4. Juni 2026 (Aktif, Belum Lengkap, 5 Sesuai, 0 Selisih, 10 Belum Dilaporkan) - ID Terbesar (Paling Atas)
        $periodeJun = StokOpnamePeriode::create([
            'tanggal_mulai'    => '2026-06-01',
            'tanggal_selesai'  => '2026-06-30',
            'keterangan'       => 'JUNI - Stok Opname Gudang 2026',
            'status_kerja'     => 'aktif',
            'status_pelaporan' => 'belum_lengkap',
            'is_adjusted'      => false,
            'user_id'          => $admin->id,
        ]);

        foreach ($produks as $index => $produk) {
            $isReported = $index < 5; // 5 items reported
            StokOpnameItem::create([
                'periode_id'  => $periodeJun->id,
                'produk_id'   => $produk->id,
                'stok_sistem' => $produk->stok,
                'stok_fisik'  => $produk->stok,
                'selisih'     => 0,
                'catatan'     => $isReported ? 'sesuai' : 'belum dilaporkan',
            ]);
        }
    }
}
