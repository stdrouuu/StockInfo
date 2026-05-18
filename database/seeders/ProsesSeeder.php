<?php

namespace Database\Seeders;

use App\Models\Proses;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $besiBeton = Produk::where('sku', 'BS-002-8MM')->first();
        $semen     = Produk::where('sku', 'ST-001-CM')->first();
        $cat       = Produk::where('sku', 'CT-001-DLX')->first();

        Proses::create([
            'produk_id'       => $besiBeton->id,
            'no_surat_jalan'  => 'DO/2025/001',
            'status'          => 'on-going',
            'kategori_proses' => 'Construction',
            'keterangan'      => 'Pengiriman besi ke lokasi proyek',
        ]);

        Proses::create([
            'produk_id'       => $semen->id,
            'no_surat_jalan'  => 'DO/2025/042',
            'status'          => 'pending',
            'kategori_proses' => 'Raw Material',
            'keterangan'      => 'Menunggu konfirmasi gudang',
        ]);

        Proses::create([
            'produk_id'       => $cat->id,
            'no_surat_jalan'  => 'DO/2025/089',
            'status'          => 'completed',
            'kategori_proses' => 'Finishing',
            'keterangan'      => 'Pengiriman selesai',
        ]);
    }
}
