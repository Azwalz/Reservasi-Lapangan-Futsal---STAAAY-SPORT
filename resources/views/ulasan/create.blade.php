<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beri Ulasan - STAAAYS SPORT</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #0D1235; color: #E2E8F0; }
        .user-navbar { background-color: rgba(26, 32, 44, 0.85); backdrop-filter: blur(10px); padding: 0.5rem 1rem; font-weight: 600; border-bottom: 1px solid #2D3748; }
        .user-navbar .navbar-brand { color: #FFFFFF; font-weight: 700; font-size: 1.5rem; }
        .user-navbar .nav-link { color: #A0AEC0; } .user-navbar .nav-link:hover { color: #FFFFFF; }
        .form-container { background-color: #E9ECEF; padding: 2rem; border-radius: 0.5rem; color: #212529; }
        .form-label { font-weight: 600; }
        .form-control, .form-select { background-color: #FFFFFF; border: 1px solid #CED4DA; }
        .form-control:focus, .form-select:focus { border-color: #80bdff; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
        .btn-kirim { background-color: #1A202C; color: #FFFFFF; font-weight: 600; padding: 0.5rem 1.5rem; border: none; }
        .btn-kirim:hover { background-color: #2D3748; }

        /* Styling Bintang Rating */
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-start; }
        .star-rating input[type="radio"] { display: none; }
        .star-rating label { font-size: 2rem; color: #d1d5db; cursor: pointer; transition: color 0.2s; }
        .star-rating input[type="radio"]:not(:checked) ~ label:hover,
        .star-rating input[type="radio"]:not(:checked) ~ label:hover ~ label { color: #facc15; }
        .star-rating input[type="radio"]:checked ~ label { color: #f59e0b; }
    </style>
</head>
<body>
    {{-- Navigasi --}}
    <nav class="navbar navbar-expand-lg navbar-dark user-navbar sticky-top">
        {{-- Salin kode navigasi lengkap dari halaman lain di sini --}}
    </nav>
    
    <main style="padding-top: 70px;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-container">
                        <h3 class="text-dark fw-bold text-center">Berikan Pengalaman Anda</h3>
                        <p class="text-secondary text-center mb-4">Ulasan Anda untuk lapangan: <strong>{{ $reservasi->lapangan->nama_lapangan }}</strong></p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('ulasan.store', $reservasi->id) }}">
                            @csrf
                            
                            <!-- Rating Bintang -->
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="star-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required/>
                                        <label for="star{{ $i }}" title="{{ $i }} stars">&#9733;</label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Komentar -->
                            <div class="mb-4">
                                <label for="komentar" class="form-label">Ulasan (Opsional)</label>
                                <textarea class="form-control" name="komentar" id="komentar" rows="4" placeholder="Tuliskan ulasan Anda di sini...">{{ old('komentar') }}</textarea>
                                @error('komentar')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-kirim">Kirim Ulasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
