@extends('layouts.dashboard')
@section('title', 'Riwayat Konsultasi')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] p-4 md:p-6">

    {{-- 🔹 Banner Section --}}
    <div class="relative rounded-2xl overflow-hidden mb-6 md:mb-8"
         style="background-image: url('{{ asset('bgbaner2.png') }}'); background-size: cover; background-position: center;">
        <div class="bg-gradient-to-r from-[#0D47A1]/70 to-[#1976D2]/70 p-6 md:p-8 rounded-2xl text-white backdrop-blur-sm">
            <h2 class="text-xl md:text-2xl font-semibold mb-2">Riwayat Konsultasi</h2>
            <p class="text-xs md:text-sm text-blue-100 max-w-3xl">
                Lihat kembali riwayat konsultasi yang pernah kamu lakukan dan akses rekaman untuk mereview kembali hasil konsultasimu.
            </p>

            {{-- Tabs --}}
            <div class="mt-4 flex flex-wrap gap-2 text-xs md:text-sm">
                <a href="{{ route('konsultan.riwayat') }}"
                   class="px-3 py-2 rounded-md transition text-center flex-1 sm:flex-none
                   {{ request()->routeIs('konsultan.riwayat')
                       ? 'bg-white/30 text-blue-100 font-semibold shadow-sm'
                       : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                   Riwayat
                </a>

                <a href="{{ route('konsultan.pemesanan') }}"
                   class="px-3 py-2 rounded-md transition text-center flex-1 sm:flex-none
                   {{ request()->routeIs('konsultan.pemesanan')
                       ? 'bg-white/30 text-blue-100 font-semibold shadow-sm'
                       : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                   Pemesanan
                </a>

                <a href="{{ route('konsultan.index') }}"
                   class="px-3 py-2 rounded-md transition text-center flex-1 sm:flex-none
                   {{ request()->routeIs('konsultan.index')
                       ? 'bg-white/30 text-blue-100 font-semibold shadow-sm'
                       : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                   Booking
                </a>
            </div>
        </div>
    </div>

    {{-- 🔍 Search Bar --}}
    <form method="GET" action="" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 md:gap-4 mb-6 md:mb-8">
        <div class="flex-1 flex items-center bg-white rounded-xl shadow-sm px-3 py-2 w-full">
            <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm md:text-base"></i>
            <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                   placeholder="Temukan Konselor yang kamu cari..."
                   class="flex-1 bg-transparent outline-none text-gray-700 ml-2 text-sm md:text-base">
        </div>
    </form>

    {{-- 🔹 Filter (MOBILE) --}}
    <aside class="bg-white rounded-2xl shadow-sm p-4 mb-6 block md:hidden">
        <h3 class="text-base font-semibold text-gray-800 mb-3">Filter</h3>
        @include('partials.filter-konsultan')
    </aside>

    {{-- 🔹 Main Content (Filter + Riwayat List) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-6">

        {{-- Sidebar Filter (DESKTOP) --}}
        <aside class="bg-white rounded-2xl shadow-sm p-4 md:p-5 h-fit hidden md:block">
            <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Filter</h3>
            @include('partials.filter-konsultan')
        </aside>

        {{-- Riwayat List --}}
        <div class="md:col-span-3 space-y-4 md:space-y-6">

            <p class="text-center">Belum ada riwayat konsultasi</p>

            {{-- 🔸 Card 1 --}}
            {{-- <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-4 md:p-6 flex flex-col sm:flex-row gap-4 sm:gap-5">
                <img src="{{ asset('images/konsultan/anggia.jpg') }}" alt="Anggia Kirana Candra"
                     class="w-24 h-24 md:w-28 md:h-28 rounded-xl object-cover shadow-sm">

                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Anggia Kirana Candra</h3>
                            <p class="text-xs md:text-sm text-gray-600">Terapis di Universitas Negeri Surabaya</p>
                            <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full mt-2">
                                10 Tahun Pengalaman
                            </span>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500 mt-2 sm:mt-0 sm:text-right">
                            Rabu, 21 Oktober 2025<br>Pukul 15.00 WIB
                        </p>
                    </div> --}}

                    {{-- Rating --}}
                    {{-- <div class="flex items-center mb-3 text-yellow-400 text-sm md:text-base">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div> --}}

                    {{-- Input Ulasan --}}
                    {{-- <div class="flex items-center gap-2 mb-4">
                        <input type="text" placeholder="Ulasanmu"
                               class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-xs md:text-sm focus:ring-blue-400 focus:border-blue-400">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-sm transition">
                            <i class="fa-solid fa-paper-plane text-sm md:text-base"></i>
                        </button>
                    </div> --}}

                    {{-- Action Buttons --}}
                    {{-- <div class="flex flex-wrap sm:flex-nowrap gap-2">
                        <button class="flex-1 sm:flex-none px-4 py-2 border border-gray-300 rounded-lg text-xs md:text-sm text-gray-600 hover:bg-gray-100 transition">
                            Lihat Invoice
                        </button>
                        <button class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs md:text-sm shadow-sm transition">
                            Lihat Rekaman
                        </button>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
</div>
@endsection
