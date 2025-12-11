@extends('layouts.user-layout')

@section('title', 'Ulasan Pengguna - STAAAYS SPORT')

@section('content')
<main style="padding-top: 70px;">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bolder text-white">
                Ulasan Pengguna
            </h1>
            <p class="mt-3 fs-5 text-secondary">
                Lihat apa kata mereka tentang lapangan kami.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                @if ($ulasans->count() > 0)
                    @foreach ($ulasans as $ulasan)
                        <div class="ulasan-card" data-aos="fade-up">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <p class="ulasan-user mb-0">{{ $ulasan->user->name ?? 'Pengguna Anonim' }}</p>
                                    <p class="ulasan-lapangan mb-0">Mengulas: <strong>{{ $ulasan->lapangan->nama_lapangan ?? 'Lapangan' }}</strong></p>
                                </div>
                                <div class="rating-stars text-nowrap">
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
                @else
                    <div class="text-center py-5">
                        <div class="ulasan-container">
                            <h4 class="text-dark">Yah...</h4>
                            <p class="text-secondary">Saat ini masih belum ada ulasan yang disetujui.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
{{-- CSS untuk bintang rating dari Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<style>
    .ulasan-container { background-color: #E9ECEF; padding: 2rem; border-radius: 0.5rem; }
    .ulasan-card {
        background-color: #2D3748;
        color: #E2E8F0;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        border: 1px solid #4A5568;
    }
    .rating-stars { color: #facc15; }
    .ulasan-user { font-weight: 700; font-size: 1.1rem; color: #FFFFFF; }
    .ulasan-lapangan { font-weight: 500; font-size: 0.9rem; color: #A0AEC0; }
    .ulasan-tanggal { font-size: 0.8rem; color: #A0AEC0; }
    .ulasan-komentar { color: #CBD5E0; font-style: italic; }
    .pagination { --bs-pagination-color: #A0AEC0; --bs-pagination-bg: #2D3748; --bs-pagination-border-color: #4A5568; --bs-pagination-hover-color: #FFFFFF; --bs-pagination-hover-bg: #4A5568; --bs-pagination-hover-border-color: #4A5568; --bs-pagination-focus-color: #FFFFFF; --bs-pagination-focus-bg: #4A5568; --bs-pagination-active-color: #FFFFFF; --bs-pagination-active-bg: #667eea; --bs-pagination-active-border-color: #667eea; --bs-pagination-disabled-color: #718096; --bs-pagination-disabled-bg: #2D3748; --bs-pagination-disabled-border-color: #4A5568; }
</style>
@endpush
