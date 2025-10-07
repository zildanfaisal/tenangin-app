@extends('layouts.dashboard')
@section('title','Tambah Step')
@section('content')
<h1 class="text-xl font-semibold mb-4">Tambah Step ({{ $penanganan->nama_penanganan }})</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.penanganan.steps.store',$penanganan) }}" class="space-y-6">
    @include('penanganan.steps.form', ['step'=>null, 'nextUrutan'=>$nextUrutan])
    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.penanganan.steps.index',$penanganan) }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
    </div>
</form>
@endsection
