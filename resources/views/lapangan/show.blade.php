@extends('layouts.user-layout')

@section('title', $lapangan->nama_lapangan . ' - STAAAYS SPORT')

@section('content')
    <main style="padding-top: 70px;">
        <div class="container py-5">
            {{-- Bagian Detail Lapangan --}}
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="{{ $lapangan->gambar_url }}" alt="Gambar {{ $lapangan->nama_lapangan }}" class="detail-lapangan-img">
                </div>
                <div class="col-lg-5 d-flex flex-column justify-content-center" data-aos="fade-left">
                    <h1 class="display-4 fw-bolder text-white">{{ $lapangan->nama_lapangan }}</h1>
                    <p class="fs-5 text-secondary mb-3">{{ $lapangan->tipe_lapangan ?? 'Tipe Umum' }}</p>
                    <p class="lead mb-4">{{ $lapangan->deskripsi }}</p>
                    <div class="mb-4">
                        <span class="fs-2 fw-bold" style="color: #48BB78;">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</span>
                        <span class="text-secondary">/ jam</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('reservasi.create', $lapangan->id) }}" class="btn-reservasi-sekarang">
                            Reservasi Sekarang
                        </a>
                        <a href="{{ route('lapangan.index') }}" class="btn btn-outline-light btn-kembali">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bagian Ulasan --}}
            <div class="mt-5 pt-5 border-top border-secondary">
                <h2 class="display-5 fw-bold text-white text-center mb-5" data-aos="fade-up">Ulasan Pengguna</h2>
                @if ($ulasans->count() > 0)
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            @foreach ($ulasans as $ulasan)
                                <div class="ulasan-card" data-aos="fade-up">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="ulasan-user mb-0">{{ $ulasan->user->name ?? 'Pengguna Anonim' }}</p>
                                        <div class="rating-stars">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="{{ $i < $ulasan->rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="ulasan-tanggal mb-3">{{ $ulasan->created_at->diffForHumans() }}</p>
                                    <p class="ulasan-komentar mb-0">"{{ $ulasan->komentar }}"</p>
                                </div>
                            @endforeach
                            {{-- Paginasi Ulasan --}}
                            <div class="d-flex justify-content-center mt-4">
                                {{ $ulasans->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="fs-4 text-secondary">Belum ada ulasan untuk lapangan ini. Jadilah yang pertama!</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('styles')
{{-- CSS untuk bintang rating dari Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<style>
    .detail-lapangan-img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.3);
    }
    .btn-reservasi-sekarang {
        background-color: #48BB78; /* Hijau */
        color: white;
        font-weight: 700;
        padding: 0.75rem 2rem;
        border-radius: 9999px;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .btn-reservasi-sekarang:hover {
        background-color: #38a169;
        color: white;
    }
    .btn-kembali {
        padding: 0.75rem 2rem;
        border-radius: 9999px;
        font-weight: 700;
    }

    /* Styling Ulasan */
    .ulasan-card {
        background-color: #2D3748;
        border: 1px solid #4A5568;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .rating-stars {
        color: #facc15; /* Kuning */
    }
    .ulasan-user {
        font-weight: 600;
        color: #FFFFFF;
    }
    .ulasan-tanggal {
        font-size: 0.8rem;
        color: #A0AEC0;
    }
    .ulasan-komentar {
        color: #CBD5E0;
    }

    /* Paginasi (Sama dengan halaman daftar lapangan) */
    .pagination { --bs-pagination-color: #A0AEC0; --bs-pagination-bg: #2D3748; --bs-pagination-border-color: #4A5568; --bs-pagination-hover-color: #FFFFFF; --bs-pagination-hover-bg: #4A5568; --bs-pagination-hover-border-color: #4A5568; --bs-pagination-focus-color: #FFFFFF; --bs-pagination-focus-bg: #4A5568; --bs-pagination-active-color: #FFFFFF; --bs-pagination-active-bg: #667eea; --bs-pagination-active-border-color: #667eea; --bs-pagination-disabled-color: #718096; --bs-pagination-disabled-bg: #2D3748; --bs-pagination-disabled-border-color: #4A5568; }
</style>
@endpush
