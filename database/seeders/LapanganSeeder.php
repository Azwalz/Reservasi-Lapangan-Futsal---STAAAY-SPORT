<?php

// database/seeders/LapanganSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lapangan;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        Lapangan::create([
            'nama_lapangan' => 'Lapangan Futsal A (Sintetis)',
            'deskripsi' => 'Lapangan dengan rumput sintetis kualitas terbaik.',
            'harga_per_jam' => 150000.00,
            'tipe_lapangan' => 'Sintetis',
        ]);

        Lapangan::create([
            'nama_lapangan' => 'Lapangan Futsal B (Vinyl)',
            'deskripsi' => 'Lapangan vinyl standar internasional.',
            'harga_per_jam' => 120000.00,
            'tipe_lapangan' => 'Vinyl',
        ]);
    }
}