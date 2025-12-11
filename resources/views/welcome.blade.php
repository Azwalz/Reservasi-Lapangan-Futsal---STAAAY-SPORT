<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>STAAAYS - SPORT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/earlyaccess/nicomoji.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    {{-- WELCOME SCREEN --}}
    <div id="welcome" class="welcome-screen position-fixed w-100 h-100">
        <div class="position-absolute welcome-dia-3">
            <img class="floating" src="{{asset('assets/landing/dia-3.png')}}" alt="Decorative Element 3">
        </div>
        <div class="position-absolute welcome-dia-4">
            <img class="floating-2" src="{{asset('assets/landing/dia-4.png')}}" alt="Decorative Element 4">
        </div>
        <div class="position-absolute welcome-dia-5">
            <img class="floating-3" src="{{asset('assets/landing/dia-5.png')}}" alt="Decorative Element 5">
        </div>
        <div class="welcome-content w-100 position-absolute text-center">
            <img class="mb-5 h-100" src="{{asset('assets/landing/logo.svg')}}" alt="STAAAYS Logo">
            <div class="d-flex mx-auto welcome-text-divider">
                <h5 class="th-2 tc-2 text-center mb-5"><span>Reservasi Sekarang Juga</span></h5>
            </div>
            <button id="welcome-btn" class="btn btn-int px-5 shadow rounded-pill">Selengkapnya</button>
        </div>
    </div>

    <div class="parent-container" style="display: none;">
        
        {{-- NAVBAR --}}
        <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tujuan">Tujuan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#galeri">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#lokasi">Lokasi</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a href="{{ route('register') }}" class="btn btn-int me-2">Register</a>
                        <a href="{{ route('login') }}" class="btn btn-int">Login</a>
                    </div>
                </div>
            </div>
        </nav>
        
        {{-- HEADER SECTION --}}
        <header id="header" class="mb-3">
            <div class="container-fluid position-relative overflow-hidden">
                <div class="row min-vh-100 justify-content-center align-items-center">
                    <div class="col-lg order-2 order-lg-1">
                        <img class="w-100 header-text-img" src="{{asset('assets/landing/header-text.png')}}" alt="Header Text" data-aos="fade-up" data-aos-delay="400">
                        <p class="header-description" data-aos="fade-up" data-aos-delay="100">
                            Cuma satu klik, kamu bisa langsung <br> booking lapangan terbaik di kotamu, <br> Real-time info, no ribet, langsung main!
                        </p>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 mb-2 mb-lg-0">
                        <img class="header-bg-img" src="{{asset('assets/landing/header-bg-1.png')}}" alt="Header Background" data-aos="fade-left" data-aos-delay="400">
                    </div>
                </div>
            </div>
        </header>
    
        {{-- TUJUAN SECTION --}}
        <section id="tujuan">
            <div class="container-fluid">
                <h1 class="display-1 th-1 tc-1 text-end my-5" data-aos="fade-up"><span>Tujuan</span></h1>
    
                <div class="row mg-1">
                    <div class="col-lg position-relative d-flex justify-content-center align-items-center mb-5" data-aos="fade-up" data-aos-delay="100">
                        <img class="w-75" src="{{asset('assets/landing/t-1.png')}}" alt="Tujuan Image 1">
                    </div>
                    <div class="col-lg position-relative d-flex justify-content-center align-items-center mb-5" data-aos="fade-up" data-aos-delay="200">
                        <img class="w-75" src="{{asset('assets/landing/t-2.png')}}" alt="Tujuan Image 2">
                        <img class="w-75 position-absolute tujuan-img-2" src="{{asset('assets/landing/t-2.png')}}" alt="Tujuan Image 2">
                    </div>
                    <div class="col-lg position-relative d-flex justify-content-center align-items-center mb-5" data-aos="fade-up" data-aos-delay="300">
                        <img class="w-75" src="{{asset('assets/landing/t-3.png')}}" alt="Tujuan Image 3">
                    </div>
                </div>
            </div>
        </section>
    
        {{-- GALERI SECTION --}}
        <section id="galeri">
            <div class="container-fluid position-relative">
                <h1 class="display-1 th-1 tc-1 text-end my-5" data-aos="fade-up"><span>Galeri</span></h1>
    
                <div id="svg-parent">
                    <div class="svg-container position-absolute svg-layer-1">
                        <svg preserveAspectRatio="none" viewBox="0 0 1440 462" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M-44 346.498C27.774 411.999 205.691 517.52 343.166 415.598C515.009 288.195 508.798 -24.9123 846.274 89.534C1183.75 203.98 1467.4 279.558 1544 1" stroke-width="7" class="gl-1"></path>
                        </svg>
                    </div>
                    <div class="svg-container position-absolute svg-layer-2">
                        <svg preserveAspectRatio="none" viewBox="0 0 1440 421" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M-104 287.929C47.4534 359.789 397.036 478.548 583.736 378.7C817.112 253.889 862.548 49.6547 1089.73 83.6938C1316.91 117.733 1370.61 167.657 1478 2" stroke-width="7" class="gl-2"></path>
                        </svg>
                    </div>
                </div>
                    
                <div class="row g-5 mg-1">
                    <div class="col-lg">
                        <img class="w-100 rounded" src="{{asset('assets/landing/g-1.png')}}" alt="Gallery Image 1" data-aos="fade-up" data-aos-delay="100">
                    </div>
                    <div class="col-lg d-flex justify-content-between">
                        <div class="vstack gap-5">
                            <img class="w-100 h-100 rounded" src="{{asset('assets/landing/g-2.png')}}" alt="Gallery Image 2" data-aos="fade-up" data-aos-delay="200">
                            <img class="w-100 h-100 rounded" src="{{asset('assets/landing/g-3.png')}}" alt="Gallery Image 3" data-aos="fade-up" data-aos-delay="300" data-aos-offset="0">
                        </div>
                    </div>
                    <div class="col-lg">
                        <img class="w-100 rounded" src="{{asset('assets/landing/g-1.png')}}" alt="Gallery Image 4" data-aos="fade-up" data-aos-delay="400">
                    </div>
                </div>
            </div>
        </section>

        {{-- TUJUAN SECTION --}}
        <section id="lokasi">
            <div class="container-fluid">
                <h1 class="display-1 th-1 tc-1 text-end my-5" data-aos="fade-up"><span>Lokasi</span></h1>
    
                <div class="row mg-1">
                </div>
            </div>
        </section>
        
{{-- FOOTER --}}
        <footer class="footer-wrapper pt-5 pb-3">
            @include('layouts.partials.user-footer')
        </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>