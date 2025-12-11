<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'admin']);
    // }

    public function index() // Method dashboard kita ganti nama jadi index untuk konsistensi
    {
        $reservasiHariIniCount = 0;
        $pendapatanHariIni = 0;
        $penggunaBaruMingguIniCount = 0;
        $reservasiTerbaru = collect();

        if (class_exists(Reservasi::class)) {
            $reservasiHariIniCount = Reservasi::whereDate('tanggal_booking', today())->count();
            $pendapatanHariIni = Reservasi::whereDate('tanggal_booking', today())
                                         ->whereIn('status', ['confirmed', 'paid'])
                                         ->sum('harga');
            $reservasiTerbaru = Reservasi::with(['user', 'lapangan'])
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get();
        }

        if (class_exists(User::class)) {
            $penggunaBaruMingguIniCount = User::where('created_at', '>=', now()->subWeek())->count();
        }

        return view('admin.dashboard', compact(
            'reservasiHariIniCount',
            'pendapatanHariIni',
            'penggunaBaruMingguIniCount',
            'reservasiTerbaru'
        ));
    }
}
