<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight admin-header-title"> {{-- Menggunakan class dari admin-theme.css jika ada --}}
            {{ __('Tambah Lapangan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content"> {{-- Menggunakan class dari admin-theme.css jika ada --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card"> {{-- Menggunakan class dari admin-theme.css jika ada --}}
                <div class="p-6"> {{-- Tailwind class p-6 atau class custom Anda --}}
                    {{-- TAMBAHKAN enctype="multipart/form-data" UNTUK UPLOAD FILE --}}
                    <form method="POST" action="{{ route('admin.fields.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_lapangan" class="block text-sm font-medium {{-- text-gray-700 --}} admin-label">{{ __('Nama Lapangan') }}</label>
                            <input type="text" name="nama_lapangan" id="nama_lapangan" value="{{ old('nama_lapangan') }}" required
                                   class="mt-1 block w-full rounded-md {{-- border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 --}} admin-input">
                            @error('nama_lapangan')
                                <p class="text-red-500 text-xs mt-1 admin-error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium {{-- text-gray-700 --}} admin-label">{{ __('Deskripsi') }}</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                      class="mt-1 block w-full rounded-md {{-- border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 --}} admin-textarea">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1 admin-error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="harga_per_jam" class="block text-sm font-medium {{-- text-gray-700 --}} admin-label">{{ __('Harga per Jam (Rp)') }}</label>
                            <input type="number" name="harga_per_jam" id="harga_per_jam" value="{{ old('harga_per_jam') }}" required min="0" step="1000"
                                   class="mt-1 block w-full rounded-md {{-- border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 --}} admin-input">
                            @error('harga_per_jam')
                                <p class="text-red-500 text-xs mt-1 admin-error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tipe_lapangan" class="block text-sm font-medium {{-- text-gray-700 --}} admin-label">{{ __('Tipe Lapangan (Contoh: Sintetis, Vinyl)') }}</label>
                            <input type="text" name="tipe_lapangan" id="tipe_lapangan" value="{{ old('tipe_lapangan') }}"
                                   class="mt-1 block w-full rounded-md {{-- border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 --}} admin-input">
                            @error('tipe_lapangan')
                                <p class="text-red-500 text-xs mt-1 admin-error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gambar_lapangan" class="block text-sm font-medium {{-- text-gray-700 --}} admin-label">{{ __('Gambar Lapangan') }}</label>
                            <input type="file" name="gambar_lapangan" id="gambar_lapangan"
                                   class="mt-1 block w-full text-sm {{-- text-slate-500 --}} admin-input-file
                                          {{-- file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-violet-50 file:text-violet-700
                                          hover:file:bg-violet-100 --}} {{-- Class Tailwind untuk input file, atau gunakan class custom --}}
                                          ">
                            @error('gambar_lapangan')
                                <p class="text-red-500 text-xs mt-1 admin-error-message">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.fields.index') }}" class="text-sm {{-- text-gray-600 hover:text-gray-900 --}} admin-link-secondary mr-4">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="{{-- px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 --}} admin-button button-green">
                                {{ __('Simpan Lapangan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>