<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanPublikController extends Controller
{
    /**
     * Menampilkan halaman daftar semua ulasan yang sudah disetujui.
     */
    public function index()
    {
        // Ambil semua ulasan yang statusnya 'approved'
        // Eager load relasi 'user' dan 'lapangan' untuk efisiensi
        // Urutkan dari yang terbaru dan gunakan paginasi
        $ulasans = Ulasan::where('status', 'approved')
                         ->with(['user', 'lapangan'])
                         ->latest()
                         ->paginate(10);

        return view('ulasan.index', compact('ulasans'));
    }
}
