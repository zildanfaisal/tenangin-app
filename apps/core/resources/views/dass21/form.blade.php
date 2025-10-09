@extends('layouts.dashboard')
@section('title','DASS-21')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] flex flex-col">

  {{-- Banner --}}
  <div class="relative w-full h-32 md:h-36 overflow-hidden shadow-sm">
    <img src="{{ asset('ban.png') }}" alt="Banner DASS-21" class="absolute inset-0 w-full h-full object-cover">
  </div>

  {{-- Konten utama --}}
  <div class="flex-1 px-6 py-10">
    <div class="w-full bg-white rounded-2xl shadow-md p-6 md:p-10">

      {{-- Header & progress --}}
      <div class="flex items-center justify-between mb-4">
        <a href="{{ route('dass21.index') }}" class="text-gray-500 hover:text-indigo-600 flex items-center gap-1 text-sm font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
          Asesmen
        </a>
        <p class="text-sm text-gray-600"><span class="font-semibold">{{ $current ?? 1 }}</span>/21</p>
      </div>

      {{-- Progress bar --}}
      <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
        <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300"
             style="width: {{ (($current ?? 1) / 21) * 100 }}%"></div>
      </div>

      {{-- Soal --}}
      <form method="POST" action="{{ route('dass21.next', $session->id) }}">
        @csrf
        @php $item = $currentItem ?? $items[0]; @endphp

        <div class="mb-10">
          <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-6 leading-relaxed">
            Dalam seminggu terakhir, {{ $item->pernyataan }}
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
<<<<<<< HEAD
            @foreach([
              0 => 'Tidak sesuai dengan saya sama sekali',
              1 => 'Sesuai dengan saya sampai taraf tertentu, atau kadang-kadang',
              2 => 'Cukup sesuai dengan saya, atau sering kali',
              3 => 'Sangat sesuai dengan saya, atau hampir sepanjang waktu'
            ] as $val => $label)
            <label class="flex items-center justify-center border border-gray-200 rounded-xl py-4 px-6 cursor-pointer bg-gray-50 hover:bg-blue-50 transition text-center">
              <input type="radio"
                     name="responses[{{ $item->id }}]"
                     value="{{ $val }}"
                     class="accent-blue-600 mr-3 hidden peer"
                     @checked(isset($existing[$item->id]) && (int)$existing[$item->id] === $val)
                     required>
              <span class="text-sm md:text-base text-gray-700 peer-checked:text-blue-700 font-medium">
                {{ $val }} - {{ $label }}
              </span>
            </label>
=======
            @foreach([0 => 'Tidak Pernah', 1 => 'Kadang', 2 => 'Sering', 3 => 'Sangat Sering'] as $val => $label)
              <label class="flex items-center justify-center border border-gray-200 rounded-xl py-4 px-6 cursor-pointer bg-gray-50 hover:bg-blue-50 transition text-center">
                <input type="radio"
                      name="responses[{{ $item->id }}]"
                      value="{{ $val }}"
                      class="accent-blue-600 mr-3 hidden peer"
                      @checked(isset($existing[$item->id]) && (int)$existing[$item->id] === $val)
                      required>
                <span class="text-sm md:text-base text-gray-700 peer-checked:text-blue-700 font-medium">
                  {{ $val }} - {{ $label }}
                </span>
              </label>
>>>>>>> FE
            @endforeach
          </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end mt-8">
          <button type="submit"
                  class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
            {{ ($current ?? 1) < 21 ? 'Selanjutnya' : 'Selesai' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
