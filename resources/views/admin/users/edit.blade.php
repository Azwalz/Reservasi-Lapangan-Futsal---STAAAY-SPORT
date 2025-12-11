<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Edit Pengguna: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="admin-card-padding">
                    {{-- Menampilkan notifikasi sukses atau error jika ada dari session --}}
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
                    {{-- Menampilkan error validasi umum jika ada --}}
                    @if ($errors->any())
                        <div class="admin-alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT') {{-- Penting untuk update --}}

                        <div class="mb-4">
                            <label for="name" class="admin-label">{{ __('Nama') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('name')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="admin-label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('email')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="admin-label">{{ __('Peran (Role)') }}</label>
                            <select name="role" id="role" required
                                    class="admin-input mt-1 block w-full">
                                <option value="0" {{ old('role', $user->role) == 0 ? 'selected' : '' }}>User Biasa</option>
                                <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Opsional: Update Password --}}
                        {{-- Jika Anda ingin menambahkan fitur update password di sini, tambahkan field password dan konfirmasi password --}}
                        {{-- <div class="mb-4">
                            <label for="password" class="admin-label">{{ __('Password Baru (Kosongkan jika tidak diubah)') }}</label>
                            <input type="password" name="password" id="password"
                                   class="admin-input mt-1 block w-full">
                            @error('password')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="admin-label">{{ __('Konfirmasi Password Baru') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="admin-input mt-1 block w-full">
                        </div> --}}

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.users.index') }}" class="admin-link-secondary mr-4">
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
