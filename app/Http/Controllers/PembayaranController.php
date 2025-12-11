<?php

namespace App\Http\Controllers; // <-- NAMESPACE UNTUK PENGGUNA (TANPA \Admin)

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function create(Reservasi $reservasi)
    {
        if (auth()->id() !== $reservasi->user_id) {
            abort(403, 'AKSES DITOLAK');
        }
        if ($reservasi->pembayaran && in_array($reservasi->pembayaran->status, ['pending', 'verified'])) {
            return redirect()->route('reservasi.history')->with('info', 'Anda sudah mengunggah bukti pembayaran untuk reservasi ini.');
        }
        return view('pembayaran.create', compact('reservasi'));
    }

    public function store(Request $request, Reservasi $reservasi)
    {
        if (auth()->id() !== $reservasi->user_id) {
            abort(403, 'AKSES DITOLAK');
        }
        
        $validated = $request->validate([
            'tanggal_pembayaran' => 'required|date|before_or_equal:today',
            'jumlah_pembayaran' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string|max:255',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $destinationPath = public_path('aset/bukti_pembayaran');

            if ($reservasi->pembayaran && $reservasi->pembayaran->bukti_pembayaran && File::exists($destinationPath . '/' . $reservasi->pembayaran->bukti_pembayaran)) {
                File::delete($destinationPath . '/' . $reservasi->pembayaran->bukti_pembayaran);
            }

            $file = $request->file('bukti_pembayaran');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $cleanFileName = Str::slug('reservasi-'.$reservasi->id.'-'.time());
            $fileNameToStore = $cleanFileName.'.'.$extension;
            $file->move($destinationPath, $fileNameToStore);
            $validated['bukti_pembayaran'] = $fileNameToStore;
        }

        $reservasi->pembayaran()->updateOrCreate(
            ['reservasi_id' => $reservasi->id],
            $validated + ['status' => 'pending']
        );

        return redirect()->route('reservasi.history')->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi.');
    }
}