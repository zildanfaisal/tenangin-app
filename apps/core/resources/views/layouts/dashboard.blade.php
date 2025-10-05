<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: true, profileOpen: false }" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tenangin') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Layout Wrapper -->
    <div class="flex flex-1">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-56' : 'w-14'"
               class="bg-white border-r border-gray-200 text-gray-600 min-h-screen transition-all duration-300 flex flex-col sticky top-0">

            <!-- Logo -->
            <div class="flex items-center justify-center py-6">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-9 w-9">
                <span x-show="sidebarOpen" class="text-blue-600 font-bold text-lg ml-1.5">Tenangin</span>
            </div>

            <!-- Menu -->
            <nav class="flex-1 mt-3 space-y-2 px-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg font-semibold transition-all
                   {{ request()->routeIs('dashboard') ? 'bg-blue-100/50 text-blue-600' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-house {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                
                <a href="{{ route('dass21.index') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all
                    {{ request()->routeIs('dass21.*') ? 'bg-blue-100/50 text-blue-600 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-hand-holding-heart {{ request()->routeIs('dass21.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span x-show="sidebarOpen">Layanan</span>
                </a>

                @can('manajemen-curhat')
                <a href="{{ route('admin.dass21-items.index') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all
                    {{ request()->routeIs('admin.dass21-items.*') ? 'bg-blue-100/50 text-blue-600 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-hand-holding-heart {{ request()->routeIs('admin.dass21-items.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span x-show="sidebarOpen">CMS Dass21</span>
                </a>
                @endcan

                <a href="{{ route('konsultan.index') }}"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all
                    {{ request()->routeIs('konsultan.index') ? 'bg-blue-100/50 text-blue-600 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-comments {{ request()->routeIs('konsultan.index') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span x-show="sidebarOpen">Konsultasi</span>
                </a>

                @can('manajemen-penanganan')
                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all
                    {{ request()->routeIs('penanganan.*') ? 'bg-blue-100/50 text-blue-600 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-hand-holding-heart {{ request()->routeIs('penanganan.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span x-show="sidebarOpen">Penanganan</span>
                </a>
                @endcan

                <a href="#"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all
                   {{ request()->routeIs('user.*') ? 'bg-blue-100/50 text-blue-600 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fa-solid fa-user {{ request()->routeIs('user.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span x-show="sidebarOpen">User</span>
                </a>
            </nav>

            <!-- Upgrade Box -->
            <div class="p-4 mt-auto">
                <!-- Ketika sidebar terbuka -->
                <div x-show="sidebarOpen" x-transition class="bg-blue-50 border border-blue-300 rounded-lg p-4 text-sm">
                    <p class="font-bold text-blue-600">Tingkatkan Fitur</p>
                    <p class="text-blue-700 text-xs mt-1 mb-2 leading-tight">
                        Nikmati akses penuh ke semua fitur pendampingan mental!
                    </p>
                    <div class="flex justify-end">
                        <i class="fa-solid fa-chevron-right text-blue-600 text-sm"></i>
                    </div>
                </div>

                <!-- Ketika sidebar diminimize -->
                <div x-show="!sidebarOpen" x-transition class="flex justify-center">
                    <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-full p-3 border border-blue-300 shadow-sm">
                        <i class="fa-solid fa-crown text-lg"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col transition-all duration-300">

            <!-- Navbar -->
            <header class="bg-white shadow flex justify-between items-center px-6 py-4 sticky top-0 z-30">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded hover:bg-gray-200 focus:outline-none">
                        <i class="fa-solid fa-angles-left" x-show="sidebarOpen"></i>
                        <i class="fa-solid fa-angles-right" x-show="!sidebarOpen"></i>
                    </button>
                    <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
                </div>

                <!-- Profile -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img class="h-8 w-8 rounded-full border"
                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Profile">
                        <span class="hidden md:inline text-gray-700">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-caret-down text-gray-600"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fa-solid fa-user"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Page -->
            <main class="p-6 flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Global Footer -->
    <footer class="bg-[#162A5E] text-white py-8 px-10 text-sm w-full mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center md:items-start">
            <!-- Left Side -->
            <div class="flex items-start space-x-3 mb-3 md:mb-0">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-12">
                <p class="leading-snug text-[13px] max-w-md">
                    <span class="font-semibold">Tenangin</span> adalah platform kesehatan mental berbasis AI yang memberikan dukungan personal untuk deteksi dan penanganan gangguan kecemasan, stres, depresi, burnout, dan PTSD.
                </p>
            </div>
            <!-- Right Side -->
            <p class="text-[13px] text-gray-300 text-center md:text-right">
                © 2025 Tenangin. All Rights Reserved.<br>
                Made with love by <span class="font-semibold text-white">Mie Ayam team</span>
            </p>
        </div>
    </footer>

</body>
</html>
