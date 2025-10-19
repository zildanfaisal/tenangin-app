<!DOCTYPE html>
<html lang="en" x-data="dashboardLayout()" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - {{ config('app.name', 'Tenangin') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  {{-- ✅ Animasi Toast --}}
  <style>
      [x-cloak] { display: none; }
      .slide-in {
          animation: slideIn 0.6s ease-out;
      }
      .fade-out {
          animation: fadeOut 0.6s ease-in forwards;
      }
      @keyframes slideIn {
          0% { transform: translateY(40px) translateX(40px); opacity: 0; }
          100% { transform: translateY(0) translateX(0); opacity: 1; }
      }
      @keyframes fadeOut {
          0% { opacity: 1; }
          100% { opacity: 0; transform: translateY(10px); }
      }
  </style>
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
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-house {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
        <span x-show="!sidebarCollapsed">Dashboard</span>
      </a>

      <!-- Layanan -->
      <a href="{{ route('dass21.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('dass21.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-heart-pulse {{ request()->routeIs('dass21.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
        <span x-show="!sidebarCollapsed">Layanan</span>
      </a>

      <!-- Konsultasi -->
      <a href="{{ route('konsultan.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('konsultan.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-comments {{ request()->routeIs('konsultan.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
        <span x-show="!sidebarCollapsed">Konsultasi</span>
      </a>

      @can('manajemen-curhat')
      <!-- CMS Penanganan -->
      <a href="{{ route('admin.penanganan.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('admin.penanganan.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-book-open {{ request()->routeIs('admin.penanganan.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
        <span x-show="!sidebarCollapsed">CMS Penanganan</span>
      </a>

      <!-- CMS Dass21 -->
      <a href="{{ route('admin.dass21-items.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('admin.dass21.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-clipboard-list {{ request()->routeIs('admin.dass21.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
        <span x-show="!sidebarCollapsed">CMS Dass 21</span>
      </a>
      @endcan

      <!-- User -->
      <a href="{{ route('user.index') }}"
         class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium transition-all
         {{ request()->routeIs('user.*')
             ? 'bg-blue-100 text-blue-600 font-semibold'
             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
         :class="sidebarCollapsed ? 'justify-center' : ''">
        <i class="fa-solid fa-user {{ request()->routeIs('user.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
        <span x-show="!sidebarCollapsed">User</span>
      </a>
    </nav>

    <!-- 🔹 PREMIUM BOX -->
    <div class="p-4 mt-auto border-t border-gray-100 flex justify-center">
      <template x-if="!sidebarCollapsed">
        <a href="{{ route('premium.index') }}"
           class="block bg-blue-100 hover:bg-blue-200 text-blue-700 border border-blue-300 rounded-xl p-4 text-sm transition-all w-full">
          <p class="font-bold text-blue-700">Tingkatkan Fitur</p>
          <p class="text-xs leading-tight mt-1">Nikmati akses penuh ke semua fitur pendampingan mental!</p>
          <div class="flex justify-end mt-1">
            <i class="fa-solid fa-chevron-right text-blue-700 text-xs"></i>
          </div>
        </a>
      </template>

      <template x-if="sidebarCollapsed">
        <a href="{{ route('premium.index') }}"
           class="bg-blue-100 hover:bg-blue-200 border border-blue-300 text-blue-700 rounded-full w-12 h-12 flex items-center justify-center"
           title="Tingkatkan Fitur">
          <i class="fa-solid fa-star text-lg"></i>
        </a>
      </template>
    </div>
  </aside>

  <!-- Overlay (mobile) -->
  <div x-show="sidebarOpen && window.innerWidth < 768"
       @click="sidebarOpen = false"
       class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40 md:hidden"></div>

  <!-- 🔹 MAIN CONTENT -->
  <div class="flex-1 flex flex-col" :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-56'">

    <!-- Header -->
    <header class="bg-white shadow flex justify-between items-center px-6 py-4 sticky top-0 z-40">
      <div class="flex items-center space-x-4">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded hover:bg-gray-200 focus:outline-none transition md:hidden">
          <i class="fa-solid fa-bars"></i>
        </button>
        <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden md:block p-2 rounded hover:bg-gray-200 focus:outline-none transition">
          <i class="fa-solid fa-angles-left" x-show="!sidebarCollapsed"></i>
          <i class="fa-solid fa-angles-right" x-show="sidebarCollapsed"></i>
        </button>
        <h1 class="text-lg md:text-xl font-semibold">@yield('title', 'Dashboard')</h1>
      </div>

      <!-- Profile -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
                class="flex items-center space-x-2 focus:outline-none hover:bg-gray-100 px-2 py-1 rounded-md transition">
          <img src="{{ Auth::user()->profile_photo
              ? asset('storage/' . Auth::user()->profile_photo)
              : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
              alt="Foto Profil"
              class="w-8 h-8 rounded-full border border-gray-300 object-cover">
          <span class="hidden md:inline text-gray-700 text-sm font-medium">
              {{ Auth::user()->name }}
          </span>
          <i class="fa-solid fa-caret-down text-gray-600 text-sm"></i>
        </button>

        <div x-show="open" @click.away="open = false" x-transition
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                  <i class="fa-solid fa-right-from-bracket mr-2 text-red-500"></i> Logout
              </button>
          </form>
        </div>
      </div>
    </header>

    <!-- Main Content -->
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

<!-- ✅ Toast Notification (success, error, warning, validation errors) -->
<div
  x-data="{
      showToast: {{ session('success') || session('error') || session('warning') || ($errors->any() ? 'true' : 'false') }},
      type: '{{ session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : ($errors->any() ? 'error' : ''))) }}',
      fading: false
  }"
  x-init="if (showToast) setTimeout(() => fading = true, 3500); if (showToast) setTimeout(() => showToast = false, 4000)"
  x-cloak
>
  <template x-if="showToast">
      <div
        :class="{
          'bg-green-500': type === 'success',
          'bg-red-500': type === 'error',
          'bg-yellow-500': type === 'warning',
          'fade-out': fading
        }"
        class="fixed bottom-6 right-6 text-white px-6 py-4 rounded-xl shadow-2xl flex items-start space-x-3 text-base font-semibold z-[9999] slide-in max-w-sm sm:max-w-md"
      >
          <i :class="{
              'fa-solid fa-circle-check text-2xl mt-1': type === 'success',
              'fa-solid fa-circle-xmark text-2xl mt-1': type === 'error',
              'fa-solid fa-triangle-exclamation text-2xl mt-1': type === 'warning'
          }"></i>

          <div class="flex flex-col">
              <span>{{ session('success') ?? session('error') ?? session('warning') }}</span>
              @if($errors->any())
                  <ul class="list-disc list-inside mt-1 text-sm text-white/90">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              @endif
          </div>
      </div>
  </template>
</div>

</body>
</html>
