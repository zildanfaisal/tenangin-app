<!DOCTYPE html>
<html lang="en" x-data="dashboardLayout()" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - {{ config('app.name', 'Tenangin') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
<div class="flex">

  <!-- 🔹 SIDEBAR -->
  <aside
    x-show="sidebarOpen || window.innerWidth >= 768"
    :class="sidebarCollapsed ? 'w-20' : 'w-56'"
    x-transition
    class="fixed left-0 top-0 bottom-0 bg-white border-r border-gray-200
           text-gray-600 flex flex-col z-50 shadow-lg md:shadow-none transition-all duration-300">

    <!-- Logo -->
    <div class="flex items-center justify-center py-5 border-b border-gray-100 transition-all duration-300"
         :class="sidebarCollapsed ? 'px-2 justify-center' : 'px-4 justify-start'">
      <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-9 w-9">
      <span x-show="!sidebarCollapsed" class="text-blue-600 font-bold text-lg ml-2 transition-all">Tenangin</span>
    </div>

    <!-- Menu -->
    <nav class="flex-1 mt-3 space-y-1 px-2 overflow-y-auto">

      <!-- Dashboard -->
      <a href="{{ route('dashboard') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('dashboard')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600 focus:bg-blue-100 focus:text-blue-600 active:bg-blue-100 active:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-house
          {{ request()->routeIs('dashboard')
              ? 'text-blue-600'
              : 'text-gray-400 transition-colors' }}">
        </i>
        <span x-show="!sidebarCollapsed">Dashboard</span>
      </a>

      <!-- Layanan -->
      <a href="{{ route('dass21.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('dass21.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600 focus:bg-blue-100 focus:text-blue-600 active:bg-blue-100 active:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-heart-pulse
          {{ request()->routeIs('dass21.*')
              ? 'text-blue-600'
              : 'text-gray-400 transition-colors' }}">
        </i>
        <span x-show="!sidebarCollapsed">Layanan</span>
      </a>

      <!-- Konsultasi -->
      <a href="{{ route('konsultan.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('konsultan.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600 focus:bg-blue-100 focus:text-blue-600 active:bg-blue-100 active:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-comments
          {{ request()->routeIs('konsultan.*')
              ? 'text-blue-600'
              : 'text-gray-400 transition-colors' }}">
        </i>
        <span x-show="!sidebarCollapsed">Konsultasi</span>
      </a>

      <!-- User -->
      <a href="{{ route('user.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('user.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600 focus:bg-blue-100 focus:text-blue-600 active:bg-blue-100 active:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-user
          {{ request()->routeIs('user.*')
              ? 'text-blue-600'
              : 'text-gray-400 transition-colors' }}">
        </i>
        <span x-show="!sidebarCollapsed">User</span>
      </a>
    </nav>

    <!-- 🔹 PREMIUM BOX -->
    <div class="p-4 mt-auto border-t border-gray-100 flex justify-center">
      <template x-if="!sidebarCollapsed">
        <a href="{{ route('premium.index') }}"
           class="block bg-blue-100 hover:bg-blue-200 text-blue-700 border border-blue-300 rounded-xl p-4 text-sm transition-all w-full focus:bg-blue-200 active:bg-blue-200">
          <p class="font-bold text-blue-700">Tingkatkan Fitur</p>
          <p class="text-xs leading-tight mt-1">Nikmati akses penuh ke semua fitur pendampingan mental!</p>
          <div class="flex justify-end mt-1">
            <i class="fa-solid fa-chevron-right text-blue-700 text-xs"></i>
          </div>
        </a>
      </template>

      <!-- Mode collapsed -->
      <template x-if="sidebarCollapsed">
        <a href="{{ route('premium.index') }}"
           class="bg-blue-100 hover:bg-blue-200 border border-blue-300 text-blue-700 rounded-full w-12 h-12 flex items-center justify-center transition-all focus:bg-blue-200 active:bg-blue-200"
           title="Tingkatkan Fitur">
          <i class="fa-solid fa-star text-lg"></i>
        </a>
      </template>
    </div>
  </aside>

  <!-- Overlay (mobile only) -->
  <div x-show="sidebarOpen && window.innerWidth < 768"
       @click="sidebarOpen = false"
       class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40 md:hidden"></div>

  <!-- 🔹 MAIN CONTENT -->
  <div class="flex-1 flex flex-col" :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-56'">
    <header class="bg-white shadow flex justify-between items-center px-6 py-4 sticky top-0 z-40">
      <div class="flex items-center space-x-4">
        <!-- Mobile toggle -->
        <button @click="sidebarOpen = !sidebarOpen"
                class="p-2 rounded hover:bg-gray-200 focus:outline-none transition md:hidden">
          <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Desktop collapse toggle -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="hidden md:block p-2 rounded hover:bg-gray-200 focus:outline-none transition">
          <i class="fa-solid fa-angles-left" x-show="!sidebarCollapsed"></i>
          <i class="fa-solid fa-angles-right" x-show="sidebarCollapsed"></i>
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

    <!-- Content -->
    <main class="flex-1 p-6 bg-gray-50">
      @yield('content')
    </main>

    <!-- Footer -->
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

@stack('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function dashboardLayout() {
  return {
    sidebarOpen: window.innerWidth >= 768,
    sidebarCollapsed: false,
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
