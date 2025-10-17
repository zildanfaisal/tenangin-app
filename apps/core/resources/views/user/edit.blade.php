@extends('layouts.dashboard')
@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] flex justify-center py-6 px-4 sm:px-6">
  <div class="bg-white w-full max-w-5xl rounded-3xl shadow-lg p-6 sm:p-10 text-gray-800">

    {{-- 🔹 Foto Profil --}}
    <div class="flex flex-col items-center mb-8 sm:mb-10 text-center">
      <div class="relative">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128"
             class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-blue-100 shadow-md object-cover"
             alt="{{ $user->name }}">
      </div>
      <p class="mt-3 text-sm text-gray-500">Foto profil otomatis dari nama kamu</p>
    </div>

    {{-- 🔹 Form Edit Profil --}}
    <form action="{{ route('user.update') }}" method="POST" class="space-y-8">
      @csrf
      @method('PATCH')

      {{-- Grid responsif --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">

        {{-- 🔸 Kolom Kiri --}}
        <div class="space-y-5">
          {{-- Nama --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition text-sm sm:text-base">
          </div>

          {{-- Jenis Kelamin --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Jenis Kelamin</label>
            <select name="jenis_kelamin"
              class="w-full bg-blue-50 border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition text-sm sm:text-base">
              <option value="laki-laki" {{ $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
              <option value="perempuan" {{ $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
          </div>

          {{-- Usia --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Usia (Tahun)</label>
            <input type="number" name="usia" value="{{ old('usia', $user->usia) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition text-sm sm:text-base"
              min="10" max="100">
          </div>

          {{-- Kesibukan --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Kesibukan</label>
            <select name="kesibukan"
              class="w-full bg-blue-50 border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition text-sm sm:text-base">
              @foreach (['mahasiswa', 'siswa', 'karyawan', 'fresh graduate', 'profesional', 'wiraswasta', 'wirausaha'] as $job)
                <option value="{{ $job }}" {{ $user->kesibukan == $job ? 'selected' : '' }}>
                  {{ ucfirst($job) }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- 🔸 Kolom Kanan --}}
        <div class="space-y-5">
          {{-- Email --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition text-sm sm:text-base">
          </div>

          {{-- Nomor HP --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Nomor HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition text-sm sm:text-base"
              placeholder="081234567890">
          </div>

          {{-- Koin --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Koin</label>
            <input type="text" readonly value="{{ $user->koin }}"
              class="w-full bg-gray-100 text-gray-600 border border-gray-200 rounded-xl px-4 py-2 shadow-sm cursor-not-allowed text-sm sm:text-base">
          </div>

          {{-- Tanggal Bergabung --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700 text-sm sm:text-base">Tanggal Bergabung</label>
            <input type="text" readonly value="{{ $user->created_at->translatedFormat('d F Y') }}"
              class="w-full bg-gray-100 text-gray-600 border border-gray-200 rounded-xl px-4 py-2 shadow-sm cursor-not-allowed text-sm sm:text-base">
          </div>
        </div>
      </div>

      {{-- 🔹 Tombol --}}
      <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-6">
        <a href="{{ route('user.index') }}"
          class="w-full sm:w-auto px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg shadow-sm transition text-center">
          Batal
        </a>
        <button type="submit"
          class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
