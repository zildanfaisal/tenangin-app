@extends('layouts.dashboard')
@section('title', 'Booking Konsultasi')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] p-4 md:p-6">

    {{-- 🔹 Banner Section --}}
    <div class="relative rounded-2xl overflow-hidden mb-6 md:mb-8"
         style="background-image: url('{{ asset('bgbaner2.png') }}'); background-size: cover; background-position: center;">
        <div class="bg-gradient-to-r from-[#0D47A1]/70 to-[#1976D2]/70 p-6 md:p-8 rounded-2xl text-white backdrop-blur-sm">
            <h2 class="text-xl md:text-2xl font-semibold mb-2">Booking Konsultasi</h2>
            <p class="text-xs md:text-sm text-blue-100 max-w-3xl">
                Pilih ahli yang sesuai dengan profilmu, ceritakan kondisimu kepada konselor atau konsultan ahli kami,
                dan dapatkan rekomendasi terbaik untuk mendukung kesehatan mentalmu.
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

    @can('manajemen-konsultan')
    <div class="mb-6 md:mb-8 text-center md:text-left">
        <a href="{{ route('konsultan.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition inline-block w-full sm:w-auto">
           + Tambah Konsultan
        </a>
    </div>
    @endcan

    {{-- 🔍 Search Bar --}}
    <form method="GET" action="" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 md:gap-4 mb-6 md:mb-8">
        <div class="flex-1 flex items-center bg-white rounded-xl shadow-sm px-3 py-2 w-full">
            <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm md:text-base"></i>
            <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                   placeholder="Temukan Konsultan..."
                   class="flex-1 bg-transparent outline-none text-gray-700 ml-2 text-sm md:text-base">
        </div>

        <div class="flex gap-2 justify-between sm:justify-end w-full sm:w-auto">
            <button type="submit" name="kategori" value="konselor"
                class="flex-1 sm:flex-none bg-white hover:bg-blue-50 border border-gray-200 text-blue-700 font-medium px-4 py-2 rounded-lg shadow-sm transition text-xs md:text-sm {{ request('kategori') == 'konselor' ? 'ring-2 ring-blue-500' : '' }}">
                Konselor
            </button>
            <button type="submit" name="kategori" value="konsultan"
                class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition text-xs md:text-sm {{ request('kategori') == 'konsultan' ? 'ring-2 ring-blue-500' : '' }}">
                Konsultan
            </button>
        </div>
    </form>

    {{-- 🔹 Filter (MOBILE) --}}
    <aside class="bg-white rounded-2xl shadow-sm p-4 mb-6 block md:hidden">
        <h3 class="text-base font-semibold text-gray-800 mb-3">Filter</h3>
        @include('partials.filter-konsultan')
    </aside>

    {{-- 🔹 Main Content: Filter + List --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-6">

        {{-- Sidebar Filter (DESKTOP) --}}
        <aside class="bg-white rounded-2xl shadow-sm p-4 md:p-5 h-fit hidden md:block">
            <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Filter</h3>
            @include('partials.filter-konsultan')
        </aside>

        {{-- List Konsultan --}}
        <div class="md:col-span-3 space-y-4 md:space-y-6">
            @foreach($konsultans as $konsultan)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-4 md:p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 konsultant-card"
                 data-rating="{{ $konsultan->rating }}">
                {{-- Foto --}}
                <img src="{{ $konsultan->foto ? asset($konsultan->foto) : asset('default-user.png') }}"
                     alt="{{ $konsultan->nama_konsultan }}"
                     class="w-24 h-24 md:w-28 md:h-28 rounded-xl object-cover shadow-sm">

                {{-- Info --}}
                <div class="flex-1 w-full">
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 flex flex-wrap items-center gap-2">
                        {{ $konsultan->nama_konsultan }}
                        @if($konsultan->kategori === 'konselor')
                        <span class="bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200 px-2 py-0.5 rounded-full text-xs md:text-sm font-medium capitalize">
                            {{ $konsultan->kategori }}
                        </span>
                        @else
                        <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded-full text-xs md:text-sm font-medium capitalize">
                            {{ $konsultan->kategori }}
                        </span>
                        @endif
                    </h3>

                    <p class="text-xs md:text-sm text-gray-600 mb-1 md:mb-2 line-clamp-2">{{ $konsultan->deskripsi }}</p>
                    <p class="text-xs md:text-sm text-gray-500">{{ $konsultan->spesialisasi }}</p>

                    <div class="flex flex-wrap items-center gap-2 mt-3 text-xs md:text-sm">
                        <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full shadow-sm">
                            {{ $konsultan->pengalaman }} Tahun
                        </span>
                        <span class="font-medium text-gray-700">Rp {{ number_format($konsultan->harga, 0, ',', '.') }}/2 sesi</span>
                        <span class="flex items-center text-yellow-500">
                            <i class="fa-solid fa-star mr-1"></i> {{ number_format($konsultan->rating, 1) }}
                        </span>
                    </div>
                </div>

                {{-- Button --}}
                <div class="w-full sm:w-auto flex flex-wrap sm:flex-nowrap gap-2 mt-3 sm:mt-0">
                    <a href="{{ route('konsultan.detail', $konsultan->id) }}"
                       class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition text-center text-sm">
                        Hubungi
                    </a>

                    @can('manajemen-konsultan')
                    <a href="{{ route('konsultan.edit', $konsultan->id) }}"
                       class="flex-1 sm:flex-none bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium shadow-sm transition text-center text-sm">
                       Edit
                    </a>

                    <form action="{{ route('konsultan.destroy', $konsultan->id) }}" method="POST" class="flex-1 sm:flex-none inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition text-sm"
                            onclick="return confirm('Yakin ingin menghapus konsultan ini?');">
                            Hapus
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
