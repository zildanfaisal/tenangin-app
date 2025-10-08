@extends('layouts.dashboard')
@section('title','Steps: '.$penanganan->nama_penanganan)
@section('content')
<h1 class="text-xl font-semibold mb-4">Steps: {{ $penanganan->nama_penanganan }}</h1>

<div class="flex justify-between mb-4">
    <a href="{{ route('admin.penanganan.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">&larr; Kembali</a>
    <a href="{{ route('admin.penanganan.steps.create',$penanganan) }}" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Tambah Step</a>
</div>

@if(session('success'))<div class="mb-3 text-green-700 text-sm">{{ session('success') }}</div>@endif

<form method="POST" action="{{ route('admin.penanganan.steps.reorder',$penanganan) }}" class="mb-4 border rounded p-3 bg-gray-50">
    @csrf
    <p class="text-sm mb-2 font-medium">Ubah Urutan (isi angka lalu Simpan)</p>
    <div class="space-y-2">
        @forelse($steps as $s)
            <div class="flex items-center gap-3 bg-white border rounded p-2">
                <input type="hidden" name="orders[{{ $loop->index }}][id]" value="{{ $s->id }}">
                <div class="w-16">
                    <input name="orders[{{ $loop->index }}][urutan]" type="number" class="w-full border rounded px-1 py-0.5" value="{{ $s->urutan }}" min="1">
                </div>
                <div class="flex-1">
                    <div class="font-medium text-sm">{{ $s->judul ?? 'Step '.$s->urutan }}</div>
                    <div class="text-xs text-gray-500">Durasi: {{ $s->durasi_detik }} dtk | Status: {{ $s->status }} @if($s->video_path) | Video ✔ @endif</div>
                </div>
                <div class="flex gap-2 text-xs">
                    <a href="{{ route('admin.penanganan.steps.edit',[$penanganan,$s]) }}" class="text-indigo-600">Edit</a>
                    <form method="POST" action="{{ route('admin.penanganan.steps.destroy',[$penanganan,$s]) }}" onsubmit="return confirm('Hapus step ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada step.</p>
        @endforelse
    </div>
    @if($steps->isNotEmpty())
        <div class="mt-3">
            <button class="px-4 py-2 bg-green-600 text-white rounded text-sm">Simpan Urutan</button>
        </div>
    @endif
</form>
@endsection
