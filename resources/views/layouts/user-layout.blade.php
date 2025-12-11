<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Judul halaman akan dinamis, dengan fallback ke nama aplikasi --}}
    {{-- Halaman lain akan mendefinisikan ini menggunakan @section('title', 'Judul Halaman') --}}
    <title>@yield('title', 'STAAAYS - SPORT')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    {{-- Memanggil file CSS kustom untuk layout pengguna --}}
    <link rel="stylesheet" href="{{ asset('css/layout/user-layout.css') }}">
    
    {{-- Stack untuk style tambahan dari halaman spesifik --}}
    @stack('styles')
</head>
<body>
    
    <div class="parent-wrapper">
        
        {{-- MEMANGGIL NAVIGASI DARI FILE TERPISAH --}}
        @include('layouts.partials.user-navigation')
        
        {{-- KONTEN UTAMA DARI SETIAP HALAMAN AKAN DILETAKKAN DI SINI --}}
        <main>
            @yield('content')
        </main>
    
        {{-- FOOTER --}}
        <footer class="footer-wrapper pt-5 pb-3">
            @include('layouts.partials.user-footer')
        </footer>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 600,
            offset: 50,
        });
    </script>
    {{-- Stack untuk script tambahan dari halaman spesifik --}}
    @stack('scripts')
</body>
</html>