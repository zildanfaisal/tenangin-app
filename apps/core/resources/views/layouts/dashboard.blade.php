<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: true, profileOpen: false }" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tenangin') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-full flex">

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-64' : 'w-20'"
         class="bg-blue-900 text-white h-screen transition-all duration-300 flex flex-col fixed">

        <!-- Logo -->
        <div class="flex items-center space-x-2 p-4">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
            <span x-show="sidebarOpen" class="font-bold text-lg">Tenangin</span>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-2 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-gauge"></i>
                <span x-show="sidebarOpen">Dashboard</span>
            </a>

            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('layanan.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span x-show="sidebarOpen">Layanan</span>
            </a>

            <a href="{{ route('dass21.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('dass21.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span x-show="sidebarOpen">Dass 21</span>
            </a>

            <a href="{{ route('konsultan.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('konsultan.index') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-comments"></i>
                <span x-show="sidebarOpen">Konsultasi</span>
            </a>

            @can('manajemen-penanganan')
            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('penanganan.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span x-show="sidebarOpen">Penanganan</span>
            </a>
            @endcan

            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('user.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-user"></i>
                <span x-show="sidebarOpen">User / Coin</span>
            </a>

            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded transition
               {{ request()->routeIs('langganan.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-800' }}">
                <i class="fa-solid fa-crown"></i>
                <span x-show="sidebarOpen">Langganan</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col transition-all duration-300"
         :class="sidebarOpen ? 'md:ml-64' : 'md:ml-20'">

        <!-- Top Navbar -->
        <header class="bg-white shadow flex justify-between items-center px-6 py-4 sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <!-- Tombol minimize di kiri -->
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
                    <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                    <i class="fa-solid fa-caret-down"></i>
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


        <!-- Page Content -->
        <main class="p-6 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>
