@extends('layouts.user-layout')

@section('title', 'Konfirmasi Pembayaran - STAAAYS SPORT')

@section('content')
<main style="padding-top: 70px;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h1 class="display-4 fw-bolder text-white">
                        Konfirmasi Pembayaran
                    </h1>
                    <p class="mt-3 fs-5 text-secondary">
                        Untuk Reservasi #{{ $reservasi->id }}
                    </p>
                </div>

                <div class="card" style="background-color: #2D3748; border-color: #4A5568;" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body p-4 p-md-5">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4 p-3 rounded" style="background-color: #4A5568;">
                            <h5 class="text-white fw-bold">Instruksi Pembayaran</h5>
                            <p class="text-light mb-1">Silakan lakukan transfer sebesar <strong>Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                            <p class="text-white fs-5 fw-bold mb-0">Bank ABC - 123456789 a/n STAAAYS SPORT</p>
                        </div>
                        
                        <form method="POST" action="{{ route('pembayaran.store', $reservasi->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tanggal_pembayaran" class="form-label text-light">Tanggal Pembayaran</label>
                                    <input id="tanggal_pembayaran" class="form-control form-control-dark" type="date" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', date('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="jumlah_pembayaran" class="form-label text-light">Jumlah yang Dibayar</label>
                                    <input id="jumlah_pembayaran" class="form-control form-control-dark" type="number" name="jumlah_pembayaran" value="{{ old('jumlah_pembayaran', $reservasi->harga) }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="metode_pembayaran" class="form-label text-light">Metode Pembayaran</label>
                                    <input id="metode_pembayaran" class="form-control form-control-dark" type="text" name="metode_pembayaran" placeholder="Contoh: Transfer Bank BCA" value="{{ old('metode_pembayaran') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="bukti_pembayaran" class="form-label text-light">Unggah Bukti Pembayaran (JPG, PNG, WEBP, GIF)</label>
                                    <input id="bukti_pembayaran" class="form-control form-control-dark" type="file" name="bukti_pembayaran" required>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-lg btn-success">
                                    Kirim Konfirmasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .form-control-dark {
        background-color: #1A202C;
        border-color: #4A5568;
        color: #CBD5E0;
    }
    .form-control-dark:focus {
        background-color: #1A202C;
        border-color: #667eea;
        color: #CBD5E0;
        box-shadow: none;
    }
</style>
@endpush