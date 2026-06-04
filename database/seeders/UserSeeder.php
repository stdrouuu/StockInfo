<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'username' => 'admin_utama',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Staff Toko 1',
            'username' => 'staff_toko',
            'password' => Hash::make('staff123'),
            'role'     => 'staff',
        ]);
    }
}
