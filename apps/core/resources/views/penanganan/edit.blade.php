@extends('layouts.dashboard')
@section('title','Edit Penanganan')
@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Penanganan</h1>
<form method="POST" action="{{ route('admin.penanganan.update',$penanganan) }}" enctype="multipart/form-data" class="space-y-6">
    @method('PUT')
    @include('penanganan._form',['penanganan'=>$penanganan])
    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.penanganan.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
    </div>
</form>
@endsection
