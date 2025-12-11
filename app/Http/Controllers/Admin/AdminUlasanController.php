<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class AdminUlasanController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ulasan::with(['user', 'lapangan', 'reservasi'])->latest();

        // Contoh filter berdasarkan status
        if ($request->filled('filter_status') && $request->filter_status !== 'all') {
            $query->where('status', $request->filter_status);
        }

        $ulasans = $query->paginate(15)->appends($request->query());

        return view('admin.ulasan.index', compact('ulasans'));
    }

    // Nanti kita tambahkan method approve, reject, destroy, dll. di sini
    public function updateStatus(Request $request, Ulasan $ulasan)
    {
        $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in(['approved', 'rejected', 'pending'])],
        ]);

        $ulasan->status = $request->status;
        $ulasan->save();

        return redirect()->route('admin.ulasan.index', ['filter_status' => $request->input('previous_status', 'pending')])
                         ->with('success', 'Status ulasan berhasil diperbarui.');
    }

    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();
        return redirect()->route('admin.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
