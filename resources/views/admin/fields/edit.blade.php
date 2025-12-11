<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl {{-- text-gray-800 --}} leading-tight admin-header-title">
            {{ __('Edit Lapangan: ') }} {{ $lapangan->nama_lapangan }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.fields.update', $lapangan->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Method untuk update --}}

                        <div class="mb-4">
                            <label for="nama_lapangan" class="admin-label">{{ __('Nama Lapangan') }}</label>
                            <input type="text" name="nama_lapangan" id="nama_lapangan" value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('nama_lapangan')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="admin-label">{{ __('Deskripsi') }}</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                      class="admin-textarea mt-1 block w-full">{{ old('deskripsi', $lapangan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="harga_per_jam" class="admin-label">{{ __('Harga per Jam (Rp)') }}</label>
                            <input type="number" name="harga_per_jam" id="harga_per_jam" value="{{ old('harga_per_jam', $lapangan->harga_per_jam) }}" required min="0" step="1000"
                                   class="admin-input mt-1 block w-full">
                            @error('harga_per_jam')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tipe_lapangan" class="admin-label">{{ __('Tipe Lapangan') }}</label>
                            <input type="text" name="tipe_lapangan" id="tipe_lapangan" value="{{ old('tipe_lapangan', $lapangan->tipe_lapangan) }}"
                                   class="admin-input mt-1 block w-full">
                            @error('tipe_lapangan')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="admin-label">{{ __('Gambar Saat Ini') }}</label>
                            @if ($lapangan->gambar_lapangan)
                                <img src="{{ $lapangan->gambar_url }}" alt="{{ $lapangan->nama_lapangan }}" class="mt-1 h-32 w-auto object-cover rounded">
                            @else
                                <p class="admin-text-secondary mt-1">Tidak ada gambar.</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="gambar_lapangan" class="admin-label">{{ __('Ganti Gambar Lapangan (Kosongkan jika tidak ingin diubah)') }}</label>
                            <input type="file" name="gambar_lapangan" id="gambar_lapangan"
                                   class="admin-input-file mt-1 block w-full">
                            @error('gambar_lapangan')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.fields.index') }}" class="admin-link-secondary mr-4">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="admin-button button-indigo">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>