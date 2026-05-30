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

        $trxOut1 = \App\Models\Transaksi::where('tipe', 'keluar')->first();
        $trxOut2 = \App\Models\Transaksi::where('tipe', 'keluar')->skip(1)->first();

        Proses::create([
            'transaksi_id'    => $trxOut1 ? $trxOut1->id : null,
            'produk_id'       => ($trxOut1 && $trxOut1->items->first()) ? $trxOut1->items->first()->produk_id : $besiBeton->id,
            'no_surat_jalan'  => 'DO/2025/001',
            'status'          => 'on-going',
            'kategori_proses' => 'Construction',
            'keterangan'      => 'Pengiriman besi ke lokasi proyek',
        ]);

        Proses::create([
            'transaksi_id'    => $trxOut2 ? $trxOut2->id : null,
            'produk_id'       => ($trxOut2 && $trxOut2->items->first()) ? $trxOut2->items->first()->produk_id : $semen->id,
            'no_surat_jalan'  => 'DO/2025/042',
            'status'          => 'pending',
            'kategori_proses' => 'Raw Material',
            'keterangan'      => 'Menunggu konfirmasi gudang',
        ]);

        Proses::create([
            'transaksi_id'    => $trxOut1 ? $trxOut1->id : null,
            'produk_id'       => ($trxOut1 && $trxOut1->items->count() > 1) ? $trxOut1->items->skip(1)->first()->produk_id : $cat->id,
            'no_surat_jalan'  => 'DO/2025/089',
            'status'          => 'completed',
            'kategori_proses' => 'Finishing',
            'keterangan'      => 'Pengiriman selesai',
        ]);
    }
}
