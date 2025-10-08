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
        <label class="block text-sm font-medium">Durasi (detik)</label>
        <input type="number" name="durasi_detik" min="10" value="{{ old('durasi_detik',$penanganan->durasi_detik ?? '') }}" class="w-full border rounded px-2 py-1">
        @error('durasi_detik')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Tingkat Kesulitan</label>
        <select name="tingkat_kesulitan" class="w-full border rounded px-2 py-1">
            @foreach(['mudah','sedang','sulit'] as $t)
                <option value="{{ $t }}" @selected(old('tingkat_kesulitan',$penanganan->tingkat_kesulitan ?? 'mudah')===$t)>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
        @error('tingkat_kesulitan')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
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
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Tahapan (baris baru = langkah)</label>
        <textarea name="tahapan_penanganan" rows="4" class="w-full border rounded px-2 py-1" required>{{ old('tahapan_penanganan',$penanganan->tahapan_penanganan ?? '') }}</textarea>
        @error('tahapan_penanganan')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Tutorial (opsional)</label>
        <textarea name="tutorial_penanganan" rows="3" class="w-full border rounded px-2 py-1">{{ old('tutorial_penanganan',$penanganan->tutorial_penanganan ?? '') }}</textarea>
        @error('tutorial_penanganan')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Video (opsional) <span class="text-xs text-gray-500">mp4/mov/mkv/webm &lt;=100MB</span></label>
        <input type="file" name="video_penanganan" accept="video/*" class="w-full">
        @if(!empty($penanganan?->video_penanganan))
            <video class="mt-2 h-32 rounded" controls>
                <source src="{{ asset('storage/'.$penanganan->video_penanganan) }}">
                Browser tidak mendukung video tag.
            </video>
        @endif
        @error('video_penanganan')<p class="text-red-600 text-xs">{{ $message }}</p>@enderror
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
