{{-- filepath: apps/core/resources/views/konsultan/edit.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Edit Konsultan')

@section('content')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Konsultan') }}: {{ $konsultan->nama_konsultan }}
    </h2>
</div>

<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('konsultan.update', $konsultan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Preview Foto Saat Ini -->
                        @if($konsultan->foto)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                                <img src="{{ asset($konsultan->foto) }}" 
                                     alt="{{ $konsultan->nama_konsultan }}" 
                                     class="h-20 w-20 rounded-full object-cover">
                            </div>
                        @endif

                        <!-- Nama Konsultan -->
                        <div>
                            <label for="nama_konsultan" class="block text-sm font-medium text-gray-700">Nama Konsultan</label>
                            <input type="text" name="nama_konsultan" id="nama_konsultan" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   value="{{ old('nama_konsultan', $konsultan->nama_konsultan) }}" required>
                            @error('nama_konsultan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Baru -->
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto Baru (Opsional)</label>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah foto</p>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin', $konsultan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $konsultan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $konsultan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Spesialisasi -->
                        <div>
                            <label for="spesialisasi" class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                            <input type="text" name="spesialisasi" id="spesialisasi"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   value="{{ old('spesialisasi', $konsultan->spesialisasi) }}" required>
                            @error('spesialisasi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Pilih Kategori</option>
                                <option value="konselor" {{ old('kategori', $konsultan->kategori) == 'konselor' ? 'selected' : '' }}>Konselor</option>
                                <option value="konsultan" {{ old('kategori', $konsultan->kategori) == 'konsultan' ? 'selected' : '' }}>Konsultan</option>
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pengalaman -->
                        <div>
                            <label for="pengalaman" class="block text-sm font-medium text-gray-700">Pengalaman (tahun)</label>
                            <input type="number" name="pengalaman" id="pengalaman" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   value="{{ old('pengalaman', $konsultan->pengalaman) }}" required>
                            @error('pengalaman')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jadwal Praktik -->
                        <div>
                            <label for="jadwal_praktik" class="block text-sm font-medium text-gray-700">Jadwal Praktik</label>
                            <textarea name="jadwal_praktik" id="jadwal_praktik" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('jadwal_praktik', $konsultan->jadwal_praktik) }}</textarea>
                            @error('jadwal_praktik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga per Sesi</label>
                            <input type="number" name="harga" id="harga" min="0" step="1000"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   value="{{ old('harga', $konsultan->harga) }}">
                            @error('harga')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating (0-5)</label>
                            <input type="number" name="rating" id="rating" min="0" max="5" step="0.1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   value="{{ old('rating', $konsultan->rating) }}">
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ route('konsultan.show', $konsultan->id) }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection