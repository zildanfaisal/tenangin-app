{{-- filepath: apps/core/resources/views/konsultan/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Detail Konsultan')

@section('content')
<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center md:text-left">
        {{ __('Detail Konsultan') }}
    </h2>
    <div class="flex flex-wrap justify-center md:justify-end gap-2">
        @can('manajemen-konsultan')
            <a href="{{ route('konsultan.edit', $konsultan->id) }}" 
               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">
                Edit
            </a>
        @endcan
        <a href="{{ route('konsultan.index') }}" 
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">
            Kembali
        </a>
    </div>
</div>

<div class="py-6 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 sm:p-8">

                <!-- Header Profile -->
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
                    <!-- Foto Konsultan -->
                    <div class="flex-shrink-0">
                        @if($konsultan->foto)
                            <img src="{{ asset($konsultan->foto) }}" 
                                 alt="{{ $konsultan->nama_konsultan }}" 
                                 class="h-28 w-28 sm:h-32 sm:w-32 rounded-full object-cover border-4 border-gray-200 shadow-md mx-auto md:mx-0">
                        @else
                            <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200 shadow-md mx-auto md:mx-0">
                                <svg class="h-14 w-14 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info Dasar -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $konsultan->nama_konsultan }}</h1>
                        <p class="text-lg sm:text-xl text-indigo-600 font-semibold mb-2">{{ $konsultan->spesialisasi }}</p>
                        <div class="flex justify-center md:justify-start items-center text-gray-600 mb-2">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2..." clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ $konsultan->pengalaman }} tahun pengalaman</span>
                        </div>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-3">
                            @if($konsultan->harga)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c..." />
                                    </svg>
                                    Rp {{ number_format($konsultan->harga, 0, ',', '.') }} / sesi
                                </div>
                            @endif

                            @if($konsultan->rating)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c..." />
                                    </svg>
                                    {{ $konsultan->rating }}/5
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        @if($konsultan->deskripsi)
                            <div class="bg-gray-50 rounded-lg p-5 sm:p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0..." />
                                    </svg>
                                    Tentang Konsultan
                                </h3>
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm sm:text-base">{{ $konsultan->deskripsi }}</p>
                            </div>
                        @endif

                        @if($konsultan->jadwal_praktik)
                            <div class="bg-blue-50 rounded-lg p-5 sm:p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 2a1 1 0..." />
                                    </svg>
                                    Jadwal Praktik
                                </h3>
                                <p class="text-gray-700 whitespace-pre-line text-sm sm:text-base">{{ $konsultan->jadwal_praktik }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div class="bg-green-50 rounded-lg p-5 sm:p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4..." />
                                </svg>
                                Informasi Detail
                            </h3>
                            <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                                <div class="flex justify-between"><span>Spesialisasi:</span><span class="font-medium">{{ $konsultan->spesialisasi }}</span></div>
                                <div class="flex justify-between"><span>Pengalaman:</span><span class="font-medium">{{ $konsultan->pengalaman }} tahun</span></div>
                                @if($konsultan->harga)
                                    <div class="flex justify-between"><span>Tarif:</span><span class="font-medium text-green-600">Rp {{ number_format($konsultan->harga, 0, ',', '.') }}</span></div>
                                @endif
                                @if($konsultan->rating)
                                    <div class="flex justify-between"><span>Rating:</span><span class="font-medium text-yellow-600">{{ $konsultan->rating }}/5 ⭐</span></div>
                                @endif
                                <div class="flex justify-between"><span>Bergabung sejak:</span><span class="font-medium">{{ $konsultan->created_at->format('d M Y') }}</span></div>
                                <div class="flex justify-between"><span>Terakhir diperbarui:</span><span class="font-medium">{{ $konsultan->updated_at->format('d M Y H:i') }}</span></div>
                            </div>
                        </div>

                        <div class="bg-indigo-50 rounded-lg p-5 sm:p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 10c..." />
                                </svg>
                                Konsultasi
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">Hubungi konsultan untuk mendapatkan bantuan profesional</p>
                            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-lg transition">
                                Mulai Konsultasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @can('manajemen-konsultan')
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                        <a href="{{ route('konsultan.edit', $konsultan->id) }}" 
                           class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586..." />
                            </svg>
                            Edit Konsultan
                        </a>

                        <form action="{{ route('konsultan.destroy', $konsultan->id) }}" 
                              method="POST" 
                              class="inline w-full sm:w-auto"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus konsultan {{ $konsultan->nama_konsultan }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0..." />
                                </svg>
                                Hapus Konsultan
                            </button>
                        </form>

                        <a href="{{ route('konsultan.index') }}" 
                           class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.707 16.707..." />
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
