<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Bisa di-uncomment jika Anda pakai fitur verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Bisa juga implement MustVerifyEmail jika perlu
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> // Diperbarui dari list<string> ke array<int, string> agar lebih umum
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- TAMBAHKAN INI
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string> // Diperbarui
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Seorang user bisa memiliki banyak reservasi.
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }

    // Di dalam class User
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }

    
}