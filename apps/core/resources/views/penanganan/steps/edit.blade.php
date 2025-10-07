@extends('layouts.dashboard')
@section('title','Edit Step')
@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Step ({{ $penanganan->nama_penanganan }})</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.penanganan.steps.update',[$penanganan,$step]) }}" class="space-y-6">
    @method('PUT')
    @include('penanganan.steps.form', ['step'=>$step])
    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.penanganan.steps.index',$penanganan) }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
    </div>
</form>
@endsection
