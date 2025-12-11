{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{-- Kita mungkin perlu styling header ini juga di admin-theme.css --}}
        <h2 class="admin-header-title"> {{-- Contoh class baru --}}
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    {{-- Kita tambahkan class 'admin-page-background' untuk body utama halaman admin --}}
    <div class="py-12 admin-page-content"> {{-- Class baru untuk konten utama --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card"> {{-- Class baru untuk kartu pembungkus utama --}}
                <div class="p-6"> {{-- Padding bisa tetap dari Tailwind atau custom --}}
                    <h3 class="admin-welcome-message"> {{-- Class baru --}}
                        Selamat Datang, Admin {{ Auth::user()->name }}!
                    </h3>

                    {{-- Bagian Statistik Cepat --}}
                    <div class="admin-stats-grid"> {{-- Class baru untuk grid statistik --}}
                        
                        {{-- Kartu 1: Total Reservasi Hari Ini (Contoh dengan class baru) --}}
                        <div class="stat-card">
                            <h4 class="stat-card-title">Reservasi Hari Ini</h4>
                            <p class="stat-card-value text-indigo-400"> {{-- Warna bisa dari Tailwind atau custom --}}
                                {{ $reservasiHariIniCount }}
                            </p>
                        </div>

                        {{-- Kartu 2: Estimasi Pendapatan Hari Ini (Masih menggunakan Tailwind untuk perbandingan, bisa diubah) --}}
                        <div class="bg-gray-700 p-6 rounded-lg shadow"> {{-- Contoh warna gelap Tailwind --}}
                            <h4 class="text-md font-semibold text-gray-200">Estimasi Pendapatan Hari Ini</h4>
                            <p class="text-3xl font-bold text-green-400">
                                Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Kartu 3: Pengguna Baru (Masih menggunakan Tailwind) --}}
                        <div class="bg-gray-700 p-6 rounded-lg shadow">
                            <h4 class="text-md font-semibold text-gray-200">Pengguna Baru (Minggu Ini)</h4>
                            <p class="text-3xl font-bold text-blue-400">
                                {{ $penggunaBaruMingguIniCount }}
                            </p>
                        </div>
                    </div>

                    {{-- Bagian Akses Cepat --}}
                    <div class="mb-8">
                        <h4 class="admin-section-title">Akses Cepat:</h4> {{-- Class baru --}}
                        <div class="admin-quick-links"> {{-- Class baru --}}
                            <a href="{{ route('admin.users.index') }}" class="admin-button button-blue">
                                Kelola Pengguna
                            </a>
                            <a href="{{ route('admin.reservations.index') }}" class="admin-button button-indigo">
                                Semua Reservasi
                            </a>
                            <a href="{{ route('admin.fields.index') }}" class="admin-button button-green">
                                Kelola Lapangan
                            </a>
                            <a href="{{ route('admin.calendar.index') }}" class="admin-button button-purple">
                                Lihat Kalender
                            </a>
                            <a href="{{ route('admin.ulasan.index') }}" class="admin-button button-white">
                                Kelola Ulasan
                            </a>
                        </div>
                    </div>

                    {{-- Bagian Reservasi Terbaru (struktur HTML bisa disederhanakan jika tidak pakai utility class) --}}
                    <div>
                        <h4 class="admin-section-title">Reservasi Terbaru / Akan Datang</h4>
                        @if($reservasiTerbaru->count() > 0)
                            <div class="admin-table-container"> {{-- Class baru --}}
                                <table class="admin-table"> {{-- Class baru --}}
                                    <thead>
                                        <tr>
                                            <th>Pemesan</th>
                                            <th>Lapangan</th>
                                            <th>Tanggal</th>
                                            <th>Jam Mulai</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservasiTerbaru as $reservasi)
                                            <tr>
                                                <td>{{ $reservasi->user->name ?? 'N/A' }}</td>
                                                <td>{{ $reservasi->lapangan->nama_lapangan ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_booking)->isoFormat('D MMM YY') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }}</td>
                                                <td>
                                                    <span class="status-badge status-{{ strtolower($reservasi->status ?? 'unknown') }}">
                                                        {{ ucfirst($reservasi->status ?? 'N/A') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="admin-text-secondary">Belum ada reservasi terbaru.</p> {{-- Class baru --}}
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>