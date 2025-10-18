@extends('layouts.dashboard')
@section('title','Asesmen Kesehatan Mental')

@section('content')
<div class="min-h-screen flex flex-col bg-[#f5f7fb]">

  {{-- Tombol Back --}}
  <div class="flex items-center gap-2 px-4 sm:px-6 pt-4 sm:pt-6">
    <a href="{{ route('dass21.index') }}" class="flex items-center text-gray-600 hover:text-indigo-600 transition text-sm sm:text-base">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="2" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 mr-1">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="font-medium">Asesmen</span>
    </a>
  </div>

  {{-- Konten utama --}}
  <div class="flex flex-col md:flex-row flex-1 rounded-2xl overflow-hidden shadow-md mx-3 sm:mx-6 my-4 sm:my-6 bg-white">

    {{-- Kiri: Konten teks --}}
    <div class="flex-1 p-5 sm:p-8 md:p-12 flex flex-col justify-center">
      <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-800 mb-3 sm:mb-4">
        Tenangin Asesmen Kesehatan Mental
      </h2>

      <p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8 leading-relaxed">
        Tenangin menggunakan <span class="font-medium text-gray-800">Depression, Anxiety, and Stress Scale (DASS-21)</span>
        untuk melakukan Asesmen Kesehatan Mental.
        <br><br>
        DASS-21 adalah kuisioner standar singkat dengan 21 pertanyaan yang membantu mengidentifikasi faktor risiko depresi, kecemasan, dan stres.
        Asesmen ini berfungsi sebagai indikator awal, bukan alat diagnosis medis.
        <br><br>
        Setelah mengisi DASS-21, pengguna akan melanjutkan ke sesi curhat berbasis suara.
        Cerita pengguna akan direkam dan diolah secara otomatis menggunakan teknologi AI, sehingga pengalaman berbagi menjadi lebih natural dan personal.
        <br><br>
        Hasil asesmen dan ringkasan curhat kemudian diolah untuk memberikan penjelasan yang relevan dan mudah dipahami mengenai kondisi kesehatan mental pengguna.
        Tenangin juga menyediakan ruang untuk berkonsultasi dengan profesional agar mendapatkan dukungan yang tepat.
      </p>

      {{-- Info card --}}
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8 text-center">
        {{-- Card 1 --}}
        <div class="border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center h-28 sm:h-32">
          <p class="text-2xl sm:text-3xl font-bold text-indigo-600">21</p>
          <p class="text-xs sm:text-sm text-gray-600 mt-1">Pertanyaan</p>
        </div>

        {{-- Card 2 --}}
        <div class="border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center h-28 sm:h-32">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" class="w-6 h-6 sm:w-7 sm:h-7 text-indigo-600 mb-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
          <p class="text-xs sm:text-sm text-gray-600">Pilihan Ganda</p>
        </div>

        {{-- Card 3 --}}
        <div class="border border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center h-28 sm:h-32">
          <p class="text-xs sm:text-sm text-gray-600">5 Menit</p>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" class="w-6 h-6 sm:w-7 sm:h-7 text-indigo-600 mb-1 mt-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p class="text-xs sm:text-sm text-gray-600">Sesi Curhat</p>
        </div>
      </div>

      {{-- Tombol Mulai --}}
      <form action="{{ route('dass21.start') }}" method="POST">@csrf
        <button
          class="w-full sm:w-auto px-6 sm:px-8 py-2.5 sm:py-3 bg-blue-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-blue-700 transition">
          Mulai Asesmen
        </button>
      </form>
    </div>

    {{-- Kanan: Gambar (disembunyikan pada layar kecil / Android mode) --}}
    <div class="hidden md:block w-full md:w-5/12 h-48 sm:h-64 md:h-auto bg-cover bg-center"
      style="background-image: url('{{ asset('bg1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center;">
    </div>
  </div>
</div>
@endsection
