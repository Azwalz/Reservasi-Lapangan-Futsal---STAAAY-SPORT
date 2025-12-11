<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Periksa peran user di sini jika perlu
        if (auth()->user()->role == 1) {
            // Jika admin, mungkin arahkan ke dashboard admin?
            return redirect()->route('admin.dashboard');
        }

        // Jika user biasa, tampilkan view 'home'
        return view('home'); // Pastikan Anda punya file resources/views/home.blade.php
    }
}