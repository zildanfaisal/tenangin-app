@extends('layouts.dashboard')
@section('title', 'Pemesanan Konsultasi')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] p-6">

    {{-- 🔹 Banner Section --}}
    <div class="relative rounded-2xl overflow-hidden mb-8"
        style="background-image: url('{{ asset('bgbaner2.png') }}'); background-size: cover; background-position: center;">
        <div class="bg-gradient-to-r from-[#0D47A1]/70 to-[#1976D2]/70 p-8 rounded-2xl text-white backdrop-blur-sm">
            <h2 class="text-2xl font-semibold mb-2">Pemesanan Konsultasi</h2>
            <p class="text-sm text-blue-100 max-w-3xl">
                Lihat status pemesanan konsultasimu, jadwal yang akan datang, dan kelola sesi yang sudah kamu pesan.
            </p>

            {{-- Tabs --}}
            <div class="mt-4 flex space-x-3 text-sm">
                <a href="{{ route('konsultan.riwayat') }}"
                   class="px-4 py-2 rounded-md transition
                   {{ request()->routeIs('konsultan.riwayat') ? 'bg-white/30 text-blue-100 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                   Riwayat Konsultasi
                </a>

                <a href="{{ route('konsultan.pemesanan') }}"
                   class="px-4 py-2 rounded-md transition
                   {{ request()->routeIs('konsultan.pemesanan') ? 'bg-white/30 text-blue-100 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                   Pemesanan
                </a>

                <a href="{{ route('konsultan.index') }}"
                   class="px-4 py-2 rounded-md transition
                   {{ request()->routeIs('konsultan.index') ? 'bg-white/30 text-blue-100 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-blue-50' }}">
                   Booking Konsultasi
                </a>
            </div>
        </div>
    </div>

    {{-- 🔹 Search & Filter --}}
    <div class="flex flex-col md:flex-row items-center gap-3 mb-6">
        <div class="flex items-center bg-white rounded-xl shadow-sm px-3 py-2 flex-1">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Temukan Konselor yang kamu cari"
                class="flex-1 bg-transparent outline-none text-gray-700 ml-2 text-sm">
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">Konselor</button>
            <button class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">Konsultan</button>
        </div>
    </div>

    {{-- 🔹 Card Pemesanan --}}
    <div class="space-y-5">
        @foreach ($pemesanan as $p)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-5 flex flex-col md:flex-row items-center gap-5 {{ $p['aktif'] ? '' : 'opacity-80 grayscale' }}">
            {{-- Foto --}}
            <img src="{{ asset($p['foto']) }}" alt="{{ $p['nama'] }}" class="w-28 h-28 rounded-xl object-cover shadow-sm">

            {{-- Info --}}
            <div class="flex-1 w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $p['nama'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $p['spesialisasi'] }}</p>
                        <span class="inline-block bg-gray-50 border border-gray-200 px-3 py-1 mt-2 rounded-full text-sm text-gray-700">
                            {{ $p['pengalaman'] }}
                        </span>
                        <div class="flex items-center gap-1 mt-2 text-yellow-500">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star {{ $i < $p['rating'] ? '' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="text-gray-700 text-sm font-medium ml-1">{{ number_format($p['rating'], 1) }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $p['tanggal'] }}, Pukul {{ $p['waktu'] }}</p>
                    </div>

                    {{-- Status --}}
                    <p class="text-sm font-medium {{ $p['aktif'] ? 'text-blue-600' : 'text-gray-500' }}">
                        {{ $p['status'] }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-4 flex justify-end gap-2">
                    <button class="px-4 py-2 rounded-md border text-sm font-medium
                        {{ $p['aktif'] ? 'border-blue-500 text-blue-600 hover:bg-blue-50' : 'border-gray-300 text-gray-400' }}">
                        Lihat Invoice
                    </button>

                    <button class="px-4 py-2 rounded-md text-sm font-medium shadow-sm transition
                        {{ $p['aktif'] ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}">
                        Masuk Ruangan
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Script pencarian sederhana --}}
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        card.style.display = name.includes(value) ? 'flex' : 'none';
    });
});
</script>
@endsection
