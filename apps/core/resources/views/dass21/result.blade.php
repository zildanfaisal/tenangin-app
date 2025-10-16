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
            @if(!empty($analisis?->hasil_kondisi))
                {{ $analisis->hasil_kondisi }}
            @else
                Hari yang membingungkan ya <span class="text-yellow-300">😔</span>…
            @endif
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
    @if(!empty($analisis?->hasil_emosi))
        <div class="mt-3 text-gray-700 leading-relaxed text-sm md:text-base space-y-3">
            {{-- tampilkan hasil emosi langsung dari AI --}}
            @foreach(explode("\n", $analisis->hasil_emosi) as $paragraph)
                @if(!empty(trim($paragraph)))
                    <p>{{ trim($paragraph) }}</p>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-gray-700 leading-relaxed text-sm md:text-base">
            {{ $session->overall_risk_note ?? 'Hasil kami menunjukkan bahwa keadaan emosi negatif kemungkinan besar tidak memengaruhi kesejahteraan Anda secara keseluruhan.' }}
        </p>
        <p class="mt-3 text-gray-700 text-sm md:text-base">
            Namun, jika Anda mengalami kesulitan tidur, perubahan nafsu makan, atau kesulitan menyelesaikan tugas di tempat kerja atau rumah, sebaiknya carilah dukungan dari ahli kesehatan mental.
        </p>
        <p class="mt-3 text-gray-700 text-sm md:text-base">
            Untuk meningkatkan ketahanan Anda secara keseluruhan, kami menyarankan Anda berkonsultasi dengan psikolog atau konselor melalui Program Perawatan Kesehatan Tenangan.
        </p>
    @endif

  </div>

  {{-- 🔹 Rekomendasi Tindakan (Dinamis dari Penanganan) --}}
  <div class="max-w-6xl mx-auto">
    <h3 class="text-lg md:text-xl font-bold text-gray-800 text-center mb-2">Rekomendasi Tindakan</h3>
    <p class="text-sm text-gray-600 text-center mb-8">
      Kami menyesuaikan rekomendasi berdasarkan hasil DASS-21 kamu. Coba salah satu program berikut ini.
    </p>

    @php
      $cards = $penanganan ?? collect();
    @endphp

    @if($cards->isEmpty())
      <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-4 max-w-3xl mx-auto text-sm">
        Belum ada rekomendasi penanganan yang tersedia saat ini. Silakan kembali nanti.
      </div>
    @else
      <div class="grid md:grid-cols-2 gap-6 md:gap-8">
        @foreach($cards as $item)
          <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all p-5 md:p-6 flex flex-col">
            <img src="{{ $item->cover_path ? asset('storage/'.$item->cover_path) : asset('activity1.png') }}" alt="{{ $item->nama_penanganan }}" class="rounded-2xl mb-4 object-cover h-44 md:h-48 w-full">
            <h4 class="font-bold text-base md:text-lg mb-1">{{ $item->nama_penanganan }}</h4>
            <p class="text-xs md:text-sm text-gray-500 mb-2">
              <span class="capitalize">
                {{ is_array($item->kelompok) ? implode(', ', array_map('ucfirst', $item->kelompok)) : ucfirst($item->kelompok) }}
              </span>
              — {{ $item->steps_published_count ?? $item->steps()->published()->count() }} Tahapan
              @php $dur = ($item->durasi_published_sum ?? $item->steps()->published()->sum('durasi_detik')) ?: 0; @endphp
              — Durasi ± {{ ceil($dur/60) }} menit
            </p>
            <p class="text-sm text-gray-700 flex-1 line-clamp-3">
              {{ str($item->deskripsi_penanganan)->limit(160) }}
            </p>
            <a href="{{ route('penanganan.show', $item->slug) }}" class="mt-4 self-start bg-blue-700 hover:bg-blue-800 text-white text-xs md:text-sm px-4 py-2 rounded-full transition">
              Lihat Aktivitas
            </a>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- 🔹 Rekomendasi Konsultan Dinamis --}}
  <div class="max-w-6xl mx-auto mt-16">
    <h3 class="text-lg md:text-xl font-bold text-gray-800 text-center mb-2">Rekomendasi Konsultan</h3>
    <p class="text-sm text-gray-600 text-center mb-8">
      Jika merasa kondisimu belum membaik, cobalah untuk berkonsultasi dengan ahli.
    </p>

    @if($konsultans->isEmpty())
      <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-4 max-w-3xl mx-auto text-sm text-center">
        Belum ada konsultan tersedia saat ini. Silakan kembali nanti.
      </div>
    @else
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($konsultans as $konsultan)
          <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all p-5 md:p-6 flex flex-col">
            <img src="{{ $konsultan->foto ? asset($konsultan->foto) : asset('consul1.png') }}"
                alt="{{ $konsultan->nama_konsultan }}"
                class="rounded-2xl mb-4 object-cover h-44 md:h-48 w-full">

            <h5 class="font-bold text-base md:text-lg mb-1 text-gray-800">{{ $konsultan->nama_konsultan }}</h5>
            <p class="text-xs md:text-sm text-gray-600 mb-2">{{ $konsultan->spesialisasi }}</p>

            <span class="inline-block mb-2 px-3 py-1 bg-gray-100 text-gray-700 text-[11px] md:text-xs rounded-full">
              {{ $konsultan->pengalaman }} Tahun Pengalaman
            </span>

            <div class="flex items-center justify-between text-xs md:text-sm text-gray-600 mb-4">
              <span>Rp {{ number_format($konsultan->harga,0,',','.') }} / 2 Sesi</span>
              <span class="flex items-center gap-1">
                ⭐ {{ number_format($konsultan->rating,1) }}
              </span>
            </div>

            <a href="{{ route('konsultan.detail', $konsultan->id) }}"
              class="mt-auto self-start bg-blue-700 hover:bg-blue-800 text-white text-xs md:text-sm px-4 py-2 rounded-full transition">
              Hubungi Sekarang
            </a>
          </div>
        @endforeach
      </div>
    @endif

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
