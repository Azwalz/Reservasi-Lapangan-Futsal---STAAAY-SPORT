<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservasi Berhasil - Lanjutkan Pembayaran - STAAAYS SPORT</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #0D1235; color: #E2E8F0; }
        .user-navbar { background-color: rgba(26, 32, 44, 0.85); backdrop-filter: blur(10px); padding: 0.5rem 1rem; font-weight: 600; border-bottom: 1px solid #2D3748; }
        .user-navbar .navbar-brand { color: #FFFFFF; font-weight: 700; font-size: 1.5rem; }
        .user-navbar .nav-link { color: #A0AEC0; } .user-navbar .nav-link:hover { color: #FFFFFF; }
        .success-box { background-color: #1A202C; padding: 2.5rem; border-radius: 0.5rem; border: 1px solid #4A5568; }
        .btn-custom {
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            border-radius: 0.25rem;
            transition: opacity 0.2s;
        }
        .btn-custom:hover {
            opacity: 0.85;
            color: white;
        }
        .sponsor-panel { background-color: #F8F9FA; padding: 2rem; border-radius: 0.5rem; }
        .sponsor-panel img { max-width: 80px; margin: 1rem; filter: grayscale(100%); transition: filter 0.3s; }
        .sponsor-panel img:hover { filter: grayscale(0%); }

        /* --- AWAL PERUBAHAN: Menambah style baru untuk instruksi dan tombol pembayaran --- */
        .instruction-box {
            background-color: #2D3748;
            border-left: 5px solid #667eea; /* Warna aksen ungu/biru */
            padding: 1.5rem;
            border-radius: 0.25rem;
        }
        .btn-pembayaran { background-color: #28a745; } /* Hijau, warna aksi utama */
        .link-secondary-custom { color: #A0AEC0; }
        .link-secondary-custom:hover { color: #FFFFFF; }
        /* --- AKHIR PERUBAHAN --- */
    </style>
</head>
<body>
    <main style="padding-top: 90px;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="text-white text-center fw-bolder mb-5">Status Reservasi Anda</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="success-box text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h3 class="text-white fw-bold mb-2">Reservasi Anda Telah Diterima!</h3>
                        <p class="text-secondary mb-4">Tinggal satu langkah terakhir untuk mengamankan jadwal Anda.</p>
                        
                        <div class="instruction-box text-start mb-4">
                            <h5 class="text-white fw-bold">Lakukan Pembayaran</h5>
                            <p class="text-light mb-1">
                                Transfer sejumlah total harga pesanan Anda:
                            </p>
                            <p class="display-6 fw-bolder text-white mb-3">
                                Rp {{ number_format($reservasi->harga, 0, ',', '.') }}
                            </p>
                            <hr style="border-color: #4A5568;">
                            <p class="text-light mb-1">Ke rekening berikut:</p>
                            <p class="fw-bold text-white fs-5 mb-0">Bank ABC - 123456789</p>
                            <p class="text-light">a/n STAAAYS SPORT</p>
                        </div>

                        <p class="text-secondary mb-3">Setelah melakukan transfer, segera lakukan konfirmasi.</p>

                        <div class="d-grid gap-2">
                             <a href="{{ route('pembayaran.create', $reservasi->id) }}" class="btn btn-custom btn-pembayaran btn-lg">Konfirmasi Pembayaran</a>
                        </div>
                       
                        <div class="mt-4">
                            <a href="{{ route('reservasi.history') }}" class="link-secondary-custom">Bayar Nanti (lewat Riwayat Reservasi)</a>
                        </div>
                    </div>
                    </div>
                <div class="col-lg-5">
                    <div class="sponsor-panel h-100 d-flex flex-column align-items-center justify-content-center">
                         <h4 class="text-dark fw-bold mb-4">Dipercaya oleh Mitra Ternama</h4>
                         <div class="d-flex flex-wrap justify-content-center align-items-center">
                             {{-- Tambahkan logo sponsor Anda di sini --}}
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>