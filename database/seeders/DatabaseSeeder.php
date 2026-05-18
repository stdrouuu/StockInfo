<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * Urutan penting! Seeder dijalankan sesuai dependensi tabel.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            SupplierSeeder::class,
            ProdukSeeder::class,
            TransaksiSeeder::class,
            ProsesSeeder::class,
            StokOpnameSeeder::class,
        ]);
    }
}
