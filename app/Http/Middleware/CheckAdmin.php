<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login DAN rolenya adalah 1 (admin)
        if (!Auth::check() || Auth::user()->role != 1) {
            // Jika bukan admin, arahkan ke halaman lain (misalnya dashboard user atau halaman login)
            // atau tampilkan halaman 'unauthorized' (403)
            // abort(403, 'Anda tidak punya akses ke halaman ini.');
            return redirect('/home')->with('error', 'Anda tidak memiliki akses admin!');
        }

        // Jika user adalah admin, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}