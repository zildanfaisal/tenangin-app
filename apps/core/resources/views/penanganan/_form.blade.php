@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Nama</label>
        <input name="nama_penanganan" value="{{ old('nama_penanganan',$penanganan->nama_penanganan ?? '') }}" class="w-full border rounded px-2 py-1" required>
        @error('nama_penanganan')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    {{-- Slug disembunyikan: otomatis dibuat dari nama. Jika ingin manual, buka komentar berikut. --}}
    <input type="hidden" name="slug" value="{{ old('slug',$penanganan->slug ?? '') }}">
    <div>
        <label class="block text-sm font-medium">Status</label>
        <select name="status" class="w-full border rounded px-2 py-1">
            @foreach(['draft','published'] as $s)
                <option value="{{ $s }}" @selected(old('status',$penanganan->status ?? 'draft')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        @error('status')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Kelompok</label>
        <select name="kelompok" class="w-full border rounded px-2 py-1">
            @foreach(['depresi','stres','anxiety'] as $k)
                <option value="{{ $k }}" @selected(old('kelompok',$penanganan->kelompok ?? 'anxiety')===$k)>{{ ucfirst($k) }}</option>
            @endforeach
        </select>
        @error('kelompok')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Ordering</label>
        <input type="number" name="ordering" min="0" value="{{ old('ordering',$penanganan->ordering ?? 0) }}" class="w-full border rounded px-2 py-1">
        @error('ordering')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Deskripsi</label>
        <textarea name="deskripsi_penanganan" rows="3" class="w-full border rounded px-2 py-1" required>{{ old('deskripsi_penanganan',$penanganan->deskripsi_penanganan ?? '') }}</textarea>
        @error('deskripsi_penanganan')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Cover (opsional)</label>
        <input type="file" name="cover" accept="image/*" class="w-full">
        @if(!empty($penanganan?->cover_path))
            <img src="{{ asset('storage/'.$penanganan->cover_path) }}" class="h-16 mt-2 rounded">
        @endif
        @error('cover')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
</div>
