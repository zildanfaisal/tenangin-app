@extends('layouts.dashboard')
@section('title','Tambah Penanganan')
@section('content')
<h1 class="text-xl font-semibold mb-4">Tambah Penanganan</h1>
<form method="POST" action="{{ route('admin.penanganan.store') }}" enctype="multipart/form-data" class="space-y-6">
    @include('penanganan._form')
    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.penanganan.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
    </div>
</form>
@endsection
