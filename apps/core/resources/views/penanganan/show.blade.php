@extends('layouts.dashboard')
@section('title', $penanganan->nama_penanganan)
@section('content')
@php
    $stepsPayload = (isset($steps) && $steps->count()) ? $steps->map(function($s){
        return [
            'id' => $s->id,
            'urutan' => $s->urutan,
            'durasi_detik' => $s->durasi_detik,
            'judul' => $s->judul,
            'deskripsi' => $s->deskripsi,
            'video' => $s->video_path ? asset('storage/'.$s->video_path) : null,
        ];
    }) : collect();
    $totalSeconds = (isset($steps) && $steps->count()) ? $steps->sum('durasi_detik') : 0;
    $totalSteps = (isset($steps) && $steps->count()) ? $steps->count() : 0;
@endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6"
      x-data='penangananPlayer({
          initial: 0,
          steps: @json($stepsPayload)
      })'>
    <nav class="mb-6 text-xs text-gray-500 flex flex-wrap items-center gap-1">
        <a href="/dashboard" class="hover:text-indigo-600">Dashboard</a>
        <span>/</span>
        <a href="{{ route('dass21.index') }}" class="hover:text-indigo-600">DASS-21</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ $penanganan->nama_penanganan }}</span>
    </nav>

    <!-- Intro Screen -->
    <div x-show="!started" 
        class="flex flex-col md:flex-row items-center md:items-start justify-center max-w-6xl mx-auto p-4 md:p-6 gap-6 md:gap-10">

        <!-- Kolom Kiri: Gambar -->
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('img/cover-penanganan.png') }}" 
                alt="Cover" 
                class="w-full max-w-xs sm:max-w-sm md:w-96 md:h-96 h-auto object-contain">
        </div>

        <!-- Kolom Kanan: Informasi -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center md:items-start text-center md:text-left">
            <h1 class="text-2xl sm:text-3xl font-bold mb-3 text-gray-800">{{ $penanganan->nama_penanganan }}</h1>
            <p class="text-sm text-gray-500 mb-2">
                Penanganan {{ is_array($penanganan->kelompok) ? implode(', ', $penanganan->kelompok) : $penanganan->kelompok }} - {{ $totalSteps }} Tahapan
            </p>

            <p class="text-gray-700 leading-relaxed mb-5 text-justify">
                {{ $penanganan->deskripsi_penanganan }}
            </p>

            <button @click="start()" 
                    class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 transition">
                Ayo Mulai
            </button>

            <p class="mt-4 text-xs italic text-gray-400">
                Reference: The Science of a Single Breath: How Breathing Calms Your Brain (And How to Practice It)
            </p>
        </div>
    </div>

    <!-- Multi-step Mode -->
    <template x-if="started && multiStep && !finished">
        <div class="mt-10 flex flex-col items-center justify-center px-4">
            <div class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-10 w-full max-w-6xl">

                <!-- Kolom Kiri: Gambar/Video -->
                <div class="w-full md:w-1/2 flex justify-center">
                    <template x-if="currentStep.video">
                        <div class="w-full flex flex-col items-center">
                            <div class="w-full max-w-xs sm:max-w-sm md:w-96 h-auto flex items-center justify-center">
                                <video 
                                    playsinline 
                                    class="w-full h-auto rounded-lg"
                                    :key="currentStep.id"
                                    x-ref="vid"
                                    autoplay
                                    muted
                                    loop
                                    x-effect="vidLoad(currentStep.video)">
                                    <source :src="currentStep.video" type="video/mp4">
                                    Browser kamu tidak mendukung video.
                                </video>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Kolom Kanan: Info Tahapan -->
                <div class="w-full md:w-1/2 text-center md:text-left flex flex-col justify-center">
                    <h1 class="text-xl sm:text-2xl font-bold mb-2 text-gray-800" 
                        x-text="currentStep.judul ? currentStep.judul : penangananName"></h1>

                    <p class="text-sm text-gray-500 mb-2">
                        <span x-text="`${currentIndex+1}/${steps.length} Tahapan`"></span>
                    </p>

                    <template x-if="started && multiStep">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300"
                                :style="`width: ${(currentIndex+1)/steps.length*100}%`"></div>
                        </div>
                    </template>

                    <ul class="text-gray-700 leading-relaxed mb-5 list-decimal list-inside text-sm sm:text-base text-justify" 
                        x-html="currentStep.deskripsi.split(/(?<=\.)\s+/).map((item, i) => `<li>${item.trim()}</li>`).join('')"></ul>

                    <!-- Tombol -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
                        <button 
                            @click="nextStep()" 
                            :disabled="false"
                            :class="[
                                'px-6 py-3 text-white font-semibold rounded-md shadow transition disabled:opacity-50 disabled:cursor-not-allowed',
                                isLastStep ? 'bg-green-600 hover:bg-green-700' : 'bg-indigo-600 hover:bg-indigo-700'
                            ]"
                        >
                            <span x-show="!isLastStep">Lanjutkan</span>
                            <span x-show="isLastStep">Selesai</span>
                        </button>

                        <button 
                            @click="prevStep()" 
                            :disabled="currentIndex===0" 
                            class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-md shadow hover:bg-gray-300 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Kembali
                        </button>
                    </div>
                    {{-- <button x-show="isLastStep"
                        @click="restart()"
                        class="w-full sm:w-auto text-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 transition mt-4">
                        Ulangi {{ $penanganan->nama_penanganan }}
                    </button> --}}
                </div>
            </div>
        </div>
    </template>

    <!-- Finish Screen -->
    <div x-show="finished" class="flex flex-col md:flex-row items-center justify-center max-w-6xl mx-auto p-4 md:p-6 gap-6 md:gap-10">
        <!-- Gambar maskot -->
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('img/cover-finish-penanganan.png') }}" 
                alt="Mascot" 
                class="w-full max-w-xs sm:max-w-sm md:w-96 md:h-96 h-auto object-contain">
        </div>

        <!-- Konten kanan -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center md:items-start text-center md:text-left">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">Hebat!</h2>
            <p class="text-gray-700 mb-4 text-sm sm:text-base text-justify">
                Kamu sudah berhasil menyelesaikan <span class="font-semibold">{{ $penanganan->nama_penanganan }}</span>.<br>
                Setiap napas tenang yang kamu ambil adalah langkah kecil menuju keseimbangan dan ketenangan batin. Terus pertahankan rutinitas ini untuk mendukung kesejahteraan mentalmu.
            </p>
            <button x-show="isLastStep"
                @click="restart()"
                class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 text-sm font-medium transition mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="2" 
                    stroke="currentColor" 
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M20 20v-5h-.581m-15.357-2a8.003 8.003 0 0015.356 2" />
                </svg>
                Ulangi {{ $penanganan->nama_penanganan }}
            </button>

            <!-- 🔹 Row untuk 3 tombol (Rekomendasi, Menu Utama, Lihat Konsultan) -->
            <div class="flex flex-col items-center gap-2">
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-[500px]">
                    <a href="{{ route('dass21.index') }}" 
                        class="w-full sm:w-1/2 text-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition">
                        Rekomendasi Lainnya
                    </a>

                    <button
                        @click="document.getElementById('rekomendasi-konsultan').scrollIntoView({ behavior: 'smooth' })"
                        class="w-full sm:w-1/2 text-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-md shadow hover:bg-emerald-700 transition">
                        Yuk Coba Konsultasi!
                    </button>
                </div>

                <a href="/dashboard" 
                    class="w-full sm:w-[500px] text-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md shadow hover:bg-gray-200 transition">
                    Menu Utama
                </a>
            </div>
        </div>
    </div>


    {{-- 🔹 Rekomendasi Konsultan --}}
    <div x-show="finished" id="rekomendasi-konsultan" class="max-w-6xl mx-auto mt-16 px-4">
        <h3 class="text-lg md:text-xl font-bold text-gray-800 text-center mb-2">Rekomendasi Konsultan</h3>
        <p class="text-sm text-gray-600 text-center mb-8">
        Jika merasa kondisimu belum membaik, cobalah untuk berkonsultasi dengan ahli.
        </p>

        @if($konsultans->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-4 max-w-3xl mx-auto text-sm text-center">
            Belum ada konsultan tersedia saat ini. Silakan kembali nanti.
        </div>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($konsultans as $konsultan)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all p-5 md:p-6 flex flex-col">
                <img src="{{ $konsultan->foto ? asset($konsultan->foto) : asset('consul1.png') }}"
                    alt="{{ $konsultan->nama_konsultan }}"
                    class="rounded-2xl mb-4 object-contain h-44 md:h-48 w-full">
                <h5 class="font-bold text-base md:text-lg mb-1 text-gray-800">{{ $konsultan->nama_konsultan }}</h5>
                <p class="text-xs md:text-sm text-gray-600 mb-2">{{ $konsultan->spesialisasi }}</p>
                <span class="inline-block mb-2 px-3 py-1 bg-gray-100 text-gray-700 text-[11px] md:text-xs rounded-full">
                {{ $konsultan->pengalaman }} Tahun Pengalaman
                </span>
                <div class="flex items-center justify-between text-xs md:text-sm text-gray-600 mb-4">
                <span>Rp {{ number_format($konsultan->harga,0,',','.') }} / 2 Sesi</span>
                <span class="flex items-center gap-1">
                    ⭐ {{ number_format($konsultan->rating,1) }}
                </span>
                </div>
                <a href="{{ route('konsultan.detail', $konsultan->id) }}"
                class="mt-auto self-start bg-blue-700 hover:bg-blue-800 text-white text-xs md:text-sm px-4 py-2 rounded-full transition">
                Hubungi Sekarang
                </a>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-10 flex flex-wrap justify-center gap-3 md:gap-4">
        <a href="{{ route('konsultan.index') }}" class="bg-blue-700 hover:bg-blue-800 text-white px-5 md:px-6 py-2 rounded-lg font-medium text-sm shadow-md transition">
            Cari Konsultan Lain
        </a>
        <a href="{{ route('dass21.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 md:px-6 py-2 rounded-lg font-medium text-sm transition">
            Kembali ke Menu Layanan
        </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        window.penangananPlayer = ({initial, steps}) => ({
            multiStep: Array.isArray(steps) && steps.length > 0,
            steps: steps || [],
            currentIndex: 0,
            started: false,
            finished: false,
            get currentStep(){ return this.steps[this.currentIndex] || {}; },
            get isLastStep(){ return this.currentIndex === this.steps.length - 1; },
            get penangananName(){ return this.steps.length ? this.steps[0].judul || '' : '' },
            start(){ this.started = true; this.finished = false; this.playVideo(); },
            nextStep(){
                if(!this.isLastStep) {
                    this.currentIndex++;
                    this.playVideo();
                } else {
                    this.finished = true;
                }
            },
            prevStep(){ if(this.currentIndex > 0) { this.currentIndex--; this.playVideo(); } },
            finishAll(){ this.started = false; this.currentIndex = 0; this.finished = false; },
            restart(){
                this.currentIndex = 0;     // balik ke step pertama
                this.finished = false;     // hilangkan layar finish
                this.started = true;       // mulai lagi penanganan
                this.playVideo();          // play ulang video step pertama
            },
            playVideo(){
                this.$nextTick(() => {
                    const v = this.$refs.vid; if(v) { v.currentTime = 0; v.load(); v.play(); }
                });
            },
            vidLoad(src){
                this.$nextTick(() => {
                    const v = this.$refs.vid; if(v) { v.load(); v.play(); }
                });
            },
        })
    })
</script>
@endpush
