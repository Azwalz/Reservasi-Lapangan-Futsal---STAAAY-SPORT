<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- ... meta tags, title, fonts ... --}}

        @vite(['resources/css/app.css', 'resources/css/admin-theme.css', 'resources/js/app.js']) {{-- Pastikan admin-theme.css diimpor --}}

        {{-- STACK UNTUK STYLES TAMBAHAN PER HALAMAN --}}
        @stack('styles') {{-- Ini akan diisi oleh @push('styles') dari calendar.blade.php --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 admin-page-content"> {{-- Pastikan class admin-page-content ada jika Anda styling tema gelap dari sini --}}
            
            {{-- Navigasi Anda yang sudah dipindahkan ke body --}}
            {{-- resources/views/layouts/app.blade.php --}}
            <nav class="admin-main-nav">
                @auth
                    <ul class="admin-nav-list">
                        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                        @can('isAdmin')
                            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a></li>
                            <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link">Kelola User</a></li>
                            <li class="nav-item"><a href="{{ route('admin.fields.index') }}" class="nav-link">Kelola Lapangan</a></li>
                            <li class="nav-item"><a href="{{ route('admin.reservations.index') }}" class="nav-link">Kelola Reservasi</a></li>
                            <li class="nav-item"><a href="{{ route('admin.calendar.index') }}" class="nav-link">Kalender Reservasi</a></li>
                            <li class="nav-item"><a href="{{ route('admin.ulasan.index') }}" class="nav-link">Kelola Ulasan</a></li>
                        @elsecan('isUser')
                            {{-- Pastikan rute user.profile ada jika ingin dipakai --}}
                            {{-- <li class="nav-item"><a href="{{ route('user.profile') }}" class="nav-link">Profil Saya</a></li> --}}
                        @endcan
                        <li class="nav-item logout-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="admin-nav-list-guest">
                        <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    </ul>
                @endauth
            </nav>

            {{-- Menghapus @include('layouts.navigation') jika navigasi di atas sudah final --}}
            {{-- Jika layouts.navigation adalah sidebar Breeze, Anda mungkin ingin mempertahankannya atau mengintegrasikannya --}}

            @if (isset($header))
                <header class="admin-page-header"> {{-- Ganti class jika perlu --}}
                    <div class="admin-header-container"> {{-- Ganti class jika perlu --}}
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- STACK UNTUK SCRIPTS TAMBAHAN PER HALAMAN --}}
        @stack('scripts') {{-- Ini akan diisi oleh @push('scripts') dari calendar.blade.php --}}
    </body>
</html>