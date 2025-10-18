@extends('layouts.dashboard')
@section('title', 'Profil Pengguna')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] pb-20">

  {{-- 🔹 Header Profil & Poin --}}
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 p-4 sm:p-6">

    <!-- 🔹 Card Profil -->
    <div class="bg-white shadow-md rounded-3xl border border-gray-100 p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 hover:shadow-lg transition-all duration-300">

      <!-- Avatar -->
      <div class="flex-shrink-0">
        <img id="profile-preview"
                src="{{ $user->profile_photo
                    ? asset('storage/'.$user->profile_photo)
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-blue-100 shadow-md object-cover">
      </div>

      <!-- Info Profil -->
      <div class="flex-1 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">{{ $user->name }}</h3>

        <!-- Grid Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-gray-700 text-sm">
          <p><span class="text-gray-500">Email:</span> <span class="font-semibold text-blue-700">{{ $user->email }}</span></p>
          <p><span class="text-gray-500">Nomor HP:</span> <span class="font-semibold text-blue-700">{{ $user->no_hp }}</span></p>
          <p><span class="text-gray-500">Jenis Kelamin:</span> <span class="font-semibold text-blue-700 capitalize">{{ $user->jenis_kelamin }}</span></p>
          <p><span class="text-gray-500">Kesibukan:</span> <span class="font-semibold text-blue-700 capitalize">{{ $user->kesibukan }}</span></p>
          <p><span class="text-gray-500">Usia:</span> <span class="font-semibold text-blue-700">{{ $user->usia }} tahun</span></p>
        </div>

        <div class="mt-6 flex justify-center sm:justify-start">
          <a href="{{ route('user.edit') }}"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 sm:px-6 py-2.5 rounded-md shadow-md transition-all duration-200">
            <i class="fa-solid fa-user-pen"></i>
            Edit Profil
          </a>
        </div>
      </div>
    </div>

    <!-- 🔹 Kartu Poin -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-3xl shadow-md flex flex-col justify-between text-center sm:text-left">
      <div class="relative z-10 p-6 sm:p-8 flex flex-col justify-center h-full">
        <p class="text-sm opacity-80 mb-1 tracking-wide">Poin Kamu Saat Ini</p>
        <h2 class="text-5xl sm:text-6xl font-extrabold drop-shadow-sm">{{ $user->koin }}</h2>
        <p class="text-xs opacity-80 mt-2">Gunakan poinmu untuk menukar hadiah menarik 🎁</p>
      </div>

      <!-- Gambar Nai kanan -->
      <img src="{{ asset('nai2.png') }}" alt="Nai"
           class="absolute right-0 bottom-0 w-[180px] sm:w-[220px] md:w-[280px] object-contain opacity-95 select-none pointer-events-none">
    </div>
  </div>

  {{-- 🔹 Pilihan Hadiah --}}
  <div class="max-w-6xl mx-auto mt-10 px-4 sm:px-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center sm:text-left">Pilihan Hadiah</h2>
    <p class="text-gray-600 mb-6 text-center sm:text-left">Tukarkan poin dengan hadiah yang kamu inginkan</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($rewards as $reward)
      <div class="bg-white shadow-sm hover:shadow-lg border border-gray-100 rounded-2xl p-5 flex flex-col items-center justify-between transition-all duration-300 text-center">
        <img src="{{ asset($reward['image']) }}" alt="{{ $reward['name'] }}" class="h-24 sm:h-28 object-contain mb-4">
        <h4 class="font-semibold text-gray-800 mb-1">{{ $reward['name'] }}</h4>
        <p class="text-sm text-gray-600 mb-4">{{ $reward['points'] }} Poin</p>
        <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-md shadow-sm transition w-full sm:w-auto">
          Tukar
        </button>
      </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
