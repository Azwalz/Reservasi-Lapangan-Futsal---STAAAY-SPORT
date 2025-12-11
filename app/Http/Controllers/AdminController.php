<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request; // Pastikan Request di-import untuk method yang menggunakannya
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Pastikan ini ada jika Anda menggunakan File::class
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Pastikan ini ada

class AdminController extends Controller
{
    // // Constructor untuk menerapkan middleware (aktifkan jika perlu)
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'admin']);
    // }

    public function dashboard()
    {
        // Inisialisasi variabel dengan nilai default
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

    // === Manajemen Pengguna ===
    public function manageUsers()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'integer', 'in:0,1'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }


    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|integer|in:0,1',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }


    // === Manajemen Lapangan ===
    public function manageFields()
    {
        $lapangans = Lapangan::orderBy('nama_lapangan')->get();
        return view('admin.fields.index', compact('lapangans'));
    }

    public function createField()
    {
        return view('admin.fields.create');
    }

    public function storeField(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255|unique:lapangans,nama_lapangan',
            'deskripsi' => 'nullable|string',
            'harga_per_jam' => 'required|numeric|min:0|max:99999999999.99', // Sesuaikan dengan tipe data DB Anda
            'tipe_lapangan' => 'nullable|string|max:100',
            'gambar_lapangan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dataLapangan = $request->only(['nama_lapangan', 'deskripsi', 'harga_per_jam', 'tipe_lapangan']);
        $fileNameToStore = null;

        if ($request->hasFile('gambar_lapangan')) {
            $file = $request->file('gambar_lapangan');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $cleanFileName = Str::slug($originalFileName);
            $fileNameToStore = $cleanFileName.'_'.time().'.'.$extension;
            $destinationPath = public_path('uploads/lapangan_images');
            $file->move($destinationPath, $fileNameToStore);
            $dataLapangan['gambar_lapangan'] = $fileNameToStore;
        }

        Lapangan::create($dataLapangan);
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan baru berhasil ditambahkan.');
    }

    public function editField(Lapangan $lapangan)
    {
        return view('admin.fields.edit', compact('lapangan'));
    }

    public function updateField(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama_lapangan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lapangans', 'nama_lapangan')->ignore($lapangan->id),
            ],
            'deskripsi' => 'nullable|string',
            'harga_per_jam' => 'required|numeric|min:0|max:99999999999.99', // Sesuaikan
            'tipe_lapangan' => 'nullable|string|max:100',
            'gambar_lapangan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dataLapangan = $request->only(['nama_lapangan', 'deskripsi', 'harga_per_jam', 'tipe_lapangan']);

        if ($request->hasFile('gambar_lapangan')) {
            $destinationPath = public_path('uploads/lapangan_images');
            if ($lapangan->gambar_lapangan && File::exists($destinationPath . '/' . $lapangan->gambar_lapangan)) {
                File::delete($destinationPath . '/' . $lapangan->gambar_lapangan);
            }
            $file = $request->file('gambar_lapangan');
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $cleanFileName = Str::slug($originalFileName);
            $fileNameToStore = $cleanFileName.'_'.time().'.'.$extension;
            $file->move($destinationPath, $fileNameToStore);
            $dataLapangan['gambar_lapangan'] = $fileNameToStore;
        }

        $lapangan->update($dataLapangan);
        return redirect()->route('admin.fields.index')->with('success', 'Data lapangan berhasil diperbarui.');
    }

    public function destroyField(Lapangan $lapangan)
    {
        if ($lapangan->gambar_lapangan) {
            $imagePath = public_path('uploads/lapangan_images/' . $lapangan->gambar_lapangan);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $lapangan->delete();
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus.');
    }


    // === Manajemen Reservasi ===
    public function manageReservations(Request $request) // Tambahkan Request $request
    {
        $query = Reservasi::with(['user', 'lapangan']);

        // Filter berdasarkan Tanggal Booking
        if ($request->filled('filter_tanggal_mulai')) {
            $query->whereDate('tanggal_booking', '>=', $request->filter_tanggal_mulai);
        }
        if ($request->filled('filter_tanggal_selesai')) {
            $query->whereDate('tanggal_booking', '<=', $request->filter_tanggal_selesai);
        }

        // Filter berdasarkan Lapangan
        if ($request->filled('filter_lapangan')) {
            $query->where('lapangan_id', $request->filter_lapangan);
        }

        // Filter berdasarkan Status
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        // Pencarian berdasarkan Nama Pemesan atau ID Reservasi
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
                             ->appends($request->query()); // Penting untuk paginasi dengan filter

        // Ambil data lapangan untuk filter dropdown di view
        $lapanganOptions = Lapangan::orderBy('nama_lapangan')->get(); // <-- BARIS INI DITAMBAHKAN/DIPASTIKAN ADA

        // Kirim $lapanganOptions ke view
        return view('admin.reservations.index', compact('reservasis', 'lapanganOptions'));
    }

    // METHOD UNTUK MENAMPILKAN FORM TAMBAH RESERVASI
    public function createReservation()
    {
        $users = User::where('role', 0)->orderBy('name')->get(); // Ambil user biasa
        $lapangans = Lapangan::orderBy('nama_lapangan')->get(); // Ambil semua lapangan
        return view('admin.reservations.create', compact('users', 'lapangans'));
    }

    // METHOD UNTUK MENYIMPAN RESERVASI BARU
    public function storeReservation(Request $request)
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

        // Validasi Ketersediaan Jadwal
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
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($existingReservations) {
            return back()->withErrors(['jadwal' => 'Jadwal yang dipilih untuk lapangan ini sudah terisi atau tumpang tindih.'])->withInput();
        }

        Reservasi::create($validatedData);
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi baru berhasil dibuat.');
    }

    public function updateReservationStatus(Request $request, Reservasi $reservasi)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'paid', 'completed', 'cancelled'])],
        ]);
        $reservasi->status = $request->status;
        $reservasi->save();
        return redirect()->route('admin.reservations.index')->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function showReservation(Reservasi $reservasi)
    {
        $reservasi->load(['user', 'lapangan']);
        return view('admin.reservations.show', compact('reservasi'));
    }

    public function editReservation(Reservasi $reservasi)
    {
        $users = User::where('role', 0)->orderBy('name')->get();
        $lapangans = Lapangan::orderBy('nama_lapangan')->get();
        $reservasi->load(['user', 'lapangan']);
        return view('admin.reservations.edit', compact('reservasi', 'users', 'lapangans'));
    }

    public function updateReservation(Request $request, Reservasi $reservasi)
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

        // Validasi Ketersediaan Jadwal (PENTING SAAT UPDATE)
        $jamMulaiRequest = Carbon::parse($validatedData['jam_mulai']);
        $jamSelesaiRequest = Carbon::parse($validatedData['jam_selesai']);

        $existingReservations = Reservasi::where('lapangan_id', $validatedData['lapangan_id'])
            ->where('tanggal_booking', $validatedData['tanggal_booking'])
            ->where('id', '!=', $reservasi->id) // Abaikan reservasi yang sedang diedit
            ->where(function ($query) use ($jamMulaiRequest, $jamSelesaiRequest) {
                $query->where(function ($q) use ($jamMulaiRequest, $jamSelesaiRequest) {
                    $q->where('jam_mulai', '<', $jamSelesaiRequest->toTimeString())
                      ->where('jam_selesai', '>', $jamMulaiRequest->toTimeString());
                });
            })
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($existingReservations) {
            return back()->withErrors(['jadwal' => 'Jadwal yang dipilih untuk lapangan ini sudah terisi atau tumpang tindih.'])->withInput();
        }

        $reservasi->update($validatedData);
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function destroyReservation(Reservasi $reservasi)
    {
        $reservasi->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil dihapus.');
    }
}
