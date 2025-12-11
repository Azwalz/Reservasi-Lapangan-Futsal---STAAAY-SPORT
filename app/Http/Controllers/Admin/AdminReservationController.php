<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'admin']);
    // }

    public function index(Request $request) // manageReservations menjadi index
    {
        $query = Reservasi::with(['user', 'lapangan', 'pembayaran']); 

        if ($request->filled('filter_tanggal_mulai')) {
            $query->whereDate('tanggal_booking', '>=', $request->filter_tanggal_mulai);
        }
        if ($request->filled('filter_tanggal_selesai')) {
            $query->whereDate('tanggal_booking', '<=', $request->filter_tanggal_selesai);
        }
        if ($request->filled('filter_lapangan')) {
            $query->where('lapangan_id', $request->filter_lapangan);
        }
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }
        if ($request->filled('search_term')) {
            $searchTerm = $request->search_term;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $reservasis = $query->orderBy('tanggal_booking', 'desc')
                             ->orderBy('jam_mulai', 'desc')
                             ->paginate(15)
                             ->appends($request->query());

        $lapanganOptions = Lapangan::orderBy('nama_lapangan')->get();
        return view('admin.reservations.index', compact('reservasis', 'lapanganOptions'));
    }

    public function create() // createReservation menjadi create
    {
        $users = User::where('role', 0)->orderBy('name')->get();
        $lapangans = Lapangan::orderBy('nama_lapangan')->get();
        return view('admin.reservations.create', compact('users', 'lapangans'));
    }

    public function store(Request $request) // storeReservation menjadi store
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'harga' => 'required|numeric|min:0',
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'paid', 'completed', 'cancelled'])],
        ]);

        $jamMulaiRequest = Carbon::parse($validatedData['jam_mulai']);
        $jamSelesaiRequest = Carbon::parse($validatedData['jam_selesai']);
        $existingReservations = Reservasi::where('lapangan_id', $validatedData['lapangan_id'])
            ->where('tanggal_booking', $validatedData['tanggal_booking'])
            ->where(function ($query) use ($jamMulaiRequest, $jamSelesaiRequest) {
                $query->where(function ($q) use ($jamMulaiRequest, $jamSelesaiRequest) {
                    $q->where('jam_mulai', '<', $jamSelesaiRequest->toTimeString())
                      ->where('jam_selesai', '>', $jamMulaiRequest->toTimeString());
                });
            })
            ->whereNotIn('status', ['cancelled'])->exists();

        if ($existingReservations) {
            return back()->withErrors(['jadwal' => 'Jadwal yang dipilih untuk lapangan ini sudah terisi atau tumpang tindih.'])->withInput();
        }

        Reservasi::create($validatedData);
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi baru berhasil dibuat.');
    }

    public function show(Reservasi $reservasi) // showReservation menjadi show
    {
        $reservasi->load(['user', 'lapangan']);
        return view('admin.reservations.show', compact('reservasi'));
    }

    public function edit(Reservasi $reservasi) // editReservation menjadi edit
    {
        $users = User::where('role', 0)->orderBy('name')->get();
        $lapangans = Lapangan::orderBy('nama_lapangan')->get();
        $reservasi->load(['user', 'lapangan']);
        return view('admin.reservations.edit', compact('reservasi', 'users', 'lapangans'));
    }

    public function update(Request $request, Reservasi $reservasi) // updateReservation menjadi update
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'harga' => 'required|numeric|min:0',
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'paid', 'completed', 'cancelled'])],
        ]);

        $jamMulaiRequest = Carbon::parse($validatedData['jam_mulai']);
        $jamSelesaiRequest = Carbon::parse($validatedData['jam_selesai']);
        $existingReservations = Reservasi::where('lapangan_id', $validatedData['lapangan_id'])
            ->where('tanggal_booking', $validatedData['tanggal_booking'])
            ->where('id', '!=', $reservasi->id)
            ->where(function ($query) use ($jamMulaiRequest, $jamSelesaiRequest) {
                $query->where(function ($q) use ($jamMulaiRequest, $jamSelesaiRequest) {
                    $q->where('jam_mulai', '<', $jamSelesaiRequest->toTimeString())
                      ->where('jam_selesai', '>', $jamMulaiRequest->toTimeString());
                });
            })
            ->whereNotIn('status', ['cancelled'])->exists();

        if ($existingReservations) {
            return back()->withErrors(['jadwal' => 'Jadwal yang dipilih untuk lapangan ini sudah terisi atau tumpang tindih.'])->withInput();
        }

        $reservasi->update($validatedData);
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function destroy(Reservasi $reservasi) // destroyReservation menjadi destroy
    {
        $reservasi->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil dihapus.');
    }

    // Method updateStatus bisa tetap di sini atau dipindah, atau diintegrasikan ke method update utama.
    // Untuk saat ini, saya biarkan di sini.
    public function updateStatus(Request $request, Reservasi $reservasi) // updateReservationStatus menjadi updateStatus
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'paid', 'completed', 'cancelled'])],
        ]);
        $reservasi->status = $request->status;
        $reservasi->save();
        return redirect()->route('admin.reservations.index')->with('success', 'Status reservasi berhasil diperbarui.');
    }
}
