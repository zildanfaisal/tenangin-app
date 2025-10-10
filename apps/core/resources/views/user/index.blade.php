@extends('layouts.dashboard')
@section('title', 'Profil Pengguna')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] pb-20">

  {{-- 🔹 Header Profil & Poin --}}
  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-6 p-6">

    <!-- 🔹 Card Profil Rapi dan Proporsional -->
    <div class="bg-white shadow-md rounded-3xl border border-gray-100 p-8 flex items-center gap-6 hover:shadow-lg transition-all duration-300">

    <!-- Avatar -->
    <div class="flex-shrink-0">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-3xl font-bold text-gray-800 shadow-inner">
        {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
    </div>

    <!-- Info Profil -->
    <div class="flex-1">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $user->name }}</h3>

        <!-- Grid dua kolom -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-gray-700 text-sm">
        <p><span class="text-gray-500">Email:</span> <span class="font-semibold text-blue-700">{{ $user->email }}</span></p>
        <p><span class="text-gray-500">Nomor HP:</span> <span class="font-semibold text-blue-700">{{ $user->no_hp }}</span></p>
        <p><span class="text-gray-500">Jenis Kelamin:</span> <span class="font-semibold text-blue-700 capitalize">{{ $user->jenis_kelamin }}</span></p>
        <p><span class="text-gray-500">Kesibukan:</span> <span class="font-semibold text-blue-700 capitalize">{{ $user->kesibukan }}</span></p>
        <p><span class="text-gray-500">Usia:</span> <span class="font-semibold text-blue-700">{{ $user->usia }} tahun</span></p>
        </div>

        <div class="mt-6">
        <a href="{{ route('user.edit') }}"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-6 py-2.5 rounded-md shadow-md transition-all duration-200">
            <i class="fa-solid fa-user-pen"></i>
            Edit Profil
        </a>

        </div>
    </div>
    </div>



    <!-- Kartu Poin -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-3xl shadow-md flex flex-col justify-between">
      <div class="relative z-10 p-8 flex flex-col justify-center h-full">
        <p class="text-sm opacity-80 mb-1 tracking-wide">Poin Kamu Saat Ini</p>
        <h2 class="text-6xl font-extrabold drop-shadow-sm">{{ $user->koin }}</h2>
        <p class="text-xs opacity-80 mt-2">Gunakan poinmu untuk menukar hadiah menarik 🎁</p>
      </div>

      <!-- Gambar Nai full kanan -->
      <img src="{{ asset('nai2.png') }}" alt="Nai"
           class="absolute right-0 bottom-0 w-[220px] md:w-[280px] object-contain opacity-95 select-none pointer-events-none">
    </div>
  </div>

  {{-- 🔹 Pilihan Hadiah --}}
  <div class="max-w-6xl mx-auto mt-10 px-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Pilihan Hadiah</h2>
    <p class="text-gray-600 mb-6">Tukarkan poin dengan hadiah yang kamu inginkan</p>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($rewards as $reward)
      <div class="bg-white shadow-sm hover:shadow-lg border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-between transition-all duration-300">
        <img src="{{ asset($reward['image']) }}" alt="{{ $reward['name'] }}" class="h-28 object-contain mb-4">
        <h4 class="font-semibold text-gray-800 mb-1 text-center">{{ $reward['name'] }}</h4>
        <p class="text-sm text-gray-600 mb-4">{{ $reward['points'] }} Poin</p>
        <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-md shadow-sm transition">
          Tukar
        </button>
      </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
