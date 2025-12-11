<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-header-title">
            {{ __('Tambah Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 admin-page-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="admin-content-card">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="admin-label">{{ __('Nama') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                   class="admin-input mt-1 block w-full">
                            @error('name')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="admin-label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="admin-input mt-1 block w-full">
                            @error('email')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="admin-label">{{ __('Password') }}</label>
                            <input type="password" name="password" id="password" required
                                   class="admin-input mt-1 block w-full">
                            @error('password')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="admin-label">{{ __('Konfirmasi Password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="admin-input mt-1 block w-full">
                        </div>

                        <div class="mb-4">
                            <label for="role" class="admin-label">{{ __('Peran (Role)') }}</label>
                            <select name="role" id="role" required class="admin-input mt-1 block w-full">
                                <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>User Biasa</option>
                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="admin-error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.users.index') }}" class="admin-link-secondary mr-4">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="admin-button button-green">
                                {{ __('Simpan Pengguna') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>