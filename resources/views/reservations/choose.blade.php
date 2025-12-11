@extends('layouts.user-layout')

@section('title', 'Pilih Lapangan untuk Reservasi')

@section('content')
<main style="padding-top: 70px;">
    <div class="container py-5">
        <div class="text-center mb-4" data-aos="fade-up">
            <h1 class="display-4 fw-bolder text-white">Pilih Lapangan</h1>
            <p class="mt-3 fs-5 text-secondary">Klik pada gambar lapangan yang Anda inginkan untuk memulai reservasi.</p>
        </div>
        
        {{-- Tombol untuk melihat Riwayat Reservasi --}}
        <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('reservasi.history') }}" class="btn btn-outline-light">Lihat Riwayat Reservasi Saya</a>
        </div>

        @if ($lapangans->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach ($lapangans as $lapangan)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
                        <a href="{{ route('reservasi.create', $lapangan->id) }}" class="pilih-lapangan-link">
                            <div class="pilih-lapangan-card">
                                <img src="{{ $lapangan->gambar_url }}" alt="Gambar {{ $lapangan->nama_lapangan }}">
                                <div class="pilih-lapangan-overlay">
                                    <h3 class="pilih-lapangan-title">{{ $lapangan->nama_lapangan }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
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
    .pilih-lapangan-card {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        cursor: pointer;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        transition: transform 0.3s ease;
        border: 1px solid #4A5568;
    }
    .pilih-lapangan-link:hover .pilih-lapangan-card {
        transform: scale(1.05);
    }
    .pilih-lapangan-link {
        text-decoration: none;
    }
    .pilih-lapangan-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .pilih-lapangan-link:hover .pilih-lapangan-card img {
        transform: scale(1.1);
    }
    .pilih-lapangan-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0));
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
        opacity: 1;
        transition: opacity 0.3s ease;
    }
    .pilih-lapangan-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #FFFFFF;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    }
</style>
@endpush
