@extends('layouts.dashboard')
@section('title','DASS-21')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] flex flex-col">

  {{-- Banner --}}
  <div class="w-full overflow-hidden">
    <img 
      src="{{ asset('ban.png') }}" 
      alt="Banner DASS-21" 
      class="w-full h-auto block"
    >
  </div>

  {{-- Konten utama --}}
  <div class="flex-1 px-4 sm:px-6 py-6 sm:py-10">
    <div class="w-full bg-white rounded-2xl shadow-md p-4 sm:p-6 md:p-10">

      {{-- Header & progress --}}
      <div class="flex items-center justify-between mb-4">
        @php
          $prevItem = null;
          if (($current ?? 1) > 1) {
            $prevItem = $items[$current-2] ?? null;
          }
        @endphp

        {{-- Tombol sebelumnya --}}
        @if($prevItem)
          <a href="{{ route('dass21.form', ['id' => $session->id, 'item' => $prevItem->id]) }}"
             class="flex items-center gap-1 text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="2" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Sebelumnya
          </a>
        @else
          <span class="text-gray-400 flex items-center gap-1 text-xs sm:text-sm font-medium cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-50">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Sebelumnya
          </span>
        @endif

        {{-- Counter --}}
        <p class="text-xs sm:text-sm text-gray-600">
          <span class="font-semibold">{{ $current ?? 1 }}</span>/21
        </p>
      </div>

      {{-- Progress bar --}}
      <div class="w-full bg-gray-200 rounded-full h-2 mb-6 sm:mb-8">
        <div class="bg-blue-500 h-2 rounded-full transition-all duration-300"
             style="width: {{ (($current ?? 1) / 21) * 100 }}%"></div>
      </div>

      {{-- Soal --}}
      <form method="POST" action="{{ route('dass21.next', $session->id) }}" id="dassForm">
        @csrf
        @php $item = $currentItem ?? $items[0]; @endphp

        <div class="mb-8 sm:mb-10">
          <h2 class="text-base sm:text-lg md:text-xl font-semibold text-gray-800 mb-4 sm:mb-6 leading-relaxed">
            Dalam seminggu terakhir, {{ $item->pernyataan }}
          </h2>

          {{-- Pilihan jawaban --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach([0 => 'Tidak Pernah', 1 => 'Kadang', 2 => 'Sering', 3 => 'Sangat Sering'] as $val => $label)
              <label
                class="relative flex items-center justify-center border border-gray-200 rounded-xl
                       py-3 sm:py-4 px-4 sm:px-6 cursor-pointer bg-gray-50 text-gray-700
                       hover:bg-blue-100 hover:border-blue-400 transition text-center
                       has-[input:checked]:bg-blue-600 has-[input:checked]:border-blue-600 has-[input:checked]:text-white">

                <input type="radio"
                      name="responses[{{ $item->id }}]"
                      value="{{ $val }}"
                      class="absolute inset-0 opacity-0 cursor-pointer"
                      @checked(isset($existing[$item->id]) && (int)$existing[$item->id] === $val)
                      required>

                <span class="text-sm sm:text-base font-medium transition-colors duration-150">
                  {{ $val }} - {{ $label }}
                </span>
              </label>
            @endforeach
          </div>
        </div>

        {{-- Tombol navigasi --}}
        <div class="flex justify-between items-center mt-6 sm:mt-8">

          {{-- Tombol Back --}}
          @if($prevItem)
            <a href="{{ route('dass21.form', ['id' => $session->id, 'item' => $prevItem->id]) }}"
               class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gray-200 text-gray-800 text-sm sm:text-base font-semibold rounded-lg hover:bg-gray-300 transition">
              Kembali
            </a>
          @else
            <button type="button"
                    disabled
                    class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gray-100 text-gray-400 text-sm sm:text-base font-semibold rounded-lg cursor-not-allowed">
              Kembali
            </button>
          @endif

          {{-- Tombol Next / Selesai --}}
          @if(($current ?? 1) < 21)
            <button type="submit"
                    class="px-6 sm:px-8 py-2.5 sm:py-3 bg-blue-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-blue-700 transition">
              Selanjutnya
            </button>
          @else
            <button type="submit"
                    class="px-6 sm:px-8 py-2.5 sm:py-3 bg-green-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-green-700 transition">
              Selesai
            </button>
          @endif

        </div>
      </form>
    </div>
  </div>
</div>

{{-- Validasi wajib pilih sebelum submit --}}
<script>
document.getElementById('dassForm').addEventListener('submit', function (e) {
  const selected = document.querySelector('input[type="radio"]:checked');
  if (!selected) {
    e.preventDefault();
    alert('Silakan pilih salah satu jawaban sebelum melanjutkan.');
  }
});
</script>
@endsection
