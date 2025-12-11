<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
    'reservasi_id',
    'tanggal_pembayaran',
    'jumlah_pembayaran', // <-- PASTIKAN INI ADA
    'metode_pembayaran',
    'bukti_pembayaran',  // <-- PASTIKAN INI ADA
    'status',
    'catatan_admin',
    ];

    /**
     * Relasi: Satu pembayaran dimiliki oleh satu Reservasi.
     */
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}
