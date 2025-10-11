@extends('layouts.dashboard')
@section('title','Pembayaran Sukses')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f4f6fb]">
    <div class="bg-white p-8 rounded-2xl shadow text-center max-w-md">
        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h2 class="text-2xl font-bold mb-2">Pembayaran Berhasil</h2>
        <p class="text-gray-500 mb-6">Terima kasih! Pembayaran telah dikonfirmasi melalui QR scan.</p>
        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg">Kembali</a>
    </div>
</div>
@endsection
