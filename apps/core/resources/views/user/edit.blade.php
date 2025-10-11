@extends('layouts.dashboard')
@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] flex justify-center py-10 px-6">
  <div class="bg-white w-full max-w-5xl rounded-3xl shadow-lg p-10 text-gray-800">

    {{-- 🔹 Foto Profil --}}
    <div class="flex flex-col items-center mb-10">
      <div class="relative">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128"
             class="w-32 h-32 rounded-full border-4 border-blue-100 shadow-md object-cover"
             alt="{{ $user->name }}">
      </div>
      <p class="mt-3 text-sm text-gray-500">Foto profil otomatis dari nama kamu</p>
    </div>

    {{-- 🔹 Form Edit Profil --}}
    <form action="{{ route('user.update') }}" method="POST" class="space-y-8">
      @csrf
      @method('PATCH')

      {{-- Dua kolom --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- 🔸 Kolom Kiri --}}
        <div class="space-y-5">
          {{-- Nama --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition">
          </div>

          {{-- Jenis Kelamin --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Jenis Kelamin</label>
            <select name="jenis_kelamin"
              class="w-full bg-blue-50 border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition">
              <option value="laki-laki" {{ $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
              <option value="perempuan" {{ $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
          </div>

          {{-- Usia --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Usia (Tahun)</label>
            <input type="number" name="usia" value="{{ old('usia', $user->usia) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition"
              min="10" max="100">
          </div>

          {{-- Kesibukan --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Kesibukan</label>
            <select name="kesibukan"
              class="w-full bg-blue-50 border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition">
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
            <label class="block font-semibold mb-1 text-gray-700">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition">
          </div>

          {{-- Nomor HP --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Nomor HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
              class="w-full bg-blue-50 focus:bg-white border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm transition"
              placeholder="081234567890">
          </div>

          {{-- Koin (readonly) --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Koin</label>
            <input type="text" readonly value="{{ $user->koin }}"
              class="w-full bg-gray-100 text-gray-600 border border-gray-200 rounded-xl px-4 py-2 shadow-sm cursor-not-allowed">
          </div>

          {{-- Tanggal Pembuatan Akun --}}
          <div>
            <label class="block font-semibold mb-1 text-gray-700">Tanggal Bergabung</label>
            <input type="text" readonly value="{{ $user->created_at->translatedFormat('d F Y') }}"
              class="w-full bg-gray-100 text-gray-600 border border-gray-200 rounded-xl px-4 py-2 shadow-sm cursor-not-allowed">
          </div>
        </div>
      </div>

      {{-- 🔹 Tombol --}}
      <div class="flex justify-end gap-4 pt-6">
        <a href="{{ route('user.index') }}"
          class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg shadow-sm transition">
          Batal
        </a>
        <button type="submit"
          class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
