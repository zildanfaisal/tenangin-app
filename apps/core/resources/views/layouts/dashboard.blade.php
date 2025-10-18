<!DOCTYPE html>
<html lang="en" x-data="dashboardLayout()" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tenangin') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">

<!-- Wrapper utama -->
<div class="flex">

    <!-- 🔹 SIDEBAR (tetap fixed) -->
    <aside
        x-show="sidebarOpen || window.innerWidth >= 768"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed left-0 top-0 bottom-0 w-56 bg-white border-r border-gray-200
               text-gray-600 flex flex-col z-50 shadow-lg md:shadow-none transition-all duration-300">

        <!-- Logo -->
        <div class="flex items-center justify-center py-5 border-b border-gray-100">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-9 w-9">
            <span class="text-blue-600 font-bold text-lg ml-2">Tenangin</span>
        </div>

        <!-- Menu -->
        <nav class="flex-1 mt-3 space-y-2 px-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
                {{ request()->routeIs('dashboard')
                    ? 'bg-blue-100 text-blue-600 shadow-sm font-semibold'
                    : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-house {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('dass21.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
                {{ request()->routeIs('dass21.*')
                    ? 'bg-blue-100 text-blue-600 shadow-sm font-semibold'
                    : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-heart-pulse {{ request()->routeIs('dass21.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                <span>Layanan</span>
            </a>

            <a href="{{ route('konsultan.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
                {{ request()->routeIs('konsultan.*')
                    ? 'bg-blue-100 text-blue-600 shadow-sm font-semibold'
                    : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-comments {{ request()->routeIs('konsultan.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                <span>Konsultasi</span>
            </a>

            <a href="{{ route('user.index') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
                {{ request()->routeIs('user.*')
                    ? 'bg-blue-100 text-blue-600 shadow-sm font-semibold'
                    : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fa-solid fa-user {{ request()->routeIs('user.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                <span>User</span>
            </a>
        </nav>

        <!-- Premium Box -->
        <div class="p-4 mt-auto border-t border-gray-100">
            <a href="{{ route('premium.index') }}"
               class="block bg-blue-100 hover:bg-blue-200 text-blue-700 border border-blue-300 rounded-xl p-4 text-sm transition-all">
                <p class="font-bold text-blue-700">Tingkatkan Fitur</p>
                <p class="text-xs leading-tight mt-1">Nikmati akses penuh ke semua fitur pendampingan mental!</p>
                <div class="flex justify-end mt-1">
                    <i class="fa-solid fa-chevron-right text-blue-700 text-xs"></i>
                </div>
            </a>
        </div>
    </aside>

    <!-- Overlay (mobile only) -->
    <div x-show="sidebarOpen && window.innerWidth < 768"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40 md:hidden"></div>

    <!-- 🔹 MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col md:ml-56">

        <!-- Navbar -->
        <header class="bg-white shadow flex justify-between items-center px-6 py-4 sticky top-0 z-40">
            <div class="flex items-center space-x-4">
                <!-- Mobile: hamburger -->
                <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded hover:bg-gray-200 focus:outline-none transition md:hidden">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Desktop: collapse toggle -->
                <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden md:block p-2 rounded hover:bg-gray-200 focus:outline-none transition">
                    <i class="fa-solid fa-angles-left" x-show="sidebarOpen"></i>
                    <i class="fa-solid fa-angles-right" x-show="!sidebarOpen"></i>
                </button>

                <h1 class="text-lg md:text-xl font-semibold">@yield('title', 'Dashboard')</h1>
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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Konten + Footer ikut scroll -->
        <div class="flex flex-col min-h-screen bg-gray-50">
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <footer class="bg-[#162A5E] text-white py-8 px-10 text-sm w-full">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center md:items-start">
                    <div class="flex items-start space-x-3 mb-3 md:mb-0">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-10 w-10">
                        <p class="leading-snug text-[13px] max-w-md">
                            <span class="font-semibold">Tenangin</span> adalah platform kesehatan mental berbasis AI
                            untuk mendeteksi dan menangani stres, kecemasan, depresi, burnout, dan PTSD.
                        </p>
                    </div>
                    <p class="text-[12px] text-gray-300 text-center md:text-right">
                        © 2025 Tenangin. All Rights Reserved.<br>
                        Made with 💙 by <span class="font-semibold text-white">Mie Ayam Team</span>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</div>

@stack('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function dashboardLayout() {
    return {
        sidebarOpen: window.innerWidth >= 768,
        init() {
            window.addEventListener('resize', () => {
                this.sidebarOpen = window.innerWidth >= 768;
            });
        }
    }
}
</script>
</body>
</html>
