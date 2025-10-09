@extends('layouts.dashboard')
@section('title','Hasil DASS-21')
@section('content')
<h1 class="text-xl font-semibold mb-4">Hasil DASS-21</h1>
@if($session->overall_risk)
    <div class="mb-6 p-6 rounded-lg shadow text-sm
        @if($session->overall_risk === 'High Risk') bg-red-100 text-red-800
        @elseif(str_contains($session->overall_risk,'Moderate')) bg-yellow-100 text-yellow-800
        @elseif($session->overall_risk === 'Mild') bg-amber-100 text-amber-800
        @else bg-green-100 text-green-800 @endif">
        <h2 class="text-2xl font-bold mb-1">{{ $session->overall_risk }}</h2>
        <p>{{ $session->overall_risk_note }}</p>
        <p class="mt-2 text-xs opacity-70">Label ringkasan ini bersifat heuristik (screening) dan bukan diagnosis klinis.</p>
    </div>
@endif
<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="p-4 bg-white rounded shadow">
        <h2 class="font-semibold">Depresi</h2>
        <p>Skor: {{ $session->depresi_skor }} ({{ $session->depresi_kelas }})</p>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <h2 class="font-semibold">Anxiety</h2>
        <p>Skor: {{ $session->anxiety_skor }} ({{ $session->anxiety_kelas }})</p>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <h2 class="font-semibold">Stress</h2>
        <p>Skor: {{ $session->stres_skor }} ({{ $session->stres_kelas }})</p>
    </div>
</div>
<h2 class="font-semibold mb-2">Ringkasan</h2>
<p class="mb-6">{{ $session->hasil_kelas }}</p>
@if(isset($penanganan) && $penanganan->count())
<h2 class="font-semibold mb-2">Rekomendasi Penanganan Awal</h2>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @foreach($penanganan as $p)
        <a href="{{ route('penanganan.show',$p->slug) }}" class="bg-white rounded shadow p-4 flex flex-col hover:ring-2 ring-indigo-200 transition">
            @if($p->cover_path)
                <img src="{{ asset('storage/'.$p->cover_path) }}" class="h-32 w-full object-cover rounded mb-3" alt="{{ $p->nama_penanganan }}">
            @endif
            <h3 class="font-semibold text-lg mb-1">{{ $p->nama_penanganan }}</h3>
            @if(!empty($p->kelompok))
                <p class="text-xs mb-2 text-gray-500">Kelompok: {{ ucfirst($p->kelompok) }}</p>
            @endif
            <p class="text-sm line-clamp-3 mb-3">{{ Str::limit($p->deskripsi_penanganan,120) }}</p>
            <span class="mt-auto inline-flex items-center justify-center bg-indigo-600 text-white text-sm px-3 py-2 rounded">Lihat Detail</span>
        </a>
    @endforeach
</div>
@endif
<h2 class="font-semibold mb-2">Jawaban</h2>
<div class="space-y-2 mb-8">
    @foreach($session->responses->sortBy(fn($r)=>$r->item->urutan) as $r)
        <div class="p-2 bg-gray-50 border rounded text-sm">
            <span class="font-medium">{{ $r->item->urutan }}.</span>
            {{ $r->item->pernyataan }}
            <span class="ml-2 text-indigo-600 font-semibold">({{ $r->nilai }})</span>
        </div>
    @endforeach
</div>
<div class="mt-4 flex gap-3">
    <form action="{{ route('dass21.start') }}" method="POST">@csrf
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Tes Ulang</button>
    </form>
    <a href="{{ route('dass21.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Kembali</a>
</div>
@endsection