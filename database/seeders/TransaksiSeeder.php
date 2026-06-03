<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $supplier1 = Supplier::where('nama', 'PT. Semen Merah Putih')->first();
        $supplier2 = Supplier::where('nama', 'Distributor Cat Jotun')->first();
        $supplier3 = Supplier::where('nama', 'PT. Holcim Indonesia')->first();

        // Transaksi 1 - Masuk
        $trx1 = Transaksi::create([
            'kode'        => 'TRX-IN-20260520-001',
            'tipe'        => 'masuk',
            'supplier_id' => $supplier1->id,
            'tanggal'     => '2026-05-20',
            'keterangan'  => 'Pengiriman rutin bulanan',
            'status'      => 'selesai',
            'total_nilai' => 9750000,
            'user_id'     => $admin->id,
        ]);
        TransaksiItem::create([
            'transaksi_id' => $trx1->id,
            'produk_id'    => Produk::where('sku', 'ST-001-CM')->first()->id,
            'qty'          => 150,
            'harga_satuan' => 65000,
            'subtotal'     => 9750000,
        ]);

        // Transaksi 2 - Keluar
        $trx2 = Transaksi::create([
            'kode'        => 'TRX-OUT-20260519-042',
            'tipe'        => 'keluar',
            'tujuan'      => 'Proyek Bendungan A',
            'alamat'      => 'Jl. Raya Bendungan No. 123, Bogor',
            'tanggal'     => '2026-05-19',
            'keterangan'  => 'Pengiriman ke proyek bendungan',
            'status'      => 'selesai',
            'total_nilai' => 12420000,
            'user_id'     => $admin->id,
        ]);
        TransaksiItem::create([
            'transaksi_id' => $trx2->id,
            'produk_id'    => Produk::where('sku', 'BS-003-10MM')->first()->id,
            'qty'          => 85,
            'harga_satuan' => 95000,
            'subtotal'     => 8075000,
        ]);
        TransaksiItem::create([
            'transaksi_id' => $trx2->id,
            'produk_id'    => Produk::where('sku', 'BS-004-12MM')->first()->id,
            'qty'          => 30,
            'harga_satuan' => 120000,
            'subtotal'     => 3600000,
        ]);

        // Transaksi 3 - Masuk
        $trx3 = Transaksi::create([
            'kode'        => 'TRX-IN-20260519-041',
            'tipe'        => 'masuk',
            'supplier_id' => $supplier2->id,
            'tanggal'     => '2026-05-19',
            'keterangan'  => 'Restok cat interior',
            'status'      => 'selesai',
            'total_nilai' => 4500000,
            'user_id'     => $admin->id,
        ]);
        TransaksiItem::create([
            'transaksi_id' => $trx3->id,
            'produk_id'    => Produk::where('sku', 'CT-002-JTN')->first()->id,
            'qty'          => 20,
            'harga_satuan' => 195000,
            'subtotal'     => 3900000,
        ]);

        // Transaksi 4 - Keluar (Diproses)
        $trx4 = Transaksi::create([
            'kode'        => 'TRX-OUT-20260518-012',
            'tipe'        => 'keluar',
            'tujuan'      => 'Workshop Utama',
            'alamat'      => 'Jl. Workshop Industri Utama Blok B, Jakarta',
            'tanggal'     => '2026-05-18',
            'keterangan'  => 'Kebutuhan workshop mingguan',
            'status'      => 'diproses',
            'total_nilai' => 3200000,
            'user_id'     => $admin->id,
        ]);
        TransaksiItem::create([
            'transaksi_id' => $trx4->id,
            'produk_id'    => Produk::where('sku', 'PK-001-PLU')->first()->id,
            'qty'          => 20,
            'harga_satuan' => 45000,
            'subtotal'     => 900000,
        ]);

        // Transaksi 5 - Masuk
        $trx5 = Transaksi::create([
            'kode'        => 'TRX-IN-20260518-011',
            'tipe'        => 'masuk',
            'supplier_id' => $supplier3->id,
            'tanggal'     => '2026-05-18',
            'keterangan'  => 'Pengiriman semen bulk',
            'status'      => 'selesai',
            'total_nilai' => 11000000,
            'user_id'     => $admin->id,
        ]);
        TransaksiItem::create([
            'transaksi_id' => $trx5->id,
            'produk_id'    => Produk::where('sku', 'SM-003-HC')->first()->id,
            'qty'          => 200,
            'harga_satuan' => 55000,
            'subtotal'     => 11000000,
        ]);
    }
}
