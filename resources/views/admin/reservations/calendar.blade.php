<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Kalender Jadwal Reservasi') }}
        </h2>
    </x-slot>

    {{-- CSS untuk FullCalendar --}}
    @push('styles')
    <style>
        /* Anda bisa menambahkan override style untuk kalender di sini jika perlu */
        .fc-event {
            cursor: pointer;
            border-width: 2px !important;
        }
        .fc-daygrid-event .fc-event-title {
            font-weight: 600;
        }
    </style>
    @endpush

    <div class="py-12 admin-page-content">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="admin-card-padding">
                    {{-- Elemen div ini adalah tempat kalender akan dirender --}}
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript untuk FullCalendar --}}
    @push('scripts')
    {{-- Kita akan menggunakan CDN untuk memuat pustaka FullCalendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // Konfigurasi dasar
                initialView: 'dayGridMonth', // Tampilan awal: bulan
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // Pilihan tampilan: bulan, minggu, hari
                },
                
                // Mengambil data event dari API yang sudah kita buat
                events: '{{ route("admin.api.reservations.events") }}',

                // Konfigurasi tambahan
                editable: false, // Apakah event bisa di-drag/resize (false untuk saat ini)
                selectable: true, // Apakah slot waktu bisa dipilih
                
                // Menyesuaikan format waktu
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                
                // Aksi saat slot waktu kosong diklik (untuk membuat reservasi baru)
                select: function(info) {
                    // Dapatkan tanggal mulai dari info yang diberikan
                    var startDate = new Date(info.startStr);
                    var formattedDate = startDate.getFullYear() + '-' + String(startDate.getMonth() + 1).padStart(2, '0') + '-' + String(startDate.getDate()).padStart(2, '0');
                    
                    // Arahkan ke halaman tambah reservasi dengan tanggal yang sudah terisi
                    var createUrl = '{{ route("admin.reservations.create") }}' + '?tanggal_booking=' + formattedDate;
                    window.location.href = createUrl;
                },

                // Memberikan loading indicator saat data sedang diambil
                loading: function(isLoading) {
                    if (isLoading) {
                        // Anda bisa menampilkan spinner/loading indicator di sini
                        calendarEl.style.opacity = '0.5';
                    } else {
                        calendarEl.style.opacity = '1';
                    }
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
