@extends('layouts.dashboard')
@section('title', 'Detail Konsultan')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] p-6">

    {{-- 🔹 Card Utama --}}
    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-10 transition hover:shadow-xl duration-300">
        <div class="flex flex-col md:flex-row">
            {{-- 🔹 Foto Konsultan --}}
            <div class="md:w-1/3 bg-gray-50 flex items-center justify-center p-6">
                <img src="{{ asset($konsultan->foto ?? 'default-user.png') }}"
                    alt="{{ $konsultan->nama_konsultan }}"
                    class="w-48 h-48 md:w-56 md:h-56 rounded-2xl object-cover shadow-md border border-gray-200">
            </div>

            {{-- 🔹 Detail Konsultan --}}
            <div class="flex-1 p-6 md:p-8">
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight mb-1">
                        {{ $konsultan->nama_konsultan }}
                    </h3>
                    <p class="text-sm text-blue-600 font-medium">{{ $konsultan->spesialisasi }}</p>
                </div>

                <div class="flex flex-wrap gap-2 mb-5">
                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $konsultan->pengalaman }} Tahun Pengalaman
                    </span>
                    <span class="bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-sm font-medium">
                        Rp. {{ number_format($konsultan->harga, 0, ',', '.') }} / 2 Sesi
                    </span>
                </div>

                {{-- 🔹 Deskripsi --}}
                <p class="text-gray-700 text-sm leading-relaxed mb-6">
                    {{ $konsultan->deskripsi ?? 'Belum ada deskripsi tersedia untuk konsultan ini.' }}
                </p>

                <p class="text-gray-700 whitespace-pre-line">{{ $konsultan->jadwal_praktik }}</p>

                {{-- 🔹 Form Jadwal Dinamis --}}
                <form action="{{ route('konsultan.pembayaran', $konsultan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs text-gray-500 mb-1 font-semibold">Tanggal Konsultasi</label>
                            <input type="date" name="tanggal"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                required>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs text-gray-500 mb-1 font-semibold">Waktu Konsultasi</label>
                            <input type="time" name="jam"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                required>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-6 py-3 shadow-md w-full md:w-auto transition-all duration-200 focus:ring-4 focus:ring-blue-200">
                        Ajukan Jadwal
                    </button>
                </form>

                {{-- 🔹 Notifikasi --}}
                @if (session('success'))
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-2 rounded-lg">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- 🔹 Rating & Ulasan --}}
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Rating dan Ulasan</h4>

        @foreach ($ulasan as $u)
        <div class="border-b border-gray-100 pb-4 mb-4 last:border-none last:mb-0">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-semibold">
                    {{ strtoupper(substr($u['nama'], 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <h5 class="font-medium text-gray-800">{{ $u['nama'] }}</h5>
                        <div class="flex items-center text-yellow-500 text-sm">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star {{ $i < $u['rating'] ? '' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="ml-1 font-medium text-gray-700">{{ number_format($u['rating'], 1) }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $u['isi'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
