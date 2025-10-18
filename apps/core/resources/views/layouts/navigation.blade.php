<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-6 md:px-12 py-4 flex items-center justify-between">
        <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="text-2xl font-bold text-[#0279FD]">Tenangin</span>
        </a>

        <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-600">
            <a href="#fitur" class="hover:text-indigo-600">Layanan</a>
            <a href="#pricing" class="hover:text-indigo-600">Pricing</a>
            <a href="#berita" class="hover:text-indigo-600">Berita</a>
            <a href="#konsultasi" class="hover:text-indigo-600">Daftar Konsultasi</a>
            <a href="#tentang-kami" class="hover:text-indigo-600">Tentang Kami</a>
            <a href="#kontak" class="hover:text-indigo-600">Kontak</a>
        </nav>

        <div class="hidden md:flex items-center space-x-4">
            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg text-sm">Login</a>
            <a href="{{ route('register') }}" class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-2 px-5 rounded-lg text-sm">Sign Up</a>
        </div>

        {{-- Button Mobile --}}
        <div class="md:hidden">
            <button id="menu-btn" type="button" class="text-gray-800 hover:text-indigo-600 focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="menu-open-icon" fill-rule="evenodd" d="M4 5h16M4 11h16M4 17h16"/>
                    <path id="menu-close-icon" class="hidden" fill-rule="evenodd" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu Mobile --}}
    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-white shadow-md">
        <div class="flex flex-col items-center space-y-2 py-4">
            <a href="#fitur" class="w-full text-gray-800 text-center py-2 rounded-md hover:bg-[#0279FD]/10 transition">Layanan</a>
            <a href="#pricing" class="w-full text-gray-800 text-center py-2 rounded-md hover:bg-[#0279FD]/10 transition">Pricing</a>
            <a href="#berita" class="w-full text-gray-800 text-center py-2 rounded-md hover:bg-[#0279FD]/10 transition">Berita</a>
            <a href="#konsultasi" class="w-full text-gray-800 text-center py-2 rounded-md hover:bg-[#0279FD]/10 transition">Daftar Konsultasi</a>
            <a href="#tentang-kami" class="w-full text-gray-800 text-center py-2 rounded-md hover:bg-[#0279FD]/10 transition">Tentang Kami</a>
            <a href="#kontak" class="w-full text-gray-800 text-center py-2 rounded-md hover:bg-[#0279FD]/10 transition">Kontak</a>

        <div class="flex flex-col w-3/4 space-y-3 pt-4 border-t border-gray-200">
            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg text-center transition">Login</a>
            <a href="{{ route('register') }}" class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-2 rounded-lg text-center transition">Sign Up</a>
        </div>
    </div>
</header>
