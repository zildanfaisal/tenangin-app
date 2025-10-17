@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Edit Item DASS-21 ({{ $item->kode }})</h1>
    <form action="{{ route('admin.dass21-items.update',$item) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Kode</label>
            <input type="text" name="kode" value="{{ old('kode',$item->kode) }}" class="w-full border rounded px-3 py-2" required maxlength="10">
            @error('kode')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Pernyataan</label>
            <textarea name="pernyataan" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('pernyataan',$item->pernyataan) }}</textarea>
            @error('pernyataan')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Subskala</label>
            <select name="subskala" class="w-full border rounded px-3 py-2" required>
                @foreach(['depresi','anxiety','stres'] as $s)
                    <option value="{{ $s }}" @selected(old('subskala',$item->subskala)===$s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            @error('subskala')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Urutan</label>
            <input type="number" name="urutan" value="{{ old('urutan',$item->urutan) }}" class="w-full border rounded px-3 py-2" required min="1" max="255">
            @error('urutan')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('admin.dass21-items.index') }}" class="text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
