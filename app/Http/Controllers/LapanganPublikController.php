<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganPublikController extends Controller
{
    /**
     * Menampilkan halaman daftar semua lapangan.
     */
    public function index()
    {
        $lapangans = Lapangan::orderBy('nama_lapangan')->paginate(9);
        return view('lapangan.index', compact('lapangans'));
    }

    /**
     * Menampilkan halaman detail untuk satu lapangan.
     */
    public function show(Lapangan $lapangan) // Menggunakan Route Model Binding
    {
        // Ambil ulasan yang sudah disetujui ('approved') untuk lapangan ini
        // Eager load data user yang memberi ulasan, dan urutkan dari yang terbaru
        $ulasans = $lapangan->ulasans()
                           ->where('status', 'approved')
                           ->with('user')
                           ->latest() // Mengurutkan berdasarkan created_at (terbaru dulu)
                           ->paginate(5, ['*'], 'ulasan_page'); // Paginasi untuk ulasan jika banyak

        return view('lapangan.show', compact('lapangan', 'ulasans'));
    }
}
