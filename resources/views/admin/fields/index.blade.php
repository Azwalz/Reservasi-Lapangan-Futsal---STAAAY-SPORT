<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title"> {{-- Class dari admin-theme.css --}}
            {{ __('Kelola Lapangan Futsal') }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content"> {{-- Class dari admin-theme.css --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Class Tailwind untuk layout container bisa tetap dipakai jika layout utama masih Breeze --}}
            <div class="admin-content-card"> {{-- Class dari admin-theme.css --}}
                <div class="p-6"> {{-- Anda bisa membuat class custom seperti .admin-card-padding --}}
                    <div class="admin-card-header"> {{-- Class baru untuk header di dalam kartu --}}
                        <h3 class="admin-section-title">
                            Daftar Lapangan
                        </h3>
                        <a href="{{ route('admin.fields.create') }}" class="admin-button button-green">
                            + Tambah Lapangan Baru
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="admin-alert alert-success"> {{-- Class dari admin-theme.css --}}
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($lapangans->count() > 0)
                        <div class="admin-table-container"> {{-- Class dari admin-theme.css --}}
                            <table class="admin-table"> {{-- Class dari admin-theme.css --}}
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar</th>
                                        <th>Nama Lapangan</th>
                                        <th>Tipe</th>
                                        <th>Harga/Jam</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lapangans as $lapangan)
                                        <tr>
                                            <td>{{ $lapangan->id }}</td>
                                            <td>
                                                <img src="{{ $lapangan->gambar_url }}" alt="{{ $lapangan->nama_lapangan }}" class="admin-table-image"> {{-- Class baru untuk styling gambar di tabel --}}
                                            </td>
                                            <td>{{ $lapangan->nama_lapangan }}</td>
                                            <td>{{ $lapangan->tipe_lapangan ?? 'N/A' }}</td>
                                            <td>Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('admin.fields.edit', $lapangan->id) }}" class="admin-action-link link-edit">Edit</a>
                                                <form action="{{ route('admin.fields.destroy', $lapangan->id) }}" method="POST" class="admin-action-form" onsubmit="return confirm('Anda yakin ingin menghapus lapangan {{ $lapangan->nama_lapangan }}? Tindakan ini tidak bisa dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-action-link link-delete">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="admin-text-secondary">Belum ada data lapangan. Silakan tambahkan lapangan baru.</p> {{-- Class dari admin-theme.css --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>