<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Kelola Ulasan Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="admin-card-padding">
                    <div class="admin-card-header mb-4">
                        <h3 class="admin-section-title">
                            Daftar Ulasan
                        </h3>
                        {{-- Tidak ada tombol tambah ulasan oleh admin untuk saat ini --}}
                    </div>

                    {{-- FORM FILTER STATUS --}}
                    <form method="GET" action="{{ route('admin.ulasan.index') }}" class="mb-6">
                        <div class="flex items-end space-x-3">
                            <div>
                                <label for="filter_status" class="admin-label">Filter Status:</label>
                                <select name="filter_status" id="filter_status" class="admin-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('filter_status') == 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="pending" {{ request('filter_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('filter_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('filter_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            {{-- <button type="submit" class="admin-button button-blue">Filter</button> --}}
                        </div>
                    </form>
                    {{-- AKHIR FORM FILTER --}}


                    @if(session('success'))
                        <div class="admin-alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="admin-alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($ulasans->count() > 0)
                        <div class="admin-table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pengguna</th>
                                        <th>Lapangan</th>
                                        <th>Rating</th>
                                        <th style="min-width: 250px;">Komentar</th>
                                        <th>Status</th>
                                        <th>Tgl Ulas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ulasans as $ulasan)
                                        <tr>
                                            <td>{{ $ulasan->id }}</td>
                                            <td>{{ $ulasan->user->name ?? 'N/A' }}</td>
                                            <td>{{ $ulasan->lapangan->nama_lapangan ?? 'N/A' }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">&#9733;</span> {{-- Bintang Unicode --}}
                                                @endfor
                                                ({{ $ulasan->rating }})
                                            </td>
                                            <td class="whitespace-normal">{{ Str::limit($ulasan->komentar, 100) }}</td>
                                            <td>
                                                <span class="status-badge status-{{ strtolower($ulasan->status) }}">
                                                    {{ ucfirst($ulasan->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $ulasan->created_at->isoFormat('D MMM YY, HH:mm') }}</td>
                                            <td class="admin-table-actions">
                                                @if($ulasan->status == 'pending' || $ulasan->status == 'rejected')
                                                <form action="{{ route('admin.ulasan.updateStatus', $ulasan->id) }}" method="POST" class="admin-action-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <input type="hidden" name="previous_status" value="{{ request('filter_status', 'pending') }}">
                                                    <button type="submit" class="admin-action-button button-confirm" title="Setujui Ulasan">Setujui</button>
                                                </form>
                                                @endif
                                                @if($ulasan->status == 'pending' || $ulasan->status == 'approved')
                                                <form action="{{ route('admin.ulasan.updateStatus', $ulasan->id) }}" method="POST" class="admin-action-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <input type="hidden" name="previous_status" value="{{ request('filter_status', 'pending') }}">
                                                    <button type="submit" class="admin-action-button button-cancel" title="Tolak Ulasan">Tolak</button>
                                                </form>
                                                @endif
                                                <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}" method="POST" class="admin-action-form" onsubmit="return confirm('Anda yakin ingin menghapus ulasan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-action-link link-delete" title="Hapus Ulasan">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="admin-pagination-links mt-6">
                            {{ $ulasans->links() }}
                        </div>
                    @else
                        <p class="admin-text-secondary">
                            @if(request('filter_status') && request('filter_status') !== 'all')
                                Tidak ada ulasan dengan status "{{ request('filter_status') }}".
                            @else
                                Belum ada ulasan dari pengguna.
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
