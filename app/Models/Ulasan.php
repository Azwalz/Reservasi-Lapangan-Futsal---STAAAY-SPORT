<?php

// app/Models/Ulasan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'lapangan_id', 'reservasi_id', 'rating', 'komentar', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}



    // Di dalam app/Models/Reservasi.php
   
