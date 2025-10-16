@extends('layouts.dashboard')
@section('title','Curhat')

@section('content')
<div class="flex justify-center items-center min-h-[85vh] bg-[#f5f7fb] px-4 sm:px-6 py-6">

  {{-- Hero Container --}}
  <div class="relative w-full max-w-6xl rounded-2xl sm:rounded-3xl shadow-md overflow-hidden">

    {{-- Gambar background --}}
    <img src="{{ asset('bg2.png') }}" alt="Curhat Background"
         class="w-full h-64 sm:h-80 md:h-[400px] object-cover">

    {{-- Overlay teks dan tombol --}}
    <div class="absolute inset-0 flex flex-col justify-between px-6 sm:px-10 md:px-16 py-8 sm:py-10 text-white bg-black/30 md:bg-transparent">

      {{-- Bagian teks kiri --}}
      <div class="max-w-md sm:max-w-lg">
        <p class="text-xs sm:text-sm opacity-80 mb-1"></p>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight mb-2 sm:mb-3">
          {{-- Tambahkan teks hero di sini kalau ingin tampil --}}
          {{-- Contoh: "Saatnya Curhat Dengan Tenang" --}}
        </h1>
        <p class="text-xs sm:text-sm md:text-base opacity-90 leading-relaxed">
          {{-- Deskripsi singkat bisa di sini --}}
        </p>
      </div>

      {{-- Tombol di bawah --}}
      <div class="w-full sm:w-3/4 md:w-1/2 mt-6 sm:mt-8">
        <a href="{{ route('dass21.curhat', $session->id) }}"
           class="block w-full text-center bg-white text-blue-700 font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl hover:bg-blue-50 transition text-sm sm:text-base shadow-sm">
          Lanjut Curhat
        </a>
      </div>

    </div>
  </div>

</div>
@endsection
