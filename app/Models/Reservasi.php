<?php

// app/Models/Reservasi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'harga',
        'status',
    ];

    // Relasi: Satu reservasi dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu reservasi untuk satu Lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}