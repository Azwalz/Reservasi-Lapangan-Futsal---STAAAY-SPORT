<?php

namespace App\Http\Controllers\Admin; // <-- PERHATIKAN NAMESPACE INI SUDAH BENAR

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Method untuk admin mengubah status pembayaran (verifikasi atau tolak).
     */
    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan_admin' => 'nullable|string|required_if:status,rejected',
        ]);

        try {
            DB::transaction(function () use ($request, $pembayaran) {
                // Update status pembayaran
                $pembayaran->status = $request->status;
                $pembayaran->catatan_admin = $request->catatan_admin;
                $pembayaran->save();

                // Jika pembayaran diverifikasi, update juga status reservasi menjadi 'confirmed'
                if ($request->status === 'verified') {
                    $reservasi = $pembayaran->reservasi;
                    $reservasi->status = 'confirmed';
                    $reservasi->save();
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status pembayaran: ' . $e->getMessage());
        }

        return redirect()->route('admin.reservations.show', $pembayaran->reservasi_id)
                         ->with('success', 'Status pembayaran telah berhasil diperbarui.');
    }
}