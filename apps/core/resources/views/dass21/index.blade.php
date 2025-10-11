@extends('layouts.dashboard')
@section('title','Riwayat DASS-21')

@section('content')
{{-- ================= HERO SECTION ================= --}}
<div class="relative rounded-2xl overflow-hidden mb-10">
  <img src="{{ asset('dass21.png') }}" alt="Hero DASS-21" class="w-full h-72 object-cover">
  <div class="absolute inset-0 flex items-center justify-start px-10 md:px-16">
    <div class="max-w-md text-white">
    <h2 class="text-2xl md:text-3xl font-semibold mb-2 drop-shadow-sm">
        Gimana kondisi mu hari ini?
    </h2>
    <p class="text-sm md:text-base opacity-90 mb-6 leading-relaxed">
        Cek kondisi emosi hari ini (Dass-21) dan juga curhat terkait apa yang kamu rasakan hari ini
        dengan tambahan bantuan AI kami untuk penjelasan yang lebih luas.
    </p>

    <a href="{{ route('dass21.intro') }}"
        class="w-full md:w-auto px-8 py-2 bg-white text-indigo-600 font-medium rounded-full shadow-sm hover:bg-indigo-50 transition">
        Lakukan Asesmen
    </a>

    {{-- tambahkan margin top di sini --}}
    <div class="mt-4 text-xs text-white/80 flex items-center gap-1">
        <span>Kesempatan: <strong>2</strong></span>
        <span class="mx-2">|</span>
        <a href="{{ route('premium.index') }}" class="text-white font-semibold hover:underline">Upgrade Kesempatan</a>
    </div>
    </div>

  </div>
</div>

{{-- ================= INFO DASS-21 ================= --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-10">
  <h3 class="font-semibold text-blue-900 mb-1">Dass-21</h3>
  <p class="text-sm text-gray-700 leading-relaxed">
    DASS-21 adalah kuisioner laporan diri yang mengukur tingkat depresi, kecemasan, dan stres
    dalam satu minggu terakhir, terdiri dari 21 pernyataan dengan 7 pertanyaan untuk setiap aspek emosional.
    Kuisioner ini dirancang untuk membedakan ketiga kondisi tersebut dan dinilai menggunakan skala empat poin,
    dengan hasil akhir menunjukkan tingkat keparahan yang berbeda untuk masing-masing skala.
  </p>
</div>

{{-- ================= RIWAYAT ASESMEN ================= --}}
<div id="riwayat-asesmen" class="mb-12">
  <div class="flex items-center justify-between mb-3">
    <h3 class="text-lg font-semibold text-gray-800">Riwayat Asesmen</h3>
    <a href="#" class="text-sm text-indigo-600 hover:underline">Selengkapnya</a>
  </div>

  @if($sessions->count())
  <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-100">
    <table class="w-full text-sm text-gray-700">
      <thead class="bg-gray-100 text-gray-800">
        <tr>
          <th class="p-3 text-left">No</th>
          <th class="p-3 text-left">Tanggal</th>
          <th class="p-3 text-left">Pukul</th>
          <th class="p-3 text-left">Hasil Emosi</th>
          <th class="p-3 text-left">Hasil Analisis</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sessions as $i => $s)
        <tr class="border-t hover:bg-gray-50">
          <td class="p-3">{{ $i+1 }}</td>
          <td class="p-3">{{ $s->completed_at? $s->completed_at->format('d F Y'):'(Draft)' }}</td>
          <td class="p-3">{{ $s->completed_at? $s->completed_at->format('H:i'):'-' }}</td>
          <td class="p-3 font-medium text-red-500">{{ $s->hasil_kelas ?? 'Burnout' }}</td>
          <td class="p-3">
            <a href="{{ route('dass21.result',$s->id) }}" class="text-indigo-600 hover:underline">
              Lihat Analisis
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <p class="text-gray-600">Belum ada riwayat asesmen.</p>
  @endif
</div>

{{-- ================= KONTEN PENANGANAN AWAL ================= --}}
<div x-data="{ activeTab: 'All' }" x-cloak>
  @php
      $kategoriList = $penanganan->pluck('kelompok')->unique();
  @endphp

  {{-- Tabs --}}
  <div class="flex flex-wrap gap-3 mb-8 border-b border-gray-200">
    {{-- Tab All --}}
    <button
      @click="activeTab = 'All'"
      :class="activeTab === 'All' 
        ? 'bg-white border border-b-0 border-gray-200 text-indigo-600 shadow-sm' 
        : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50'"
      class="px-4 py-2 text-sm font-medium rounded-t-lg transition">
      All
    </button>

    {{-- Tab per kategori --}}
    @foreach($kategoriList as $kategori)
      <button
        @click="activeTab = '{{ $kategori }}'"
        :class="activeTab === '{{ $kategori }}' 
          ? 'bg-white border border-b-0 border-gray-200 text-indigo-600 shadow-sm' 
          : 'text-gray-500 hover:text-indigo-600 hover:bg-gray-50'"
        class="px-4 py-2 text-sm font-medium rounded-t-lg transition">
        {{ ucfirst($kategori) }}
      </button>
    @endforeach
  </div>

  {{-- Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($penanganan as $p)
      <div 
        x-show="activeTab === 'All' || activeTab === '{{ $p->kelompok }}'"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        x-cloak
        class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition p-4 flex flex-col">
        <img src="{{ $p->cover_path ? asset('storage/'.$p->cover_path) : asset('dass.png') }}" class="rounded-lg mb-3 aspect-video object-cover">
        <h4 class="font-semibold text-gray-800 mb-1">{{ $p->nama_penanganan }}</h4>
        <p class="text-xs text-gray-500 mb-1">
          Penanganan {{ ucfirst($p->kelompok) }} • {{ $p->steps()->published()->count() }} Tahapan
        </p>
        <p class="text-sm text-gray-600 flex-grow leading-relaxed">
          {{ str($p->deskripsi_penanganan)->limit(120) }}
        </p>
        <a href="{{ route('penanganan.show', $p->slug) }}" class="mt-4 px-4 py-2 bg-gray-100 hover:bg-indigo-100 text-indigo-600 text-sm font-medium rounded-lg transition">
          Lihat Aktivitas
        </a>
      </div>
    @endforeach
  </div>
</div>
@endsection
