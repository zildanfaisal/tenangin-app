@extends('layouts.dashboard')
@section('title','Curhat')

@section('content')
<div class="flex justify-center items-center min-h-[85vh] bg-[#f5f7fb] px-6">

  {{-- Hero Container --}}
  <div class="relative w-full max-w-6xl rounded-3xl shadow-md overflow-hidden">

    {{-- Gambar background --}}
    <img src="{{ asset('bg2.png') }}" alt="Curhat Background"
         class="w-full h-[420px] md:h-[460px] object-cover">

    {{-- Overlay teks dan tombol --}}
    <div class="absolute inset-0 flex flex-col justify-between px-10 md:px-16 py-10 text-white">

      {{-- Bagian teks kiri --}}
      <div class="max-w-xl">
        <p class="text-sm opacity-80 mb-1"></p>
        <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-3">
           <br>
        </h1>
        <p class="text-sm md:text-base opacity-90">

        </p>
      </div>

      {{-- Tombol di bawah --}}
      <div class="w-full md:w-3/4 mt-8">
            <a href="{{ route('dass21.curhat', $session->id) }}"
            class="inline-block mt-6 w-full md:w-auto text-center bg-white text-blue-700 font-semibold py-3 px-6 rounded-xl hover:bg-blue-50 transition">
            Lanjut Curhat
            </a>

      </div>

    </div>
  </div>

</div>
@endsection
