<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->foreignId('lapangan_id')->constrained()->onDelete('cascade'); // Relasi ke tabel lapangans
            $table->date('tanggal_booking');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('harga', 10, 2); // Harga total untuk reservasi ini
            $table->string('status')->default('pending'); // Misal: pending, confirmed, paid, cancelled, completed
            // Tambahkan kolom lain jika perlu (misal: catatan dari user)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
