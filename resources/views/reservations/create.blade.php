@extends('layouts.user-layout')

@section('title', 'Formulir Reservasi - ' . $lapangan->nama_lapangan)

@section('content')
<main style="padding-top: 2rem;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h2 class="text-white fw-bolder mb-3">Formulir Reservasi</h2>
                <p class="text-secondary mb-5">Anda memesan lapangan: <strong class="text-white">{{ $lapangan->nama_lapangan }}</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/landing/logo.svg') }}" alt="Logo" style="height: 50px;">
                    </div>
                    <h5 class="text-dark text-center fw-bold mb-3">Detail Pemesanan Anda</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservasi.store') }}">
                        @csrf
                        <input type="hidden" name="lapangan_id" id="lapangan_id" value="{{ $lapangan->id }}">
                        <input type="hidden" id="harga_per_jam" value="{{ $lapangan->harga_per_jam }}">

                        <div class="mb-3">
                            <label class="form-label">Pemesan</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_booking" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" value="{{ old('tanggal_booking', date('Y-m-d')) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="harga" class="form-label">Total Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required readonly placeholder="Akan terisi otomatis">
                            <div class="form-text form-text-hint">Total harga akan dihitung otomatis.</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-reservasi">Reservasi Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
            <div class="sponsor-panel h-100 d-flex flex-column align-items-center justify-content-center">
                <h4 class="text-dark fw-bold mb-4">Dipercaya oleh Mitra Ternama</h4>
                <div class="mitra-logos">
                    <img src="{{ asset('img/sponsors/Logo-Resmi_Unpak.png') }}" alt="Universitas Pakuan" class="mitra-logo-img">
                    <img src="{{ asset('img/sponsors/milo.webp') }}" alt="Milo" class="mitra-logo-img">
                    <img src="{{ asset('img/sponsors/unilever.png') }}" alt="Unilever" class="mitra-logo-img">
                    <img src="{{ asset('img/sponsors/adidas.webp') }}" alt="Adidas" class="mitra-logo-img">
                </div>
            </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .form-container { background-color: #E9ECEF; padding: 2rem; border-radius: 0.5rem; color: #212529; }
    .form-label { font-weight: 600; }
    .form-control, .form-select { background-color: #FFFFFF; border: 1px solid #CED4DA; }
    .form-control:focus, .form-select:focus { border-color: #80bdff; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
    .btn-reservasi { background-color: #1A202C; color: #FFFFFF; font-weight: 600; padding: 0.75rem 1.5rem; border: none; }
    .btn-reservasi:hover { background-color: #2D3748; }
    .form-text-hint { font-size: 0.8rem; color: #6C757D; }
    /* .sponsor-panel { background-color: #F8F9FA; padding: 2rem; border-radius: 0.5rem; }
    .sponsor-panel img { max-width: 80px; margin: 1rem; filter: grayscale(100%); transition: filter 0.3s; }
    .sponsor-panel img:hover { filter: grayscale(0%); } */
    
    .sponsor-panel { 
        background-color: #F8F9FA; 
        padding: 2rem; 
        border-radius: 0.5rem; 
    }

    /* CSS BARU UNTUK MERAPIKAN LOGO */
    .mitra-logos {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 2.5rem; /* Memberi jarak antar logo */
    }

    .mitra-logo-img {
        max-height: 45px;
        max-width: 100px;
        opacity: 0.9; /* Sedikit transparan agar lebih menarik saat di-hover */
        transition: all 0.3s ease-in-out;
    }

    .mitra-logo-img:hover {
        opacity: 1; /* Kembali ke warna penuh */
        transform: scale(1.1); /* Efek membesar tetap ada */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hargaPerJamInput = document.getElementById('harga_per_jam');
        const jamMulaiInput = document.getElementById('jam_mulai');
        const jamSelesaiInput = document.getElementById('jam_selesai');
        const hargaInput = document.getElementById('harga');

        function calculatePrice() {
            if (!hargaPerJamInput || !jamMulaiInput || !jamSelesaiInput || !hargaInput) return;
            const hargaPerJam = parseFloat(hargaPerJamInput.value) || 0;
            const jamMulai = jamMulaiInput.value;
            const jamSelesai = jamSelesaiInput.value;
            if (hargaPerJam > 0 && jamMulai && jamSelesai) {
                try {
                    const [mulaiH, mulaiM] = jamMulai.split(':').map(Number);
                    const [selesaiH, selesaiM] = jamSelesai.split(':').map(Number);
                    let waktuMulai = new Date(2000, 0, 1, mulaiH, mulaiM, 0);
                    let waktuSelesai = new Date(2000, 0, 1, selesaiH, selesaiM, 0);
                    if (waktuSelesai <= waktuMulai) { // Menangani durasi melewati tengah malam
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
                }
            }
        }
        jamMulaiInput.addEventListener('change', calculatePrice);
        jamSelesaiInput.addEventListener('change', calculatePrice);
    });
</script>
@endpush
