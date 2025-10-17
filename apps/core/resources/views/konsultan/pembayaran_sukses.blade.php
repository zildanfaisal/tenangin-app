@extends('layouts.dashboard')
@section('title','Pembayaran Sukses')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f4f6fb] px-4 sm:px-6">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow text-center w-full max-w-sm sm:max-w-md">
        {{-- Ikon sukses --}}
        <svg class="w-14 h-14 sm:w-16 sm:h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>

        {{-- Judul --}}
        <h2 class="text-xl sm:text-2xl font-bold mb-2">Pembayaran Berhasil</h2>
        
        {{-- Deskripsi --}}
        <p class="text-gray-500 text-sm sm:text-base mb-6 leading-relaxed">
            Terima kasih! Pembayaran telah dikonfirmasi melalui QR scan.
        </p>
        
        {{-- Tombol kembali --}}
        <a href="{{ route('dashboard') }}"
           class="block w-full sm:w-auto bg-blue-600 text-white font-medium px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Kembali
        </a>
    </div>
</div>
@endsection
