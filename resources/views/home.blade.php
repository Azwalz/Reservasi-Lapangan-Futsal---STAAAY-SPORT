@extends('layouts.user-layout')
@section('title', 'Dashboard - STAAAYS SPORT')
@section('content')

    {{-- HEADER --}}
    <header id="header" class="mb-5">
        <div class="container position-relative overflow-hidden py-5">
            <div class="row min-vh-75 justify-content-center align-items-center">
                <div class="col-lg order-2 order-lg-1">
                    <img class="w-100" src="{{asset('assets/landing/header-text.png')}}" alt="Reservasi Lapangan Futsal" data-aos="fade-up" data-aos-delay="400" style="max-width: 500px; height: auto;">
                    <p class="mt-3 fs-5" data-aos="fade-up" data-aos-delay="100">
                        Cuma satu klik, kamu bisa langsung <br> booking lapangan terbaik di kotamu, <br> Real-time info, no ribet, langsung main!
                    </p>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 mb-4 mb-lg-0 text-center">
                    <img src="{{asset('assets/landing/header-bg-1.png')}}" alt="Pemain Futsal" data-aos-delay="400" class="floating" style="max-width: 90%; height: auto;">
                </div>
            </div>
        </div>
    </header>

    {{-- KONTEN DASHBOARD PENGGUNA --}}
    <section id="konten-utama" class="py-5">
        <div class="container">
            <h2 class="h1 th-1 text-center my-5 text-white" data-aos="fade-up"><span>Dashboard Pengguna</span></h2>
            <div class="text-center">
                <p>Selamat Datang, {{ Auth::user()->name }}!</p> 
            </div>
        </div>
    </section>

    
   @endsection