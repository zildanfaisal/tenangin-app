<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
                <span class="font-bold text-lg text-gray-800">Tenangin</span>
            </div>

            <!-- Menu -->
            <div class="hidden md:flex space-x-8 text-gray-700 font-medium">
                <a href="#" class="hover:text-blue-700">Layanan</a>
                <a href="#" class="hover:text-blue-700">Berita</a>
                <a href="#" class="hover:text-blue-700">Daftar Konsultasi</a>
                <a href="#" class="hover:text-blue-700">Tentang Kami</a>
                <a href="#" class="hover:text-blue-700">Kontak</a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex space-x-3">
                <a href="{{ route('login') }}"
                   class="px-4 py-2 bg-blue-900 text-white rounded-md hover:bg-blue-800 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 bg-white text-blue-900 border border-gray-200 rounded-md shadow hover:bg-gray-50 transition">
                    Sign Up
                </a>
            </div>

        </div>
    </div>
</nav>
