<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"> {{-- Arahkan ke home --}}
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- INI BAGIAN YANG DIPERBAIKI --}}
                    @can('isAdmin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                    @else
                        {{-- Jika user biasa, arahkan ke 'home' karena 'dashboard' tidak ada --}}
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                             {{ __('Dashboard') }} {{-- Tulisannya tetap Dashboard, tapi linknya ke home --}}
                        </x-nav-link>
                    @endcan
                    {{-- AKHIR BAGIAN YANG DIPERBAIKI --}}

                    {{-- Tambahkan link admin lain jika perlu --}}
                    @can('isAdmin')
                         <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                            {{ __('Kelola User') }}
                        </x-x-nav-link>
                    @endcan

                </div>
            </div>
            <li class="nav-item logout-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link">
                        Logout ({{ Auth::user()->name }})
                    </button>
                </form>
            </li>

        </div>
    </div>
</nav>