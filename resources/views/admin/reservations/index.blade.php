<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Kelola Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="admin-card-padding">
                    <div class="admin-card-header">
                        <h3 class="admin-section-title">
                            Daftar Semua Reservasi
                        </h3>
                        <a href="{{ route('admin.reservations.create') }}" class="admin-button button-green">
                            + Buat Reservasi Baru
                        </a> 
                    </div>
                    {{-- FORM FILTER DAN PENCARIAN --}}
                    <form method="GET" action="{{ route('admin.reservations.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                            <div>
                                <label for="filter_tanggal_mulai" class="admin-label">Dari Tanggal:</label>
                                <input type="date" name="filter_tanggal_mulai" id="filter_tanggal_mulai" value="{{ request('filter_tanggal_mulai') }}" class="admin-input">
                            </div>
                            <div>
                                <label for="filter_tanggal_selesai" class="admin-label">Sampai Tanggal:</label>
                                <input type="date" name="filter_tanggal_selesai" id="filter_tanggal_selesai" value="{{ request('filter_tanggal_selesai') }}" class="admin-input">
                            </div>
                            <div>
                                <label for="filter_lapangan" class="admin-label">Lapangan:</label>
                                <select name="filter_lapangan" id="filter_lapangan" class="admin-select">
                                    <option value="">Semua Lapangan</option>
                                    @foreach ($lapanganOptions as $lapangan)
                                        <option value="{{ $lapangan->id }}" {{ request('filter_lapangan') == $lapangan->id ? 'selected' : '' }}>
                                            {{ $lapangan->nama_lapangan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filter_status" class="admin-label">Status Reservasi:</label>
                                <select name="filter_status" id="filter_status" class="admin-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('filter_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('filter_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="paid" {{ request('filter_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="completed" {{ request('filter_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('filter_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="filter_pembayaran" class="admin-label">Status Pembayaran:</label>
                                <select name="filter_pembayaran" id="filter_pembayaran" class="admin-select">
                                    <option value="">Semua</option>
                                    <option value="menunggu_verifikasi" {{ request('filter_pembayaran') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="lunas" {{ request('filter_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="ditolak" {{ request('filter_pembayaran') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="belum_bayar" {{ request('filter_pembayaran') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                                </select>
                            </div>
                            <div class="lg:col-span-4">
                                <label for="search_term" class="admin-label">Cari Pemesan/ID Reservasi:</label>
                                <input type="text" name="search_term" id="search_term" value="{{ request('search_term') }}" class="admin-input" placeholder="Nama pemesan atau ID Reservasi">
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="admin-button button-blue w-full">Filter/Cari</button>
                                @if(request()->hasAny(['filter_tanggal_mulai', 'filter_tanggal_selesai', 'filter_lapangan', 'filter_status', 'search_term', 'filter_pembayaran']))
                                    <a href="{{ route('admin.reservations.index') }}" class="admin-button button-gray w-full">Reset</a>
                                @endif
                            </div>
                        </div>
                    </form>
                    {{-- AKHIR FORM FILTER --}}

                    @if(session('success'))
                        <div class="admin-alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="admin-alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($reservasis->count() > 0)
                        <div class="admin-table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pemesan</th>
                                        <th>Lapangan</th>
                                        <th>Tanggal Booking</th>
                                        <th>Jam</th>
                                        <th>Harga</th>
                                        <th>Status Reservasi</th>
                                        <th>Status Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservasis as $reservasi)
                                        <tr>
                                            <td>{{ $reservasi->id }}</td>
                                            <td>{{ $reservasi->user->name ?? 'N/A' }}</td>
                                            <td>{{ $reservasi->lapangan->nama_lapangan ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_booking)->isoFormat('D MMM YY') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i') }}</td>
                                            <td>Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $reservasi->status ?? 'unknown')) }}">
                                                    {{ ucfirst($reservasi->status ?? 'N/A') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($reservasi->pembayaran)
                                                    @if ($reservasi->pembayaran->status == 'pending')
                                                        <span class="status-badge status-payment-pending">Menunggu Verifikasi</span>
                                                    @elseif ($reservasi->pembayaran->status == 'verified')
                                                        <span class="status-badge status-payment-verified">Lunas</span>
                                                    @elseif ($reservasi->pembayaran->status == 'rejected')
                                                        <span class="status-badge status-payment-rejected">Ditolak</span>
                                                    @endif
                                                @else
                                                     <span class="status-badge status-payment-none">Belum Bayar</span>
                                                @endif
                                            </td>
                                            <td class="admin-table-actions">
                                                {{-- ... (Semua form aksi Anda yang sudah ada tetap di sini) ... --}}
                                                <a href="{{ route('admin.reservations.show', $reservasi->id) }}" class="admin-action-link link-view">Lihat</a>
                                                <a href="{{ route('admin.reservations.edit', $reservasi->id) }}" class="admin-action-link link-edit" title="Edit Reservasi">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="admin-pagination-links">
                            {{ $reservasis->links() }}
                        </div>
                    @else
                        <p class="admin-text-secondary">Belum ada data reservasi yang cocok dengan filter.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('styles')
<style>
    .status-payment-pending {
        background-color: #f6ad55; /* Orange */
        color: #000;
    }
    .status-payment-verified {
        background-color: #48bb78; /* Green */
        color: #fff;
    }
    .status-payment-rejected {
        background-color: #f56565; /* Red */
        color: #fff;
    }
    .status-payment-none {
        background-color: #a0aec0; /* Gray */
        color: #fff;
    }
</style>
@endpush