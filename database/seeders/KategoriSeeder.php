<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Semen & Mortar',
            'Besi & Baja',
            'Cat & Pelapis',
            'Kayu & Papan',
            'Atap & Plafon',
            'Lantai & Keramik',
            'Pipa & Sanitasi',
            'Perkakas',
            'Listrik',
            'Alat Pelindung Diri',
        ];

        foreach ($kategoris as $nama) {
            Kategori::create(['nama' => $nama]);
        }
    }
}
