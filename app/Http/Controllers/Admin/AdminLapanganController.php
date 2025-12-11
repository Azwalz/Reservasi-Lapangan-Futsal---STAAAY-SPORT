<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Storage; // Jika tidak dipakai lagi untuk gambar

class AdminLapanganController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'admin']);
    // }

    public function index() // manageFields menjadi index
    {
        $lapangans = Lapangan::orderBy('nama_lapangan')->get();
        return view('admin.fields.index', compact('lapangans'));
    }

    public function create() // createField menjadi create
    {
        return view('admin.fields.create');
    }

    public function store(Request $request) // storeField menjadi store
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255|unique:lapangans,nama_lapangan',
            'deskripsi' => 'nullable|string',
            'harga_per_jam' => 'required|numeric|min:0|max:99999999999.99',
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

    public function edit(Lapangan $lapangan) // editField menjadi edit
    {
        return view('admin.fields.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan) // updateField menjadi update
    {
        $request->validate([
            'nama_lapangan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lapangans', 'nama_lapangan')->ignore($lapangan->id),
            ],
            'deskripsi' => 'nullable|string',
            'harga_per_jam' => 'required|numeric|min:0|max:99999999999.99',
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

    public function destroy(Lapangan $lapangan) // destroyField menjadi destroy
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
}
