@extends('layouts.user-layout')

@section('title', 'Riwayat Reservasi Saya - STAAAYS SPORT')

@section('content')
<main style="padding-top: 70px;">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bolder text-white">Riwayat Reservasi Saya</h1>
            <p class="mt-3 fs-5 text-secondary">Lihat semua riwayat pemesanan lapangan Anda di sini.</p>
        </div>

        {{-- Notifikasi --}}
        @foreach (['success', 'info', 'error'] as $msg)
            @if (session($msg))
                <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }}">{{ session($msg) }}</div>
            @endif
        @endforeach

        <div class="card bg-dark border-secondary" data-aos="fade-up" data-aos-delay="100">
            <div class="card-body p-0">
                @if ($reservasis->count())
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4">ID</th>
                                    <th class="py-3 px-4">Lapangan</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Jam</th>
                                    <th class="py-3 px-4">Harga</th>
                                    <th class="py-3 px-4">Status Reservasi</th>
                                    <th class="py-3 px-4">Status Pembayaran</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservasis as $reservasi)
                                    <tr>
                                        <td class="py-3 px-4">#{{ $reservasi->id }}</td>
                                        <td class="py-3 px-4">{{ $reservasi->lapangan->nama_lapangan ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($reservasi->tanggal_booking)->isoFormat('D MMM YY') }}</td>
                                        <td class="py-3 px-4">
                                            {{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i') }}
                                        </td>
                                        <td class="py-3 px-4">Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                                        
                                        {{-- Status Reservasi --}}
                                        <td class="py-3 px-4">
                                            <span class="status-badge status-{{ strtolower($reservasi->status) }}">
                                                {{ ucfirst($reservasi->status) }}
                                            </span>
                                        </td>

                                        {{-- Status Pembayaran --}}
                                        <td class="py-3 px-4">
                                            @php $pembayaran = $reservasi->pembayaran; @endphp
                                            @switch(true)
                                                @case($reservasi->status === 'pending' && !$pembayaran)
                                                    <span class="status-badge status-menunggu-pembayaran">Lakukan Pembayaran</span>
                                                    @break
                                                @case($pembayaran && $pembayaran->status === 'pending')
                                                    <span class="status-badge status-menunggu-verifikasi">Menunggu Verifikasi</span>
                                                    @break
                                                @case($pembayaran && $pembayaran->status === 'verified')
                                                    <span class="status-badge status-lunas">Lunas</span>
                                                    @break
                                                @case($pembayaran && $pembayaran->status === 'rejected')
                                                    <span class="status-badge status-ditolak">Ditolak</span>
                                                    @break
                                                @default
                                                    <span class="text-secondary small fst-italic">-</span>
                                            @endswitch
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="text-center py-3 px-4">
                                            @if ($reservasi->status === 'pending' && !$pembayaran)
                                                <a href="{{ route('pembayaran.create', $reservasi->id) }}" class="btn btn-sm btn-bayar">Bayar Sekarang</a>
                                            @elseif ($pembayaran && $pembayaran->status === 'rejected')
                                                <a href="{{ route('pembayaran.create', $reservasi->id) }}" class="btn btn-sm btn-bayar-ulang">Unggah Ulang</a>
                                            @elseif ($reservasi->status === 'completed')
                                                @if ($reservasi->ulasan)
                                                    <span class="text-success fst-italic small">Sudah diulas</span>
                                                @else
                                                    <a href="{{ route('ulasan.create', $reservasi->id) }}" class="btn btn-sm btn-ulasan">Beri Ulasan</a>
                                                @endif
                                            @else
                                                <span class="text-secondary small fst-italic">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="fs-4 text-secondary">Anda belum memiliki riwayat reservasi.</p>
                        <a href="{{ route('lapangan.index') }}" class="btn btn-lg btn-success mt-3">Booking Lapangan Sekarang</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Paginasi --}}
        @if ($reservasis->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $reservasis->links() }}
            </div>
        @endif
    </div>
</main>
@endsection

@push('styles')
<style>
    .table-dark th, .table-dark td {
        border-color: #4A5568 !important;
        vertical-align: middle;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 9999px;
        text-transform: capitalize;
    }
    .status-pending { background-color: #FEFCBF; color: #B7791F; }
    .status-confirmed { background-color: #C6F6D5; color: #2F855A; }
    .status-cancelled { background-color: #FED7D7; color: #C53030; }
    .status-completed { background-color: #EBF4FF; color: #4299E1; }
    .status-menunggu-pembayaran { background-color: #FEEBC8; color: #DD6B20; }
    .status-menunggu-verifikasi { background-color: #BEE3F8; color: #3182CE; }
    .status-lunas { background-color: #C6F6D5; color: #2F855A; }
    .status-ditolak { background-color: #FED7D7; color: #C53030; }

    .btn-ulasan,
    .btn-bayar,
    .btn-bayar-ulang {
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
        border: none;
        border-radius: 15rem;
        color: white;
        text-decoration: none;
    }
    .btn-ulasan { background-color: #28a745; }
    .btn-ulasan:hover { background-color: #218838; }
    .btn-bayar { background-color: #667eea; }
    .btn-bayar:hover { background-color: #5a67d8; }
    .btn-bayar-ulang { background-color: #ED8936; }
    .btn-bayar-ulang:hover { background-color: #DD6B20; }

    .pagination {
        --bs-pagination-color: #A0AEC0;
        --bs-pagination-bg: #2D3748;
        --bs-pagination-border-color: #4A5568;
        --bs-pagination-hover-color: #FFFFFF;
        --bs-pagination-hover-bg: #4A5568;
        --bs-pagination-hover-border-color: #4A5568;
        --bs-pagination-focus-color: #FFFFFF;
        --bs-pagination-focus-bg: #4A5568;
        --bs-pagination-active-color: #FFFFFF;
        --bs-pagination-active-bg: #667eea;
        --bs-pagination-active-border-color: #667eea;
        --bs-pagination-disabled-color: #718096;
        --bs-pagination-disabled-bg: #2D3748;
        --bs-pagination-disabled-border-color: #4A5568;
    }
</style>
@endpush
