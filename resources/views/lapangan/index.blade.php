@extends('layouts.user-layout')

@section('title', 'Daftar Lapangan - STAAAYS SPORT')

@section('content')
    <main style="padding-top: 70px;">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h1 class="display-4 fw-bolder text-white">
                    Pilih Lapangan Favoritmu
                </h1>
                <p class="mt-3 fs-5 text-secondary">
                    Temukan lapangan terbaik untuk pertandingan seru bersama teman-temanmu.
                </p>
            </div>

            @if ($lapangans->count() > 0)
                <div class="row g-4">
                    @foreach ($lapangans as $lapangan)
                        <div class="col-sm-6 col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                            {{-- Kartu Lapangan --}}
                            <div class="lapangan-card w-100">
                                <a href="{{ route('lapangan.show', $lapangan->id) }}">
                                    <img class="lapangan-card-img" src="{{ $lapangan->gambar_url }}" alt="Gambar {{ $lapangan->nama_lapangan }}">
                                    <div class="lapangan-card-body">
                                        <div>
                                            <h2 class="lapangan-card-title">{{ $lapangan->nama_lapangan }}</h2>
                                            <p class="lapangan-card-type">{{ $lapangan->tipe_lapangan ?? 'Tipe Umum' }}</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                                            <p class="lapangan-card-price mb-0">
                                                Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}<span>/jam</span>
                                            </p>
                                            <span class="lapangan-card-button">
                                                Lihat Detail
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Link Paginasi --}}
                <div class="d-flex justify-content-center mt-5">
                    {{ $lapangans->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="fs-4 text-secondary">Saat ini belum ada lapangan yang tersedia.</p>
                </div>
            @endif
        </div>
    </main>
@endsection

@push('styles')
<style>
    /* Kartu Lapangan */
    .lapangan-card {
        background-color: #2D3748;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border: 1px solid #4A5568;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .lapangan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }
    .lapangan-card a {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .lapangan-card-img {
        width: 100%;
        height: 14rem;
        object-fit: cover;
        object-position: center;
    }
    .lapangan-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .lapangan-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 0.5rem;
    }
    .lapangan-card-type {
        font-size: 0.875rem;
        color: #A0AEC0;
        margin-bottom: 0.75rem;
    }
    .lapangan-card-footer {
        margin-top: auto;
    }
    .lapangan-card-price {
        font-size: 1.125rem;
        font-weight: 600;
        color: #48BB78;
    }
    .lapangan-card-price span {
        font-size: 0.875rem;
        font-weight: 400;
        color: #A0AEC0;
    }
    .lapangan-card-button {
        display: inline-block;
        background-color: #667eea;
        color: #FFFFFF;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        border-radius: 9999px;
        text-transform: uppercase;
    }

    /* Paginasi */
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
