@extends('layouts.dashboard')
@section('title', 'Booking Konsultasi')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] p-6">

    {{-- 🔹 Banner Section --}}
    <div class="relative rounded-2xl overflow-hidden mb-8"
         style="background-image: url('{{ asset('bgbaner2.png') }}'); background-size: cover; background-position: center;">
        <div class="bg-gradient-to-r from-[#0D47A1]/70 to-[#1976D2]/70 p-8 rounded-2xl text-white backdrop-blur-sm">
            <h2 class="text-2xl font-semibold mb-2">Booking Konsultasi</h2>
            <p class="text-sm text-blue-100 max-w-3xl">
                Pilih ahli yang sesuai dengan profilmu, ceritakan kondisimu kepada konselor atau konsultan ahli kami,
                dan dapatkan rekomendasi terbaik untuk mendukung kesehatan mentalmu.
            </p>

            {{-- Tabs --}}
            <div class="mt-4 flex space-x-3 text-sm">
                <a href="{{ route('konsultan.riwayat') }}"
                class="px-4 py-2 rounded-md transition
                {{ request()->routeIs('konsultan.riwayat')
                    ? 'bg-white/30 text-blue-100 font-semibold shadow-sm'
                    : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                Riwayat Konsultasi
                </a>

                <a href="{{ route('konsultan.pemesanan') }}"
                class="px-4 py-2 rounded-md transition
                {{ request()->routeIs('konsultan.pemesanan')
                    ? 'bg-white/30 text-blue-100 font-semibold shadow-sm'
                    : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                Pemesanan
                </a>

                <a href="{{ route('konsultan.index') }}"
                class="px-4 py-2 rounded-md transition
                {{ request()->routeIs('konsultan.index')
                    ? 'bg-white/30 text-blue-100 font-semibold shadow-sm'
                    : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                Booking Konsultasi
                </a>
            </div>

        </div>
    </div>

    @can('manajemen-konsultan')
    <div class="mb-8">
        <a href="{{ route('konsultan.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition">
           + Tambah Konsultan
        </a>
    </div>
    @endcan

    {{-- 🔍 Search Bar + Button --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div class="flex-1 flex items-center bg-white rounded-xl shadow-sm px-3 py-2 w-full">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Temukan Konsultan yang kamu cari..."
                   class="flex-1 bg-transparent outline-none text-gray-700 ml-2 text-sm">
        </div>
        <div class="flex gap-2">
            <button class="bg-white hover:bg-blue-50 border border-gray-200 text-blue-700 font-medium px-4 py-2 rounded-lg shadow-sm transition">
                Konselor
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition">
                Konsultan
            </button>
        </div>
    </div>

    {{-- 🔹 Main Content: Filter + List --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Sidebar Filter --}}
        <aside class="bg-white rounded-2xl shadow-sm p-5 h-fit">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter</h3>

            {{-- Pricing --}}
            <div class="mb-5">
                <p class="text-sm font-medium text-gray-700 mb-2">Pricing</p>
                <div class="flex items-center gap-2">
                    <input type="number" placeholder="Min" class="w-20 bg-gray-50 border border-gray-200 rounded-md px-2 py-1 text-sm focus:ring-blue-400 focus:border-blue-400">
                    <span class="text-gray-500">–</span>
                    <input type="number" placeholder="Max" class="w-20 bg-gray-50 border border-gray-200 rounded-md px-2 py-1 text-sm focus:ring-blue-400 focus:border-blue-400">
                </div>
            </div>

            {{-- Gender --}}
            <div class="mb-5">
                <p class="text-sm font-medium text-gray-700 mb-2">Gender</p>
                <div class="space-y-1 text-sm">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="gender" checked class="text-blue-500 focus:ring-blue-400">
                        <span>Semua</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="gender" class="text-blue-500 focus:ring-blue-400">
                        <span>Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="gender" class="text-blue-500 focus:ring-blue-400">
                        <span>Perempuan</span>
                    </label>
                </div>
            </div>

            {{-- Rating --}}
            <div>
                <p class="text-sm font-medium text-gray-700 mb-3">Rating</p>
                <div id="rating-filter" class="flex items-center gap-1 cursor-pointer">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star text-gray-300 text-xl hover:text-yellow-400 transition" data-rating="{{ $i }}"></i>
                    @endfor
                </div>
                <p class="text-xs text-gray-400 mt-1">Klik untuk filter rating minimal</p>
            </div>
        </aside>

        {{-- List Konsultan --}}
        <div class="md:col-span-3 space-y-6">
            @foreach($konsultans as $konsultan)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-5 flex flex-col md:flex-row items-center gap-5 konsultant-card"
                 data-rating="{{ $konsultan->rating }}">
                {{-- Foto --}}
                <img src="{{ $konsultan->foto ? asset($konsultan->foto) : asset('default-user.png') }}"
                     alt="{{ $konsultan->nama_konsultan }}"
                     class="w-28 h-28 rounded-xl object-cover shadow-sm">

                {{-- Info --}}
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $konsultan->nama_konsultan }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $konsultan->deskripsi }}</p>
                    <p class="text-sm text-gray-500">{{ $konsultan->spesialisasi }}</p>

                    {{-- Pengalaman + Harga + Rating --}}
                    <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full shadow-sm">
                            {{ $konsultan->pengalaman }} Tahun Pengalaman
                        </span>
                        <span class="font-medium text-gray-700">Rp. {{ number_format($konsultan->harga, 0, ',', '.') }} / 2 sesi</span>
                        <span class="flex items-center text-yellow-500">
                            <i class="fa-solid fa-star mr-1"></i> {{ number_format($konsultan->rating, 1) }}
                        </span>
                    </div>
                </div>

                {{-- Button --}}
                <div class="mt-3 md:mt-0">
                    <a href="{{ route('konsultan.detail', $konsultan->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium shadow-sm transition">
                    Hubungi Sekarang
                    </a>

                    @can('manajemen-konsultan')
                    <a href="{{ route('konsultan.edit', $konsultan->id) }}"
                    class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium shadow-sm transition">
                    Edit
                    </a>

                    <form action="{{ route('konsultan.destroy', $konsultan->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="ml-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition"
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

{{-- JS Filter --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('#rating-filter i');
    const cards = document.querySelectorAll('.konsultant-card');
    const searchInput = document.getElementById('searchInput');

    let minRating = 0;

    // Klik bintang untuk filter
    stars.forEach(star => {
        star.addEventListener('click', () => {
            minRating = parseInt(star.dataset.rating);
            stars.forEach(s => s.classList.remove('text-yellow-400'));
            for (let i = 0; i < minRating; i++) {
                stars[i].classList.add('text-yellow-400');
            }
            filterCards();
        });
    });

    // Filter berdasarkan pencarian nama
    searchInput.addEventListener('input', filterCards);

    function filterCards() {
        const search = searchInput.value.toLowerCase();
        cards.forEach(card => {
            const rating = parseFloat(card.dataset.rating);
            const name = card.querySelector('h3').textContent.toLowerCase();
            const visible = rating >= minRating && name.includes(search);
            card.style.display = visible ? 'flex' : 'none';
        });
    }
});
</script>
@endsection
