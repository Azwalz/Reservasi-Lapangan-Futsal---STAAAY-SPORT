<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class AdminCalendarController extends Controller
{

    public function index() // showCalendar menjadi index
    {
        return view('admin.reservations.calendar'); // View tetap di folder reservations
    }

    public function getEvents(Request $request) // getReservationEvents menjadi getEvents
    {
        $reservations = Reservasi::with(['user', 'lapangan'])
            ->whereNotIn('status', ['cancelled'])
            ->get();

        $events = $reservations->map(function ($reservasi) {
            return [
                'id'    => $reservasi->id,
                'title' => ($reservasi->lapangan->nama_lapangan ?? 'Lapangan ?') . ' - ' . ($reservasi->user->name ?? 'User ?'),
                'start' => $reservasi->tanggal_booking . 'T' . $reservasi->jam_mulai,
                'end'   => $reservasi->tanggal_booking . 'T' . $reservasi->jam_selesai,
                'url'   => route('admin.reservations.show', $reservasi->id),
                'backgroundColor' => $reservasi->lapangan->warna_kalender ?? '#3788d8',
                'borderColor' => $reservasi->lapangan->warna_kalender ?? '#3788d8',
            ];
        });

        return response()->json($events);
    }
}
