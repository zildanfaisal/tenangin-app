@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Tambah Item DASS-21</h1>
    <form action="{{ route('admin.dass21-items.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Kode</label>
            <input type="text" name="kode" value="{{ old('kode') }}" class="w-full border rounded px-3 py-2" required>
            @error('kode')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Pernyataan</label>
            <textarea name="pernyataan" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('pernyataan') }}</textarea>
            @error('pernyataan')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Subskala</label>
            <select name="subskala" class="w-full border rounded px-3 py-2" required>
                <option value="">-- pilih --</option>
                @foreach(['depresi','anxiety','stres'] as $s)
                    <option value="{{ $s }}" @selected(old('subskala')===$s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            @error('subskala')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Urutan</label>
            <input type="number" name="urutan" value="{{ old('urutan') }}" class="w-full border rounded px-3 py-2" required min="1" max="255">
            @error('urutan')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.dass21-items.index') }}" class="text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
