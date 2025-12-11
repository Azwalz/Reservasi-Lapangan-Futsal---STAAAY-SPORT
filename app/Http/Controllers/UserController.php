<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('user.profile', ['user' => Auth::user()]);
        // Anda perlu membuat view 'resources/views/user/profile.blade.php' nanti
        // Untuk sekarang, bisa juga:
        // return "Halaman Profil User: " . Auth::user()->name;
    }
}