<form method="GET" action="" id="filterForm">
    {{-- Pricing --}}
    <div class="mb-5">
        <p class="text-sm font-medium text-gray-700 mb-2">Pricing</p>
        <div class="flex items-center gap-2">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                   class="w-20 bg-gray-50 border border-gray-200 rounded-md px-2 py-1 text-sm focus:ring-blue-400 focus:border-blue-400"
                   onchange="this.form.submit()">
            <span class="text-gray-500">–</span>
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                   class="w-20 bg-gray-50 border border-gray-200 rounded-md px-2 py-1 text-sm focus:ring-blue-400 focus:border-blue-400"
                   onchange="this.form.submit()">
        </div>
    </div>

    {{-- Gender --}}
    <div class="mb-5">
        <p class="text-sm font-medium text-gray-700 mb-2">Gender</p>
        <div class="space-y-1 text-sm">
            @foreach(['' => 'Semua', 'L' => 'Laki-laki', 'P' => 'Perempuan'] as $value => $label)
                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis_kelamin" value="{{ $value }}"
                           {{ request('jenis_kelamin') == $value ? 'checked' : '' }}
                           class="text-blue-500 focus:ring-blue-400"
                           onchange="this.form.submit()">
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Kategori --}}
    <div class="mb-5">
        <p class="text-sm font-medium text-gray-700 mb-2">Kategori</p>
        <div class="space-y-1 text-sm">
            @foreach(['' => 'Semua', 'konselor' => 'Konselor', 'konsultan' => 'Konsultan'] as $value => $label)
                <label class="flex items-center gap-2">
                    <input type="radio" name="kategori" value="{{ $value }}"
                           {{ request('kategori') == $value ? 'checked' : '' }}
                           class="text-blue-500 focus:ring-blue-400"
                           onchange="this.form.submit()">
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Rating --}}
    <div>
        <p class="text-sm font-medium text-gray-700 mb-3">Rating</p>
        <div id="rating-filter" class="flex items-center gap-1 cursor-pointer">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fa-solid fa-star text-xl {{ request('min_rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition" data-rating="{{ $i }}"></i>
            @endfor
        </div>
        <input type="hidden" name="min_rating" id="minRatingInput" value="{{ request('min_rating') }}">
        <p class="text-xs text-gray-400 mt-1">Klik untuk filter rating minimal</p>
    </div>
</form>