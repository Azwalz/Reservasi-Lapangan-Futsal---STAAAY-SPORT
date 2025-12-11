<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Edit Reservasi #') }}{{ $reservasi->id }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="admin-card-padding">
                    {{-- Menampilkan notifikasi error validasi jadwal jika ada --}}
                    @if ($errors->has('jadwal'))
                        <div class="admin-alert alert-danger">
                            {{ $errors->first('jadwal') }}
                        </div>
                    @endif
                    {{-- Menampilkan error validasi umum lainnya --}}
                    @if ($errors->any() && !$errors->has('jadwal') ) {{-- Hanya tampilkan jika bukan error jadwal (agar tidak dobel) --}}
                        <div class="admin-alert alert-danger">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.reservations.update', $reservasi->id) }}">
                        @csrf
                        @method('PUT') {{-- Method untuk update --}}

                        <div class="mb-4">
                            <label for="user_id" class="admin-label">{{ __('Pemesan') }}</label>
                            <select name="user_id" id="user_id" required class="admin-select mt-1 block w-full">
                                <option value="">-- Pilih Pengguna --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $reservasi->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="lapangan_id" class="admin-label">{{ __('Lapangan') }}</label>
                            <select name="lapangan_id" id="lapangan_id" required class="admin-select mt-1 block w-full">
                                <option value="">-- Pilih Lapangan --</option>
                                @foreach ($lapangans as $lapangan_option) {{-- Ganti nama variabel agar tidak konflik --}}
                                    <option value="{{ $lapangan_option->id }}" {{ old('lapangan_id', $reservasi->lapangan_id) == $lapangan_option->id ? 'selected' : '' }} data-harga="{{ $lapangan_option->harga_per_jam }}">
                                        {{ $lapangan_option->nama_lapangan }} (Rp {{ number_format($lapangan_option->harga_per_jam, 0, ',', '.') }}/jam)
                                    </option>
                                @endforeach
                            </select>
                            @error('lapangan_id')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_booking" class="admin-label">{{ __('Tanggal Booking') }}</label>
                            <input type="date" name="tanggal_booking" id="tanggal_booking" value="{{ old('tanggal_booking', $reservasi->tanggal_booking) }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('tanggal_booking')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jam_mulai" class="admin-label">{{ __('Jam Mulai') }}</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $reservasi->jam_mulai) }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('jam_mulai')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jam_selesai" class="admin-label">{{ __('Jam Selesai') }}</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', $reservasi->jam_selesai) }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('jam_selesai')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="harga" class="admin-label">{{ __('Total Harga (Rp)') }}</label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', $reservasi->harga) }}" required min="0" step="1000"
                                   class="admin-input mt-1 block w-full" placeholder="Akan terisi otomatis atau isi manual">
                            @error('harga')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                             <p class="text-xs admin-text-secondary mt-1">Harga bisa dihitung otomatis jika lapangan dan jam dipilih, atau isi manual.</p>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="admin-label">{{ __('Status Reservasi') }}</label>
                            <select name="status" id="status" required class="admin-select mt-1 block w-full">
                                <option value="pending" {{ old('status', $reservasi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $reservasi->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="paid" {{ old('status', $reservasi->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="completed" {{ old('status', $reservasi->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $reservasi->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.reservations.show', $reservasi->id) }}" class="admin-link-secondary mr-4">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="admin-button button-indigo">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Script sederhana untuk auto-calculate harga (sama seperti di create.blade.php) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lapanganSelect = document.getElementById('lapangan_id');
            const jamMulaiInput = document.getElementById('jam_mulai');
            const jamSelesaiInput = document.getElementById('jam_selesai');
            const hargaInput = document.getElementById('harga');

            function calculatePrice() {
                const selectedLapanganOption = lapanganSelect.options[lapanganSelect.selectedIndex];
                const hargaPerJam = parseFloat(selectedLapanganOption.dataset.harga) || 0;
                const jamMulai = jamMulaiInput.value;
                const jamSelesai = jamSelesaiInput.value;

                if (hargaPerJam > 0 && jamMulai && jamSelesai) {
                    try {
                        const [mulaiH, mulaiM] = jamMulai.split(':').map(Number);
                        const [selesaiH, selesaiM] = jamSelesai.split(':').map(Number);

                        let waktuMulai = new Date(2000, 0, 1, mulaiH, mulaiM, 0);
                        let waktuSelesai = new Date(2000, 0, 1, selesaiH, selesaiM, 0);

                        if (waktuSelesai <= waktuMulai) { // Jika jam selesai sama atau lebih awal, anggap hari berikutnya
                            waktuSelesai.setDate(waktuSelesai.getDate() + 1);
                        }

                        const durasiMs = waktuSelesai - waktuMulai;
                        const durasiJam = durasiMs / (1000 * 60 * 60);
                        
                        if (durasiJam > 0) {
                            hargaInput.value = Math.round(hargaPerJam * durasiJam);
                        } else {
                            hargaInput.value = '';
                        }
                    } catch (e) {
                        hargaInput.value = '';
                        console.error("Error parsing time for price calculation:", e);
                    }
                }
            }

            if(lapanganSelect) lapanganSelect.addEventListener('change', calculatePrice);
            if(jamMulaiInput) jamMulaiInput.addEventListener('change', calculatePrice);
            if(jamSelesaiInput) jamSelesaiInput.addEventListener('change', calculatePrice);
            
            // Tidak perlu memanggil calculatePrice() saat load karena nilai sudah dari $reservasi->harga
        });
    </script>
</x-app-layout>
