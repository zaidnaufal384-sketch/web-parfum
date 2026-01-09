<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 1 Akun Admin Khusus
        User::factory()->create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('123'), // Passwordnya adalah 'password'
            'role' => 'admin',
        ]);

        // Opsional: Membuat 1 Akun Customer untuk tes
        User::factory()->create([
            'name' => 'Pelanggan Setia',
            'email' => 'user@toko.com',
            'password' => Hash::make('123'),
            'role' => 'customer',
        ]);
    }
}