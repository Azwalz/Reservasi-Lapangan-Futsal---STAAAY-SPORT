<nav class="navbar navbar-expand-lg navbar-dark user-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            {{-- Logo Brand --}}
    <img src="{{ asset('assets/landing/logo.svg') }}" alt="" style="height: 60px;">staaays
</a>
        <div class="collapse navbar-collapse" id="userNavbar">
            @auth
            {{-- Navigasi untuk pengguna yang sudah login --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lapangan.index') ? 'active' : '' }}" href="{{ route('lapangan.index') }}">Lapangan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reservasi.*') ? 'active' : '' }}" href="{{ route('reservasi.choose') }}">Reservasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ulasan.index') ? 'active' : '' }}" href="{{ route('ulasan.index') }}">Ulasan</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="nav-link logout-button">Logout</button>
                    </form>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>
