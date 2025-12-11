<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{


    /**
     * Menampilkan form untuk membuat ulasan baru untuk reservasi tertentu.
     */
    public function create(Reservasi $reservasi)
    {
        // Validasi 1: Pastikan user yang login adalah pemilik reservasi ini
        if ($reservasi->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Validasi 2: Pastikan reservasi sudah selesai (completed)
        if ($reservasi->status !== 'completed') {
            return redirect()->route('reservasi.history')->with('error', 'Anda hanya bisa memberi ulasan untuk reservasi yang sudah selesai.');
        }

        // Validasi 3: Cek apakah user sudah pernah memberi ulasan untuk reservasi ini
        $existingUlasan = Ulasan::where('reservasi_id', $reservasi->id)->exists();

        if ($existingUlasan) {
            return redirect()->route('reservasi.history')->with('info', 'Anda sudah pernah memberi ulasan untuk reservasi ini.');
        }

        // Muat relasi lapangan untuk ditampilkan di view
        $reservasi->load('lapangan');

        return view('ulasan.create', compact('reservasi'));
    }

    /**
     * Menyimpan ulasan baru ke database.
     */
    public function store(Request $request, Reservasi $reservasi)
    {
        // Lakukan validasi yang sama seperti di method create
        if ($reservasi->user_id !== Auth::id()) {
            abort(403);
        }
        if ($reservasi->status !== 'completed') {
            return redirect()->route('reservasi.history')->with('error', 'Hanya bisa memberi ulasan untuk reservasi yang sudah selesai.');
        }
        $existingUlasan = Ulasan::where('reservasi_id', $reservasi->id)->exists();
        if ($existingUlasan) {
            return redirect()->route('reservasi.history')->with('info', 'Ulasan sudah pernah diberikan.');
        }

        $validatedData = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ]);

        Ulasan::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $reservasi->lapangan_id,
            'reservasi_id' => $reservasi->id,
            'rating' => $validatedData['rating'],
            'komentar' => $validatedData['komentar'],
            'status' => 'pending', // Status awal adalah pending, menunggu moderasi admin
        ]);

        return redirect()->route('reservasi.history')->with('success', 'Terima kasih! Ulasan Anda telah dikirim dan akan dimoderasi oleh admin.');
    }
}
