<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
{


    /**
     * Menampilkan halaman riwayat reservasi untuk pengguna yang sedang login.
     */
    public function history()
    {
        $user = Auth::user();

        // Ambil semua reservasi milik user, urutkan dari yang terbaru.
        // Eager load relasi 'lapangan' dan 'ulasan' untuk efisiensi.
        $reservasis = Reservasi::where('user_id', $user->id)
                                ->with(['lapangan', 'ulasan'])
                                ->latest('tanggal_booking') // Urutkan berdasarkan tanggal booking
                                ->paginate(10); // Gunakan paginasi jika riwayat banyak

        return view('reservations.history', compact('reservasis'));
    }
}
