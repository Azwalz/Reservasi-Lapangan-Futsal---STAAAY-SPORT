<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function chooseLapangan()
    {
        $lapangans = Lapangan::orderBy('nama_lapangan')->get();
        return view('reservations.choose', compact('lapangans'));
    }

    public function create(Lapangan $lapangan)
    {
        return view('reservations.create', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $lapangan = Lapangan::findOrFail($validatedData['lapangan_id']);
        
        $jamMulaiRequest = Carbon::parse($validatedData['jam_mulai']);
        $jamSelesaiRequest = Carbon::parse($validatedData['jam_selesai']);

        // Validasi Jadwal (Tidak diubah)
        $existingReservation = Reservasi::where('lapangan_id', $lapangan->id)
            ->where('tanggal_booking', $validatedData['tanggal_booking'])
            ->where(function ($query) use ($jamMulaiRequest, $jamSelesaiRequest) {
                $query->where(function ($q) use ($jamMulaiRequest, $jamSelesaiRequest) {
                    $q->where('jam_mulai', '<', $jamSelesaiRequest->toTimeString())
                      ->where('jam_selesai', '>', $jamMulaiRequest->toTimeString());
                });
            })
            ->whereNotIn('status', ['cancelled'])
            ->exists();
        if ($existingReservation) {
            return back()->withErrors(['jadwal' => 'Jadwal yang Anda pilih sudah terisi.'])->withInput();
        }

        // ====================================================================
        // == KALKULASI BERSIH KARENA DATABASE SUDAH BENAR ==
        // ====================================================================
        $durasiMenit = abs($jamSelesaiRequest->diffInMinutes($jamMulaiRequest));
        
        // Langsung ambil harga dari DB (sudah berupa angka bersih)
        // Kita ubah ke float untuk memastikan tipe datanya angka
        $hargaPerJam = (float) $lapangan->harga_per_jam;

        // Lakukan kalkulasi
        $totalHarga = ($durasiMenit / 60) * $hargaPerJam;
        // ====================================================================
        
        $reservasi = Reservasi::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $lapangan->id,
            'tanggal_booking' => $validatedData['tanggal_booking'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'harga' => $totalHarga,
            'status' => 'pending',
        ]);

        return redirect()->route('reservasi.success', $reservasi->id)
                         ->with('success', 'Reservasi Anda telah berhasil dibuat!');
    }

    public function success(Reservasi $reservasi)
    {
        if ($reservasi->user_id !== Auth::id()) {
            abort(403);
        }
        $reservasi->load('lapangan');
        return view('reservations.success', compact('reservasi'));
    }

    public function history()
    {
        $user = Auth::user();
        $reservasis = Reservasi::where('user_id', $user->id)
                                 ->with(['lapangan', 'ulasan', 'pembayaran'])
                                 ->latest('tanggal_booking')
                                 ->paginate(10);
        return view('reservations.history', compact('reservasis'));
    }
}