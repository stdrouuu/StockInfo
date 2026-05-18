<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'nama'          => 'PT. Semen Merah Putih',
                'kontak_person' => 'Budi Santoso',
                'telepon'       => '+62 811-2222-3333',
                'email'         => 'budi@semenmerahputih.co.id',
                'alamat'        => 'Jl. Sudirman No. 12, Jakarta',
            ],
            [
                'nama'          => 'CV. Baja Utama',
                'kontak_person' => 'Siti Aminah',
                'telepon'       => '+62 812-4444-5555',
                'email'         => 'siti@bajautama.com',
                'alamat'        => 'Kawasan Industri Jababeka, Cikarang',
            ],
            [
                'nama'          => 'Distributor Cat Jotun',
                'kontak_person' => 'Andi Wijaya',
                'telepon'       => '+62 813-6666-7777',
                'email'         => 'andi@jotun.co.id',
                'alamat'        => 'Jl. Gatot Subroto Kav. 45, Jakarta',
            ],
            [
                'nama'          => 'PT. Holcim Indonesia',
                'kontak_person' => 'Rudi Hartono',
                'telepon'       => '+62 814-8888-9999',
                'email'         => 'rudi@holcim.co.id',
                'alamat'        => 'Jl. Jend. Sudirman No. 77, Jakarta Selatan',
            ],
            [
                'nama'          => 'PT. Krakatau Steel',
                'kontak_person' => 'Dewi Lestari',
                'telepon'       => '+62 815-1111-2222',
                'email'         => 'dewi@krakatausteel.com',
                'alamat'        => 'Jl. Industri No. 5, Cilegon, Banten',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
