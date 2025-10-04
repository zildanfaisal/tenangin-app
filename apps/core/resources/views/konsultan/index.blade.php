@extends('layouts.dashboard')

@section('title', 'Konsultan')

@section('content')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Konsultan') }}
    </h2>
    @can('manajemen-konsultan')
    <a href="{{ route('konsultan.create') }}" 
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Tambah Konsultan
    </a>
    @endcan
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Grid Layout untuk Card -->
        @if($konsultans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($konsultans as $konsultan)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300 cursor-pointer relative group"
                         onclick="window.location.href='{{ route('konsultan.show', $konsultan->id) }}'">
                        <div class="p-6">
                            <!-- Header Card -->
                            <div class="flex items-center mb-4">
                                @if($konsultan->foto)
                                    <img src="{{ asset($konsultan->foto) }}" 
                                         alt="{{ $konsultan->nama_konsultan }}" 
                                         class="h-12 w-12 rounded-full object-cover mr-4">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                        <svg class="h-6 w-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $konsultan->nama_konsultan }}</h3>
                                    <p class="text-sm text-indigo-600">{{ $konsultan->deskripsi }}</p>
                                    <p class="text-sm text-indigo-600">{{ $konsultan->spesialisasi }}</p>
                                </div>
                            </div>

                            <!-- Content Card -->
                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $konsultan->pengalaman }} tahun pengalaman</span>
                                </div>
                                
                                @if($konsultan->jadwal_praktik)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="truncate">{{ $konsultan->jadwal_praktik }}</span>
                                    </div>
                                @endif

                                @if($konsultan->harga)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium text-green-600">{{ $konsultan->harga }}</span>
                                    </div>
                                @endif

                                @if($konsultan->rating)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="h-4 w-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span>{{ $konsultan->rating }}/5.0</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons - hanya tampil saat hover dan untuk admin -->
                            @can('manajemen-konsultan')
                                <div class="mt-4 pt-4 border-t border-gray-200 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('konsultan.edit', $konsultan->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                                           onclick="event.stopPropagation()">
                                            Edit
                                        </a>
                                        <form action="{{ route('konsultan.destroy', $konsultan->id) }}" 
                                              method="POST" class="inline"
                                              onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus konsultan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium"
                                                    onclick="event.stopPropagation()">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endcan

                            <!-- Click indicator -->
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $konsultans->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada konsultan</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan konsultan baru.</p>
                    @can('manajemen-konsultan')
                        <div class="mt-6">
                            <a href="{{ route('konsultan.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Tambah Konsultan
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
