@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Judul (opsional)</label>
        <input name="judul" value="{{ old('judul',$step->judul ?? '') }}" class="w-full border rounded px-2 py-1">
        @error('judul')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Urutan</label>
        <input name="urutan" type="number" min="1" value="{{ old('urutan',$step->urutan ?? ($nextUrutan ?? 1)) }}" class="w-full border rounded px-2 py-1" required>
        @error('urutan')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Durasi (detik)</label>
        <input name="durasi_detik" type="number" min="5" value="{{ old('durasi_detik',$step->durasi_detik ?? 60) }}" class="w-full border rounded px-2 py-1" required>
        @error('durasi_detik')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Status</label>
        <select name="status" class="w-full border rounded px-2 py-1">
            @foreach(['draft','published'] as $st)
                <option value="{{ $st }}" @selected(old('status',$step->status ?? 'published')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
        @error('status')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Deskripsi (opsional)</label>
        <textarea name="deskripsi" rows="2" class="w-full border rounded px-2 py-1">{{ old('deskripsi',$step->deskripsi ?? '') }}</textarea>
        @error('deskripsi')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Instruksi (satu baris per langkah)</label>
        <textarea name="instruksi" rows="4" class="w-full border rounded px-2 py-1">{{ old('instruksi',$step->instruksi ?? '') }}</textarea>
        @error('instruksi')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Video (opsional)</label>
        <input type="file" name="video" accept="video/*" class="w-full">
        @if(!empty($step?->video_path))
            <video class="mt-2 h-32" controls>
                <source src="{{ asset('storage/'.$step->video_path) }}" type="video/mp4">
            </video>
        @endif
        @error('video')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>