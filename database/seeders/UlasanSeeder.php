<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ulasan;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Reservasi; // Jika Anda mengaitkan ulasan dengan reservasi

    class UlasanSeeder extends Seeder
    {
        public function run(): void
        {
            $users = User::where('role', 0)->get(); // Ambil user biasa
            $lapangans = Lapangan::all();
            // $reservasis = Reservasi::where('status', 'completed')->get(); // Ambil reservasi yang sudah selesai

            if ($users->isEmpty() || $lapangans->isEmpty()) {
                $this->command->info('Tidak ada user atau lapangan untuk membuat ulasan.');
                return;
            }

            $statuses = ['pending', 'approved', 'rejected'];
            $comments = [
                'Lapangan sangat bagus, bersih, dan terawat dengan baik. Pelayanan juga ramah!',
                'Cukup baik, tapi jaring gawang ada yang bolong sedikit. Overall oke.',
                'Kurang memuaskan, lantainya agak licin. Semoga bisa diperbaiki.',
                'Sangat recommended! Harga sewa sepadan dengan kualitas.',
                'Tempatnya strategis, mudah dijangkau. Akan booking lagi di sini.',
            ];

            for ($i = 0; $i < 15; $i++) { // Buat 15 ulasan contoh
                $user = $users->random();
                $lapangan = $lapangans->random();
                // $reservasi = $reservasis->where('user_id', $user->id)->where('lapangan_id', $lapangan->id)->first();

                Ulasan::create([
                    'user_id' => $user->id,
                    'lapangan_id' => $lapangan->id,
                    // 'reservasi_id' => $reservasi ? $reservasi->id : null, // Jika reservasi ditemukan
                    'rating' => rand(3, 5),
                    'komentar' => $comments[array_rand($comments)] . " (Ulasan untuk " . $lapangan->nama_lapangan . " oleh " . $user->name . ")",
                    'status' => $statuses[array_rand($statuses)],
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
            $this->command->info('Data contoh ulasan berhasil ditambahkan.');
        }
    }
    