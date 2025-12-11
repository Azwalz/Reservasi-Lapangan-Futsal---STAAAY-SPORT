<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lapangan');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_per_jam', 10, 2); // Contoh harga per jam
            $table->string('tipe_lapangan')->nullable(); // Misal: sintetis, vinyl
            $table->string('gambar_lapangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};