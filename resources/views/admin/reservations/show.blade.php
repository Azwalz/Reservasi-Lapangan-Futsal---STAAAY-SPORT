<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Detail Reservasi #') }}{{ $reservasi->id }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="admin-card-padding">
                    <div class="mb-6">
                        <a href="{{ route('admin.reservations.index') }}" class="admin-button button-gray">&larr; Kembali ke Daftar Reservasi</a>
                    </div>

                    {{-- Notifikasi Sukses/Error --}}
                    @if(session('success'))
                        <div class="admin-alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="admin-alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="admin-section-title mb-4">Informasi Pemesan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 admin-detail-grid">
                        <div>
                            <strong class="admin-detail-label">Nama Pemesan:</strong>
                            <span class="admin-detail-value">{{ $reservasi->user->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Email Pemesan:</strong>
                            <span class="admin-detail-value">{{ $reservasi->user->email ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <hr class="admin-divider my-6">

                    <h3 class="admin-section-title mb-4">Informasi Lapangan & Jadwal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 admin-detail-grid">
                        <div>
                            <strong class="admin-detail-label">Nama Lapangan:</strong>
                            <span class="admin-detail-value">{{ $reservasi->lapangan->nama_lapangan ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Tipe Lapangan:</strong>
                            <span class="admin-detail-value">{{ $reservasi->lapangan->tipe_lapangan ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Tanggal Booking:</strong>
                            <span class="admin-detail-value">{{ \Carbon\Carbon::parse($reservasi->tanggal_booking)->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Jam:</strong>
                            <span class="admin-detail-value">{{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i') }}</span>
                        </div>
                    </div>

                    <hr class="admin-divider my-6">

                    <h3 class="admin-section-title mb-4">Informasi Finansial & Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 admin-detail-grid">
                        <div>
                            <strong class="admin-detail-label">Total Harga:</strong>
                            <span class="admin-detail-value font-semibold text-lg">Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Status Reservasi:</strong>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $reservasi->status ?? 'unknown')) }} text-base">
                                {{ ucfirst($reservasi->status ?? 'N/A') }}
                            </span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Dibuat Pada:</strong>
                            <span class="admin-detail-value">{{ $reservasi->created_at->isoFormat('D MMM YY, HH:mm:ss') }}</span>
                        </div>
                        <div>
                            <strong class="admin-detail-label">Diperbarui Pada:</strong>
                            <span class="admin-detail-value">{{ $reservasi->updated_at->isoFormat('D MMM YY, HH:mm:ss') }}</span>
                        </div>
                    </div>

                    @if ($reservasi->pembayaran)
                        <div class="bg-gray-800 rounded-lg p-6 mt-6">
                            <h3 class="admin-section-title mb-4 border-b border-gray-700 pb-3">Verifikasi Pembayaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                {{-- KOLOM KIRI: DETAIL & AKSI --}}
                                <div>
                                    <div class="admin-detail-grid">
                                        <div>
                                            <strong class="admin-detail-label">Tgl. Bayar Pengguna:</strong>
                                            <span class="admin-detail-value">{{ \Carbon\Carbon::parse($reservasi->pembayaran->tanggal_pembayaran)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                        <div>
                                            <strong class="admin-detail-label">Jumlah Dibayar:</strong>
                                            <span class="admin-detail-value">Rp {{ number_format($reservasi->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span>
                                        </div>
                                        <div>
                                            <strong class="admin-detail-label">Metode:</strong>
                                            <span class="admin-detail-value">{{ $reservasi->pembayaran->metode_pembayaran }}</span>
                                        </div>
                                        <div>
                                            <strong class="admin-detail-label">Status Pembayaran:</strong>
                                            <span class="status-badge status-payment-{{ $reservasi->pembayaran->status }}">
                                                {{ ucfirst($reservasi->pembayaran->status) }}
                                            </span>
                                        </div>
                                        @if($reservasi->pembayaran->status == 'rejected' && $reservasi->pembayaran->catatan_admin)
                                            <div>
                                                <strong class="admin-detail-label text-red-400">Alasan Ditolak:</strong>
                                                <span class="admin-detail-value text-red-400">{{ $reservasi->pembayaran->catatan_admin }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($reservasi->pembayaran->status == 'pending')
                                        <hr class="admin-divider my-4">
                                        <div class="flex flex-wrap gap-3">
                                            <form action="{{ route('admin.pembayaran.updateStatus', $reservasi->pembayaran->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="admin-button button-green">Verifikasi Pembayaran</button>
                                            </form>
                                            <form action="{{ route('admin.pembayaran.updateStatus', $reservasi->pembayaran->id) }}" method="POST" class="flex-grow">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <div class="flex">
                                                    <input type="text" name="catatan_admin" class="admin-input rounded-r-none" placeholder="Alasan Penolakan" required>
                                                    <button type="submit" class="admin-button button-danger rounded-l-none">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                {{-- KOLOM KANAN: BUKTI GAMBAR --}}
                                <div>
                                    <strong class="admin-detail-label mb-2 block">Bukti Pembayaran:</strong>
                                    <a href="{{ asset('aset/bukti_pembayaran/' . $reservasi->pembayaran->bukti_pembayaran) }}" target="_blank">
                                        <img src="{{ asset('aset/bukti_pembayaran/' . $reservasi->pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" ... >
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-800 rounded-lg p-6 mt-6 text-center">
                            <p class="admin-text-secondary">Pengguna belum mengunggah bukti pembayaran untuk reservasi ini.</p>
                        </div>
                    @endif
                    <div class="mt-8 border-t admin-divider pt-6">
                        <h4 class="admin-section-title mb-3">Ubah Status Reservasi (Manual):</h4>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $possibleStatuses = ['pending', 'confirmed', 'paid', 'cancelled', 'completed'];
                            @endphp
                            @foreach($possibleStatuses as $status)
                                @if($reservasi->status !== $status)
                                <form action="{{ route('admin.reservations.updateStatus', $reservasi->id) }}" method="POST" class="admin-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit" class="admin-action-button button-{{ strtolower($status) }}" title="Ubah status menjadi {{ ucfirst($status) }}">
                                        Jadikan {{ ucfirst($status) }}
                                    </button>
                                </form>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 border-t admin-divider pt-6">
                        <h4 class="admin-section-title mb-3">Aksi Lain:</h4>
                        <form action="{{ route('admin.reservations.destroy', $reservasi->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus reservasi ID: {{ $reservasi->id }}? Tindakan ini tidak bisa dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-button button-danger">
                                Hapus Reservasi Ini
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>