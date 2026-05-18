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
            'email'    => 'admin@stockinfo.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Staff Gudang',
            'email'    => 'staff@stockinfo.com',
            'password' => Hash::make('staff123'),
            'role'     => 'staff',
        ]);
    }
}
