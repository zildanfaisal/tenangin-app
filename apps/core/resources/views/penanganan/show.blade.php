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
<div class="max-w-7xl mx-auto"
      x-data='penangananPlayer({
          initial: 0,
          steps: @json($stepsPayload)
      })'>
    <nav class="mb-6 text-xs text-gray-500 flex items-center gap-1">
        <a href="/dashboard" class="hover:text-indigo-600">Dashboard</a>
        <span>/</span>
        <a href="{{ route('dass21.index') }}" class="hover:text-indigo-600">DASS-21</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ $penanganan->nama_penanganan }}</span>
    </nav>

    <!-- Intro Screen -->
    <div x-show="!started" 
        class="flex flex-col md:flex-row items-center md:items-start justify-center max-w-6xl mx-auto p-6 gap-10">

        <!-- Kolom Kiri: Gambar -->
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('img/cover-penanganan.png') }}" 
                alt="Cover" 
                class="w-96 h-96 md:w-96 md:h-96 object-contain">
        </div>

        <!-- Kolom Kanan: Informasi -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center md:items-start">
            <h1 class="text-3xl font-bold mb-3 text-gray-800">{{ $penanganan->nama_penanganan }}</h1>
            <p class="text-sm text-gray-500 mb-2">Penanganan {{ $penanganan->kelompok ?? 'Umum' }} - {{ $totalSteps }} Tahapan</p>

            <p class="text-gray-700 leading-relaxed mb-5">
                {{ $penanganan->deskripsi_penanganan }}
            </p>

            <button @click="start()" 
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 transition">
                Ayo Mulai
            </button>

            <p class="mt-4 text-xs italic text-gray-400">
                Reference: The Science of a Single Breath: How Breathing Calms Your Brain (And How to Practice It)
            </p>
        </div>
    </div>

    <!-- Multi-step Mode (Simple, No Timer) -->
    <template x-if="started && multiStep && !finished">
        <div class="mt-10 flex flex-col items-center justify-center">
            <div class="flex flex-col md:flex-row items-center justify-center gap-10">
                <!-- Kolom Kiri: Gambar/Video -->
                <div class="w-full md:w-1/2 flex justify-center">
                    <template x-if="currentStep.video">
                        <div class="w-full flex flex-col items-center">
                            <div class="w-96 h-96 md:w-96 md:h-96 flex items-center justify-center">
                                <video 
                                    playsinline 
                                    class="w-full h-full"
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
                    <h1 class="text-2xl font-bold mb-2 text-gray-800" 
                        x-text="currentStep.judul ? currentStep.judul : penangananName"></h1>

                    <!-- Progress bar hanya muncul di step mode -->
                    <p class="text-sm text-gray-500 mb-2">
                        <span x-text="`${currentIndex+1}/${steps.length} Tahapan`"></span>
                    </p>
                    <template x-if="started && multiStep">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-300"
                                :style="`width: ${(currentIndex+1)/steps.length*100}%`"></div>
                        </div>
                    </template>

                    <ul class="text-gray-700 leading-relaxed mb-5 list-decimal list-inside" x-html="currentStep.deskripsi.split(/(?<=\.)\s+/).map((item, i) => `<li>${item.trim()}</li>`).join('')"></ul>

                    <!-- Tombol dibuat 2 kolom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
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
                </div>
            </div>
        </div>
    </template>

    <!-- Finish Screen -->
    <div x-show="finished" class="flex flex-col md:flex-row items-center justify-center max-w-6xl mx-auto p-6 gap-10">
        <!-- Gambar maskot -->
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('img/cover-finish-penanganan.png') }}" alt="Mascot" class="w-96 h-96 md:w-96 md:h-96 object-contain">
        </div>
        <!-- Konten kanan -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center md:items-start">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Hebat!</h2>
            <p class="text-gray-700 mb-4">Kamu sudah berhasil menyelesaikan <span class="font-semibold">{{ $penanganan->nama_penanganan }}</span>.<br>
            Setiap napas tenang yang kamu ambil adalah langkah kecil menuju keseimbangan dan ketenangan batin. Terus pertahankan rutinitas ini untuk mendukung kesejahteraan mentalmu.</p>
            <div class="flex gap-4">
                <a href="{{ route('dass21.index') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition">Rekomendasi Lainnya</a>
                <a href="/dashboard" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md shadow hover:bg-gray-200 transition">Menu Utama</a>
            </div>
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