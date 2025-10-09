@extends('layouts.dashboard')
@section('title', 'Hasil Kondisi Emosimu')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] pb-24">

  {{-- 🔹 Header --}}
  <div class="w-full flex items-center justify-between px-6 py-5 bg-[#f5f7fb]">
    <a href="{{ route('dass21.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-700 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="font-medium text-sm md:text-base">Kembali</span>
    </a>
    <h1 class="text-xl md:text-2xl font-bold text-blue-700 text-center flex-1 -translate-x-4 md:-translate-x-8">
      Hasil Kondisi Emosimu
    </h1>
    <div class="w-6"></div>
  </div>

  {{-- 🔹 Hero Banner --}}
  <div class="max-w-6xl mx-auto rounded-3xl overflow-hidden shadow-lg bg-cover bg-center relative"
       style="background-image: url('{{ asset('bgbanner.png') }}'); min-height: 240px;">
    <div class="absolute inset-0 bg-gradient-to-r from-[#002b80]/80 to-[#0053d6]/60"></div>

    <div class="relative z-10 px-8 py-12 md:px-14 md:py-16 flex flex-col md:flex-row justify-between items-start md:items-center text-white">
      <div class="flex-1">
        <div class="flex items-center gap-3 text-xs md:text-sm opacity-90 mb-3 md:mb-4">
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2a10 10 0 0 0-7.09 17.09A10 10 0 1 0 12 2Zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8Zm0-14a1 1 0 0 0-1 1v5a1 1 0 0 0 .29.7l3 3a1 1 0 0 0 1.42-1.42L13 10.59V7a1 1 0 0 0-1-1Z"/>
            </svg>
            {{ now()->format('H:i') }} WIB, {{ now()->translatedFormat('d F Y') }}
          </div>
          <span>•</span>
          <span class="font-semibold">{{ Auth::user()->name ?? 'Pengguna' }}</span>
        </div>

        <p class="text-sm md:text-base opacity-90">Kondisi Emosi Hari Ini</p>
        <h2 class="text-2xl md:text-4xl font-bold leading-snug mt-1 md:mt-2">
          Hari yang membingungkan ya <span class="text-yellow-300">😔</span>…
        </h2>
        <p class="mt-2 text-xs md:text-sm opacity-90 max-w-md">
          Hasil DASS-21 kamu menunjukkan kondisi emosimu saat ini secara keseluruhan.
        </p>
      </div>

      <div class="mt-8 md:mt-0 bg-white/20 px-6 py-5 md:px-8 md:py-6 rounded-2xl text-center backdrop-blur-md shadow-md">
        <p class="text-xs md:text-sm opacity-90 mb-1">Hasil DASS-21</p>
        <h3 class="text-2xl md:text-3xl font-bold text-white">{{ $session->overall_risk ?? 'Risiko Rendah' }}</h3>
        <p class="text-[11px] md:text-xs opacity-80 mt-1">Gabungan Depresi, Anxiety, dan Stress</p>
      </div>
    </div>
  </div>

  {{-- 🔹 3 Card Risiko --}}
  <div class="max-w-6xl mx-auto mt-10 md:mt-14 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
    <div class="bg-[#eaf3ff] hover:bg-[#dbe9ff] rounded-2xl py-8 px-6 text-center shadow-md hover:shadow-lg transition-all">
      <h4 class="text-lg font-semibold text-gray-800 mb-2">Depresi</h4>
      <p class="text-base text-gray-700">Risiko <span class="font-bold text-blue-700">{{ $session->depresi_kelas ?? '-' }}</span></p>
      <p class="text-xs text-gray-500 mt-1">Skor: {{ $session->depresi_skor ?? '-' }}</p>
    </div>

    <div class="bg-[#d8f9df] hover:bg-[#c7f1d0] rounded-2xl py-8 px-6 text-center shadow-md hover:shadow-lg transition-all">
      <h4 class="text-lg font-semibold text-gray-800 mb-2">Anxiety</h4>
      <p class="text-base text-gray-700">Risiko <span class="font-bold text-green-700">{{ $session->anxiety_kelas ?? '-' }}</span></p>
      <p class="text-xs text-gray-500 mt-1">Skor: {{ $session->anxiety_skor ?? '-' }}</p>
    </div>

    <div class="bg-[#fff0db] hover:bg-[#ffe6c3] rounded-2xl py-8 px-6 text-center shadow-md hover:shadow-lg transition-all">
      <h4 class="text-lg font-semibold text-gray-800 mb-2">Stress</h4>
      <p class="text-base text-gray-700">Risiko <span class="font-bold text-orange-700">{{ $session->stres_kelas ?? '-' }}</span></p>
      <p class="text-xs text-gray-500 mt-1">Skor: {{ $session->stres_skor ?? '-' }}</p>
    </div>
  </div>

  {{-- 🔹 Garis Pemisah --}}
  <div class="max-w-6xl mx-auto my-10 md:my-14">
    <div class="border-b border-gray-500 opacity-20"></div>
  </div>

  {{-- 🔹 Penjelasan Hasil --}}
  <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow p-6 md:p-8 mb-10">
    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4 text-center">Penjelasan Hasil Kondisi</h3>
    <p class="text-gray-700 leading-relaxed text-sm md:text-base">
      {{ $session->overall_risk_note ?? 'Hasil kami menunjukkan bahwa keadaan emosi negatif kemungkinan besar tidak memengaruhi kesejahteraan Anda secara keseluruhan.' }}
    </p>
    <p class="mt-3 text-gray-700 text-sm md:text-base">
      Namun, jika Anda mengalami kesulitan tidur, perubahan nafsu makan, atau kesulitan menyelesaikan tugas di tempat kerja atau rumah, sebaiknya carilah dukungan dari ahli kesehatan mental.
    </p>
    <p class="mt-3 text-gray-700 text-sm md:text-base">
      Untuk meningkatkan ketahanan Anda secara keseluruhan, kami menyarankan Anda berkonsultasi dengan psikolog atau konselor melalui Program Perawatan Kesehatan Tenangan.
    </p>
  </div>

  {{-- 🔹 Rekomendasi Tindakan --}}
  <div class="max-w-6xl mx-auto">
    <h3 class="text-lg md:text-xl font-bold text-gray-800 text-center mb-2">Rekomendasi Tindakan</h3>
    <p class="text-sm text-gray-600 text-center mb-8">
      Untuk mengurangi stres dan kecemasan, cobalah aktivitas berikut ini.
    </p>

    <div class="grid md:grid-cols-2 gap-6 md:gap-8">
      {{-- Card 1 --}}
      <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all p-5 md:p-6 flex flex-col">
        <img src="{{ asset('activity1.png') }}" alt="DeepCalm" class="rounded-2xl mb-4 object-cover h-44 md:h-48 w-full">
        <h4 class="font-bold text-base md:text-lg mb-1">DeepCalm Breath</h4>
        <p class="text-xs md:text-sm text-gray-500 mb-2">Penanganan Stres — 4 Tahapan</p>
        <p class="text-sm text-gray-700 flex-1">
          Teknik pernapasan dalam yang membantu mengurangi ketegangan fisik dan mental dengan mengatur aliran oksigen ke tubuh.
        </p>
        <a href="#" class="mt-4 self-start bg-blue-700 hover:bg-blue-800 text-white text-xs md:text-sm px-4 py-2 rounded-full transition">
          Lihat Aktivitas
        </a>
      </div>

      {{-- Card 2 --}}
      <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all p-5 md:p-6 flex flex-col">
        <img src="{{ asset('activity2.png') }}" alt="AudioSoothe" class="rounded-2xl mb-4 object-cover h-44 md:h-48 w-full">
        <h4 class="font-bold text-base md:text-lg mb-1">AudioSoothe</h4>
        <p class="text-xs md:text-sm text-gray-500 mb-2">Penanganan Kecemasan — 2 Tahapan</p>
        <p class="text-sm text-gray-700 flex-1">
          Mendengarkan suara alam atau musik binaural yang membantu menenangkan pikiran dan mengurangi stres.
        </p>
        <a href="#" class="mt-4 self-start bg-blue-700 hover:bg-blue-800 text-white text-xs md:text-sm px-4 py-2 rounded-full transition">
          Lihat Aktivitas
        </a>
      </div>
    </div>
  </div>

  {{-- 🔹 Rekomendasi Konsultan --}}
  <div class="max-w-4xl mx-auto mt-16 text-center">
    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Rekomendasi Konsultan</h3>
    <p class="text-sm text-gray-600 mb-8">Jika merasa kondisimu belum membaik, cobalah untuk berkonsultasi dengan ahli.</p>

    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col md:flex-row items-center justify-between gap-6 max-w-3xl mx-auto">
      <div class="flex items-center gap-4 md:gap-5">
        <img src="{{ asset('consul1.png') }}" alt="Konsultan" class="w-20 h-20 md:w-24 md:h-24 rounded-xl object-cover">
        <div class="text-left">
          <h5 class="text-base md:text-lg font-bold text-gray-800">Anggia Kirana Candra</h5>
          <p class="text-sm text-gray-600">Terapis di Universitas Negeri Surabaya</p>
          <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-700 text-[11px] md:text-xs rounded-full">10 Tahun Pengalaman</span>
          <div class="flex items-center gap-2 mt-2 text-xs md:text-sm text-gray-600">
            Rp. 35.000 / 2 Sesi <span class="text-yellow-500">⭐</span> 5.0
          </div>
        </div>
      </div>
      <a href="{{ route('konsultan.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-xs md:text-sm font-semibold transition">
        Hubungi Sekarang
      </a>
    </div>

    <div class="mt-10 flex justify-center gap-4">
      <a href="{{ route('konsultan.index') }}" class="bg-blue-700 hover:bg-blue-800 text-white px-5 md:px-6 py-2 rounded-lg font-medium text-sm shadow-md transition">
        Cari Konsultan Lain
      </a>
      <a href="{{ route('dass21.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 md:px-6 py-2 rounded-lg font-medium text-sm transition">
        Kembali ke Menu Layanan
      </a>
    </div>
  </div>

</div>
@endsection
