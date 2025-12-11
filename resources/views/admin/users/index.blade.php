{{-- resources/views/admin/users.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title"> {{-- Menggunakan class dari admin-theme.css --}}
            {{ __('Kelola Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content"> {{-- Menggunakan class dari admin-theme.css --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card"> {{-- Menggunakan class dari admin-theme.css --}}
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="admin-section-title"> {{-- Menggunakan class dari admin-theme.css --}}
                            Daftar Semua Pengguna
                        </h3>
                        {{-- Tambahkan tombol untuk "Tambah User Admin Baru" jika diperlukan nanti --}}
                        <a href="{{ route('admin.users.create') }}" class="admin-button button-green">
                            + Tambah Admin Atau Pengguna Baru
                        </a> 
                    </div>

                    @if(session('success'))
                        <div class="admin-alert alert-success mb-4"> {{-- Class baru untuk notifikasi --}}
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($users->count() > 0)
                        <div class="admin-table-container"> {{-- Menggunakan class dari admin-theme.css --}}
                            <table class="admin-table"> {{-- Menggunakan class dari admin-theme.css --}}
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Peran (Role)</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="status-badge {{ $user->role == 1 ? 'status-admin' : 'status-user' }}">
                                                    {{ $user->role == 1 ? 'Admin' : 'User' }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->isoFormat('D MMM YY, HH:mm') }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="admin-action-link link-edit">Edit</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus user ini?');">
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
                        <p class="admin-text-secondary">Belum ada pengguna terdaftar.</p> {{-- Menggunakan class dari admin-theme.css --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>