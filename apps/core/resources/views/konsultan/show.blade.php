{{-- filepath: apps/core/resources/views/konsultan/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Detail Konsultan')

@section('content')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Konsultan') }}
    </h2>
    <div class="flex space-x-2">
        @can('manajemen-konsultan')
            <a href="{{ route('konsultan.edit', $konsultan->id) }}" 
               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
        @endcan
        <a href="{{ route('konsultan.index') }}" 
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
    </div>
</div>

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Header Profile -->
                <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6 mb-8">
                    <!-- Foto Konsultan -->
                    <div class="flex-shrink-0">
                        @if($konsultan->foto)
                            <img src="{{ asset($konsultan->foto) }}" 
                                 alt="{{ $konsultan->nama_konsultan }}" 
                                 class="h-32 w-32 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200 shadow-lg">
                                <svg class="h-16 w-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info Dasar -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $konsultan->nama_konsultan }}</h1>
                        <p class="text-xl text-indigo-600 font-semibold mb-2">{{ $konsultan->spesialisasi }}</p>
                        <div class="flex items-center text-gray-600 mb-2">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ $konsultan->pengalaman }} tahun pengalaman</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mt-3">
                            @if($konsultan->harga)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    Rp {{ number_format($konsultan->harga, 0, ',', '.') }} / sesi
                                </div>
                            @endif

                            @if($konsultan->rating)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    {{ $konsultan->rating }}/5
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <!-- Deskripsi -->
                        @if($konsultan->deskripsi)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tentang Konsultan
                                </h3>
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $konsultan->deskripsi }}</p>
                            </div>
                        @endif

                        <!-- Jadwal -->
                        @if($konsultan->jadwal_praktik)
                            <div class="bg-blue-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Jadwal Praktik
                                </h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $konsultan->jadwal_praktik }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Statistik & Info -->
                        <div class="bg-green-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informasi Detail
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Spesialisasi:</span>
                                    <span class="font-medium text-gray-900">{{ $konsultan->spesialisasi }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pengalaman:</span>
                                    <span class="font-medium text-gray-900">{{ $konsultan->pengalaman }} tahun</span>
                                </div>
                                @if($konsultan->harga)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tarif konsultasi:</span>
                                        <span class="font-medium text-green-600">Rp {{ number_format($konsultan->harga, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                @if($konsultan->rating)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Rating:</span>
                                        <span class="font-medium text-yellow-600">{{ $konsultan->rating }}/5 ⭐</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bergabung sejak:</span>
                                    <span class="font-medium text-gray-900">{{ $konsultan->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Terakhir diperbarui:</span>
                                    <span class="font-medium text-gray-900">{{ $konsultan->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Konsultasi Actions -->
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                </svg>
                                Konsultasi
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">Hubungi konsultan untuk mendapatkan bantuan profesional</p>
                            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                Mulai Konsultasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @can('manajemen-konsultan')
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('konsultan.edit', $konsultan->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                                Edit Konsultan
                            </a>
                            
                            <form action="{{ route('konsultan.destroy', $konsultan->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus konsultan {{ $konsultan->nama_konsultan }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v4a1 1 0 11-2 0V7zM12 7a1 1 0 112 0v4a1 1 0 11-2 0V7z" clip-rule="evenodd"></path>
                                    </svg>
                                    Hapus Konsultan
                                </button>
                            </form>

                            <a href="{{ route('konsultan.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection