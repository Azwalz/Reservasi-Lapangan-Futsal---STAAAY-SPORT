<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User Admin (Pastikan email ini belum ada jika Anda sudah punya admin)
        // Atau Anda bisa mengupdate admin yang sudah ada di sini
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Ganti password
                'role' => 1, // 1 untuk admin
                'email_verified_at' => now(),
            ]
        );

        // User Biasa
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'), // Ganti password
                'role' => 0, // 0 untuk user biasa
                'email_verified_at' => now(),
            ]
        );
    }
}
