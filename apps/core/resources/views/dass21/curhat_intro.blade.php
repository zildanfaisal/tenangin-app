@extends('layouts.dashboard')
@section('title','Curhat')

@section('content')
<div class="flex justify-center items-center min-h-[85vh] bg-[#f5f7fb] px-4 sm:px-6 py-6">

  {{-- Hero Container --}}
  <div
    class="relative w-full max-w-6xl rounded-2xl sm:rounded-3xl shadow-lg overflow-hidden transition-all duration-500 ease-in-out"
    style="
      background-image: url('{{ asset('bb.png') }}');
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    "
  >

    {{-- Ganti background untuk desktop --}}
    <style>
      @media (min-width: 768px) {
        div[style*='background-image'] {
          background-image: url('{{ asset('bb2.png') }}') !important;
          background-size: cover !important; /* FULL kiri-kanan, atas-bawah tetap aman */
          background-position: center center !important;
          background-repeat: no-repeat !important;
        }
      }
    </style>

    {{-- Overlay teks & tombol --}}
    <div class="flex flex-col justify-between h-full px-6 sm:px-10 md:px-16 py-8 sm:py-10 text-white bg-black/30 md:bg-transparent">

      {{-- Bagian teks kiri --}}
      <div class="max-w-md sm:max-w-lg drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)]">
        <p class="text-xs sm:text-sm opacity-90 mb-1">Asesmen pertama sudah selesai nih...</p>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight mb-2 sm:mb-3">
          Yuk Lanjutkan<br>ke sesi Curhat~
        </h1>
        <p class="text-xs sm:text-sm md:text-base opacity-95 leading-relaxed">
          Perdalam kondisi emosimu dengan lanjut ke sesi curhat selama 5 menit.
        </p>
      </div>

      {{-- Tombol bawah --}}
      <div class="w-full sm:w-3/4 md:w-1/2 mt-6 sm:mt-8">
        <a href="{{ route('dass21.curhat', $session->id) }}"
           class="block w-full text-center bg-white text-blue-700 font-semibold py-2.5 sm:py-3 px-4 sm:px-6
                  rounded-lg sm:rounded-xl hover:bg-blue-50 transition text-sm sm:text-base shadow-sm">
          Lanjut Curhat
        </a>
      </div>

    </div>
  </div>

</div>
@endsection
