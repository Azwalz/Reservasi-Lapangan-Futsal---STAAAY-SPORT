<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Storage; // Tidak lagi wajib untuk accessor ini

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lapangan',
        'deskripsi',
        'harga_per_jam',
        'tipe_lapangan',
        'gambar_lapangan',
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }

    public function getGambarUrlAttribute(): ?string
    {
        if ($this->gambar_lapangan) {
            // Path relatif terhadap folder public
            $path = 'uploads/lapangan_images/' . $this->gambar_lapangan;
            // Cek apakah file fisiknya ada di folder public/uploads/lapangan_images
            if (file_exists(public_path($path))) {
                return asset($path); // Membuat URL lengkap ke file di public
            }
        }

        // Gambar placeholder tetap di public/images
        return asset('images/placeholder_lapangan.png');
    }


    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}