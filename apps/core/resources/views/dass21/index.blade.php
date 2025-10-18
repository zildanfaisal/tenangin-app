@extends('layouts.dashboard')
@section('title','Riwayat DASS-21')

@section('content')

{{-- ================= HERO SECTION ================= --}}
<div class="relative rounded-2xl overflow-hidden mb-8">
  <img src="{{ asset('dass21.png') }}" alt="Hero DASS-21" class="w-full h-48 sm:h-72 object-cover">
  <div class="absolute inset-0 flex items-center justify-start px-4 sm:px-8 md:px-12">
    <div class="text-white max-w-[95%] sm:max-w-md">
      <h2 class="text-lg sm:text-2xl md:text-3xl font-semibold mb-2 drop-shadow">
        Gimana kondisi mu hari ini?
      </h2>
      <p class="text-xs sm:text-sm md:text-base opacity-90 mb-4 leading-relaxed">
        Cek kondisi emosi hari ini (Dass-21) dan juga curhat terkait apa yang kamu rasakan hari ini,
        dengan tambahan bantuan AI kami untuk penjelasan yang lebih luas.
      </p>

      <a href="{{ route('dass21.intro') }}"
         class="inline-block px-5 py-2 bg-white text-indigo-600 text-sm sm:text-base font-medium rounded-full shadow hover:bg-indigo-50 transition">
         Lakukan Asesmen
      </a>

      <div class="mt-3 text-[11px] sm:text-xs text-white/80 flex flex-wrap items-center gap-2">
        <span>Kesempatan: <strong>2</strong></span>
        <span class="hidden sm:inline">|</span>
        <a href="{{ route('premium.index') }}" class="text-white font-semibold hover:underline">
          Upgrade Kesempatan
        </a>
      </div>
    </div>
  </div>
</div>

{{-- ================= INFO DASS-21 ================= --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 sm:p-6 mb-8">
  <h3 class="font-semibold text-blue-900 mb-1 text-base sm:text-lg">DASS-21</h3>
  <p class="text-xs sm:text-sm text-gray-700 leading-relaxed">
    DASS-21 adalah kuisioner laporan diri yang mengukur tingkat depresi, kecemasan, dan stres
    dalam satu minggu terakhir, terdiri dari 21 pernyataan dengan 7 pertanyaan untuk setiap aspek emosional.
    Kuisioner ini dirancang untuk membedakan ketiga kondisi tersebut dan dinilai menggunakan skala empat poin,
    dengan hasil akhir menunjukkan tingkat keparahan yang berbeda untuk masing-masing skala.
  </p>
</div>

{{-- ================= RIWAYAT ASESMEN ================= --}}
<div id="riwayat-asesmen" class="mb-10">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 gap-2">
    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Riwayat Asesmen</h3>
    <a href="#" class="text-xs sm:text-sm text-indigo-600 hover:underline">Selengkapnya</a>
  </div>

  @if($sessions->count())
  <div class="w-full overflow-x-auto rounded-lg border border-gray-100 bg-white shadow">
    <table class="min-w-full text-xs sm:text-sm text-gray-700">
      <thead class="bg-blue-600 text-white">
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
          <td class="p-3">
            {{ $s->suara_created_at ? \Carbon\Carbon::parse($s->suara_created_at)->translatedFormat('d F Y') : '-' }}
            </td>
            <td class="p-3">
            {{ $s->suara_created_at
                ? \Carbon\Carbon::parse($s->suara_created_at)
                    ->setTimezone('Asia/Jakarta')
                    ->format('H:i') . ' WIB'
                : '-' }}
            </td>

          <td class="p-3 font-semibold leading-relaxed">
            <div>Depresi: Risiko {{ $s->depresi_kelas ?? 'depresi' }}</div>
            <div>Anxiety: Risiko {{ $s->anxiety_kelas ?? 'anxiety' }}</div>
            <div>Stres: Risiko {{ $s->stres_kelas ?? 'stres' }}</div>
          </td>
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
  <p class="text-gray-600 text-sm sm:text-base">Belum ada riwayat asesmen.</p>
  @endif
</div>

{{-- ================= PENANGANAN AWAL ================= --}}
<div x-data="{ activeTab: 'All' }" x-cloak>
  @php $kategoriList = $penanganan->pluck('kelompok')->flatten()->unique()->values(); @endphp

  {{-- Tabs --}}
  <div class="flex flex-wrap gap-2 sm:gap-3 mb-6 border-b border-gray-200">
    <button @click="activeTab = 'All'"
      :class="activeTab==='All'?'bg-white border border-b-0 border-gray-200 text-indigo-600 shadow-sm':'text-gray-500 hover:text-indigo-600 hover:bg-gray-50'"
      class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition">
      All
    </button>

    @foreach($kategoriList as $kategori)
    <button @click="activeTab='{{ $kategori }}'"
      :class="activeTab==='{{ $kategori }}'?'bg-white border border-b-0 border-gray-200 text-indigo-600 shadow-sm':'text-gray-500 hover:text-indigo-600 hover:bg-gray-50'"
      class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition">
      {{ ucfirst($kategori) }}
    </button>
    @endforeach
  </div>

  {{-- Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    @foreach($penanganan as $p)
      @php $kelompokArr = is_array($p->kelompok) ? $p->kelompok : [$p->kelompok]; @endphp
      <div
        x-show="activeTab==='All'||{{ json_encode($kelompokArr) }}.includes(activeTab)"
        x-transition
        class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md p-4 flex flex-col">
        <img src="{{ $p->cover_path ? asset('storage/'.$p->cover_path) : asset('dass.png') }}"
             class="rounded-lg mb-3 aspect-video object-cover">
        <h4 class="font-semibold text-gray-800 mb-1 text-sm sm:text-base">{{ $p->nama_penanganan }}</h4>
        <p class="text-[11px] sm:text-xs text-gray-500 mb-1">
          Penanganan {{ is_array($p->kelompok)?implode(', ',array_map('ucfirst',$p->kelompok)):ucfirst($p->kelompok) }}
          • {{ $p->steps()->published()->count() }} Tahapan
        </p>
        <p class="text-xs sm:text-sm text-gray-600 flex-grow leading-relaxed">
          {{ str($p->deskripsi_penanganan)->limit(120) }}
        </p>
        <a href="{{ route('penanganan.show',$p->slug) }}"
           class="mt-4 px-3 sm:px-4 py-2 bg-gray-100 hover:bg-indigo-100 text-indigo-600 text-xs sm:text-sm font-medium rounded-lg transition text-center">
           Lihat Aktivitas
        </a>
      </div>
    @endforeach
  </div>
</div>
@endsection
