<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LapanganPublikController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UlasanPublikController;
use App\Http\Controllers\UserReservationController;
use App\Http\Controllers\PembayaranController; // Untuk user biasa

// Import Controller Admin yang Baru
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminLapanganController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminCalendarController;
use App\Http\Controllers\Admin\AdminUlasanController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // RUTE UNTUK HALAMAN DAFTAR LAPANGAN 
    // Route::get('/', function () { return redirect()->route('lapangan.index'); });
    Route::get('/lapangan', [LapanganPublikController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/{lapangan}', [LapanganPublikController::class, 'show'])->name('lapangan.show');
    Route::get('/ulasan', [UlasanPublikController::class, 'index'])->name('ulasan.index'); 

    Route::get('/reservasi/pilih', [ReservationController::class, 'chooseLapangan'])->name('reservasi.choose');
    Route::get('/reservasi/buat/{lapangan}', [ReservationController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/sukses/{reservasi}', [ReservationController::class, 'success'])->name('reservasi.success');


        // RUTE UNTUK RIWAYAT RESERVASI PENGGUNA
    Route::get('/reservasi-saya', [UserReservationController::class, 'history'])->name('reservasi.history');

    Route::get('/reservasi/{reservasi}/pembayaran', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/reservasi/{reservasi}/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    


    // RUTE BARU UNTUK ULASAN PENGGUNA
    Route::get('/reservasi/{reservasi}/ulasan/tambah', [UlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/reservasi/{reservasi}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    // ... rute lain untuk user biasa (jika ada UserController terpisah) ...
    // Contoh jika ada UserController untuk profil:
    // Route::get('/profil', [App\Http\Controllers\UserProfileController::class, 'show'])->name('user.profile');
});

// === GRUP RUTE ADMIN ===
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pengguna (Resource Controller)
    // Ini akan otomatis membuat rute untuk index, create, store, edit, update, destroy
    // Untuk show, kita tidak butuh karena detail user bisa dilihat di edit atau dari daftar reservasi
    Route::resource('/users', AdminUserController::class)->except(['show']);

    // Manajemen Lapangan (Resource Controller)
    // Parameter 'lapangan' digunakan karena modelnya Lapangan, bukan Field
    Route::resource('/lapangan', AdminLapanganController::class)
         ->parameters(['lapangan' => 'lapangan']) // Memberitahu Laravel parameter di URL adalah 'lapangan'
         ->names('fields'); // Memberi nama grup rute 'fields' (admin.fields.index, admin.fields.create, dll)

    // Manajemen Reservasi (Rute didefinisikan manual karena ada method custom seperti updateStatus)
    Route::get('/reservasi', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservasi/tambah', [AdminReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservasi', [AdminReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservasi/{reservasi}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservasi/{reservasi}/edit', [AdminReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservasi/{reservasi}', [AdminReservationController::class, 'update'])->name('reservations.update');
    Route::patch('/reservasi/{reservasi}/update-status', [AdminReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::delete('/reservasi/{reservasi}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/pembayaran/{pembayaran}/update-status', [App\Http\Controllers\Admin\PembayaranController::class, 'updateStatus'])->name('pembayaran.updateStatus');


    // Kalender
    Route::get('/kalender', [AdminCalendarController::class, 'index'])->name('calendar.index');
    Route::get('/api/reservasi-events', [AdminCalendarController::class, 'getEvents'])->name('api.reservations.events');

    // UNTUK KELOLA ULASAN
    Route::get('/ulasan', [AdminUlasanController::class, 'index'])->name('ulasan.index');
    Route::patch('/ulasan/{ulasan}/update-status', [AdminUlasanController::class, 'updateStatus'])->name('ulasan.updateStatus');
    Route::delete('/ulasan/{ulasan}', [AdminUlasanController::class, 'destroy'])->name('ulasan.destroy');

});

require __DIR__.'/auth.php';
