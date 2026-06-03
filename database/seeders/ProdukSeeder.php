<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kategori IDs
        $semenMortar = Kategori::where('nama', 'Semen & Mortar')->first()->id;
        $besiBaja = Kategori::where('nama', 'Besi & Baja')->first()->id;
        $catPelapis = Kategori::where('nama', 'Cat & Pelapis')->first()->id;
        $kayuPapan = Kategori::where('nama', 'Kayu & Papan')->first()->id;
        $atapPlafon = Kategori::where('nama', 'Atap & Plafon')->first()->id;
        $pipaSanitasi = Kategori::where('nama', 'Pipa & Sanitasi')->first()->id;
        $perkakas = Kategori::where('nama', 'Perkakas')->first()->id;
        $listrik = Kategori::where('nama', 'Listrik')->first()->id;

        $produks = [
            // Semen & Mortar
            [
                'sku' => 'ST-001-CM',
                'nama' => 'Semen Tiga Roda 50kg',
                'kategori_id' => $semenMortar,
                'stok' => 850,
                'harga' => 65000,
                'stok_minimum' => 100,
                'gambar' => 'produk/sementr50.jpg',
            ],
            [
                'sku' => 'SM-002-MP',
                'nama' => 'Semen Merah Putih 50kg',
                'kategori_id' => $semenMortar,
                'stok' => 620,
                'harga' => 62000,
                'stok_minimum' => 80,
                'gambar' => 'produk/semen.jpg',
            ],
            [
                'sku' => 'SM-003-HC',
                'nama' => 'Semen Holcim 40kg',
                'kategori_id' => $semenMortar,
                'stok' => 200,
                'harga' => 55000,
                'stok_minimum' => 50,
                'gambar' => 'produk/semen.jpg',
            ],

            // Besi & Baja
            [
                'sku' => 'BS-002-8MM',
                'nama' => 'Besi Beton 8mm SNI',
                'kategori_id' => $besiBaja,
                'stok' => 15,
                'harga' => 45000,
                'stok_minimum' => 50,
                'gambar' => 'produk/besi.jpg',
            ],
            [
                'sku' => 'BS-003-10MM',
                'nama' => 'Besi Beton Polos 10mm (12m)',
                'kategori_id' => $besiBaja,
                'stok' => 500,
                'harga' => 95000,
                'stok_minimum' => 100,
                'gambar' => 'produk/besi.jpg',
            ],
            [
                'sku' => 'BS-004-12MM',
                'nama' => 'Besi Beton 12mm SNI',
                'kategori_id' => $besiBaja,
                'stok' => 320,
                'harga' => 120000,
                'stok_minimum' => 80,
                'gambar' => 'produk/besi.jpg',
            ],
            [
                'sku' => 'BS-005-WM',
                'nama' => 'Wiremesh M8 2.1x5.4m',
                'kategori_id' => $besiBaja,
                'stok' => 45,
                'harga' => 350000,
                'stok_minimum' => 20,
                'gambar' => 'produk/besi.jpg',
            ],

            // Cat & Pelapis
            [
                'sku' => 'CT-001-DLX',
                'nama' => 'Cat Dulux Weathershield 5kg',
                'kategori_id' => $catPelapis,
                'stok' => 180,
                'harga' => 285000,
                'stok_minimum' => 30,
                'gambar' => 'produk/cat.jpg',
            ],
            [
                'sku' => 'CT-002-JTN',
                'nama' => 'Cat Jotun Jotashield 2.5L',
                'kategori_id' => $catPelapis,
                'stok' => 95,
                'harga' => 195000,
                'stok_minimum' => 25,
                'gambar' => 'produk/cat.jpg',
            ],

            // Kayu & Papan
            [
                'sku' => 'KY-001-MLT',
                'nama' => 'Multiplek 18mm 122x244cm',
                'kategori_id' => $kayuPapan,
                'stok' => 75,
                'harga' => 320000,
                'stok_minimum' => 20,
                'gambar' => 'produk/kayu.jpg',
            ],

            // Atap & Plafon
            [
                'sku' => 'AT-001-SPD',
                'nama' => 'Atap Spandek 0.3mm 6m',
                'kategori_id' => $atapPlafon,
                'stok' => 120,
                'harga' => 85000,
                'stok_minimum' => 30,
                'gambar' => 'produk/atap.jpg',
            ],

            // Pipa & Sanitasi
            [
                'sku' => 'PP-001-PVC',
                'nama' => 'Pipa PVC 4 inch Rucika 4m',
                'kategori_id' => $pipaSanitasi,
                'stok' => 200,
                'harga' => 78000,
                'stok_minimum' => 40,
                'gambar' => 'produk/pipa.jpg',
            ],

            // Perkakas
            [
                'sku' => 'PK-001-PLU',
                'nama' => 'Palu Konde 500gr',
                'kategori_id' => $perkakas,
                'stok' => 60,
                'harga' => 45000,
                'stok_minimum' => 15,
                'gambar' => 'produk/perkakas.jpg',
            ],

            // Listrik
            [
                'sku' => 'LS-001-KBL',
                'nama' => 'Kabel NYM 2x2.5mm 50m',
                'kategori_id' => $listrik,
                'stok' => 40,
                'harga' => 425000,
                'stok_minimum' => 10,
                'gambar' => 'produk/listrik.jpg',
            ],
            [
                'sku' => 'LS-002-LMP',
                'nama' => 'Lampu LED Philips 12W',
                'kategori_id' => $listrik,
                'stok' => 150,
                'harga' => 45000,
                'stok_minimum' => 20,
                'gambar' => 'produk/lampu.jpg',
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}
