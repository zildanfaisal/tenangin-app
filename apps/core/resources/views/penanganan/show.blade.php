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
            'instruksi' => $s->instruksi,
            'video' => $s->video_path ? asset('storage/'.$s->video_path) : null,
        ];
    }) : collect();
@endphp
<div class="max-w-3xl mx-auto"
     x-data='penangananPlayer({
        initial: {{ (int)($penanganan->durasi_detik ?? 0) }},
        steps: @json($stepsPayload)
     })'>
    <nav class="mb-6 text-xs text-gray-500 flex items-center gap-1">
        <a href="/dashboard" class="hover:text-indigo-600">Dashboard</a>
        <span>/</span>
        <a href="{{ route('dass21.index') }}" class="hover:text-indigo-600">DASS-21</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ $penanganan->nama_penanganan }}</span>
    </nav>
    <div class="flex flex-col md:flex-row gap-6">
        @if($penanganan->cover_path)
            <img src="{{ asset('storage/'.$penanganan->cover_path) }}" alt="Cover" class="w-full md:w-56 h-56 object-cover rounded shadow">
        @endif
        <div class="flex-1">
            <h1 class="text-2xl font-bold mb-2 flex items-center gap-4">
                {{ $penanganan->nama_penanganan }}
                <template x-if="secondsTotal > 0">
                    <span class="text-sm font-normal bg-indigo-50 text-indigo-700 px-2 py-1 rounded" x-text="display"></span>
                </template>
            </h1>
            <div class="flex flex-wrap gap-2 mb-4 text-xs">
                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded">{{ ucfirst($penanganan->tingkat_kesulitan) }}</span>
                @if($penanganan->durasi_detik)
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">Durasi ± {{ ceil($penanganan->durasi_detik/60) }} menit</span>
                @endif
            </div>
            <p class="text-gray-700 leading-relaxed mb-4">{{ $penanganan->deskripsi_penanganan }}</p>
        </div>
    </div>

    {{-- MULTI-STEP MODE --}}
    @if(isset($steps) && $steps->count() > 0)
        <div class="mt-10">
            <div class="mb-6">
                <h2 class="font-semibold mb-2 flex items-center gap-3">Tahapan (Multi-step)
                    <span class="text-xs font-normal text-gray-500" x-show="multiStep" x-text="`Step ${currentIndex+1} / ${steps.length}`"></span>
                </h2>
                <div class="w-full h-2 bg-gray-200 rounded overflow-hidden">
                    <div class="h-full bg-indigo-500 transition-all" :style="`width: ${progressPercent}%`"></div>
                </div>
                <div class="mt-2 text-xs text-gray-600" x-show="multiStep">
                    <span x-text="overallDisplay"></span>
                    <span class="mx-2">•</span>
                    <span>Remaining step: <span x-text="stepDisplay"></span></span>
                </div>
            </div>

            <template x-if="multiStep">
                <div class="space-y-6">
                    <div class="p-4 border rounded bg-white shadow-sm">
                        <h3 class="font-medium text-sm text-indigo-600 mb-1" x-text="currentStep.judul ? currentStep.judul : `Langkah ${currentIndex+1}`"></h3>
                        <p class="text-gray-700 text-sm whitespace-pre-line" x-text="currentStep.instruksi"></p>
                    </div>

                    <template x-if="currentStep.video">
                        <div class="flex flex-col items-center">
                            <div class="w-72 md:w-96">
                                <video playsinline class="w-full rounded shadow"
                                       :key="currentStep.id"
                                       x-ref="vid"
                                       @ended="onVideoEnded()"
                                       @canplay="autoplayIfStarted()">
                                    <source :src="currentStep.video" type="video/mp4">
                                    Browser kamu tidak mendukung video.
                                </video>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-3 justify-center">
                                <button x-show="!started" @click="start()" class="px-6 py-2.5 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700 focus:outline-none text-sm">Mulai</button>
                                <template x-if="started">
                                    <div class="flex flex-wrap gap-3 items-center justify-center">
                                        <button @click="prevStep()" :disabled="currentIndex===0" :class="currentIndex===0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-700'" class="px-3 py-2 text-white rounded text-xs">Prev</button>
                                        <button @click="toggle()" x-text="paused ? 'Lanjutkan' : 'Jeda'" class="px-4 py-2 bg-amber-500 text-white rounded text-xs"></button>
                                        <button @click="nextStep()" :disabled="!stepFinished || isLastStep" :class="(!stepFinished || isLastStep) ? 'bg-gray-300 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700'" class="px-3 py-2 text-white rounded text-xs">Next</button>
                                        <button @click="reset()" class="px-3 py-2 bg-gray-500 text-white rounded text-xs">Reset</button>
                                        <button x-show="isLastStep" @click="finishAll()" :disabled="!completed" :class="completed ? 'bg-green-600 hover:bg-green-700' : 'bg-green-300 cursor-not-allowed'" class="px-3 py-2 text-white rounded text-xs">Selesai</button>
                                    </div>
                                </template>
                            </div>
                            <p class="text-xs text-gray-500 mt-3" x-show="started && !completed">Video akan mengulang otomatis sampai durasi langkah habis.</p>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    @else
        {{-- SINGLE MODE (fallback) --}}
        @if($penanganan->video_penanganan)
            <div class="mt-8 flex flex-col items-center">
                <h2 class="font-semibold mb-4 self-start">Video Panduan</h2>
                <div class="w-72 md:w-96">
                <video controls playsinline class="w-full rounded shadow"
                       x-ref="vid"
                       @ended="onVideoEnded()"
                       @canplay="autoplayIfStarted()">
                    <source src="{{ asset('storage/'.$penanganan->video_penanganan) }}" type="video/mp4">
                    Browser kamu tidak mendukung video.
                </video>
                </div>
                <div class="mt-4 flex justify-center" x-show="!started">
                    <button @click="start()" class="px-6 py-2.5 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700 focus:outline-none text-sm">Mulai Sekarang</button>
                </div>
                <div class="mt-4 flex items-center justify-center gap-4" x-show="started">
                    <button @click="toggle()" x-text="paused ? 'Lanjutkan' : 'Jeda'" class="px-4 py-2 bg-amber-500 text-white rounded text-sm"></button>
                    <button @click="reset()" class="px-4 py-2 bg-gray-500 text-white rounded text-sm">Reset</button>
                    <span class="text-xs text-gray-600" x-show="completed">Selesai ✅</span>
                </div>
                <p class="text-xs text-gray-500 mt-2" x-show="started && !completed">Video akan otomatis mengulang sampai waktu habis.</p>
            </div>
        @endif
    @endif

    @if(isset($steps) && $steps->count() > 0)
        <div class="mt-10" x-show="multiStep">
            <h2 class="font-semibold mb-3">Daftar Langkah</h2>
            <ol class="list-decimal list-inside space-y-1 text-sm">
                @foreach($steps as $s)
                    <li class="flex items-start gap-2 cursor-pointer group"
                        @click="goTo({{ $loop->index }})"
                        :class="currentIndex === {{ $loop->index }} ? 'font-semibold text-indigo-700' : 'hover:text-indigo-600'">
                        <span>
                            @if(!empty($s->judul))
                                {{ $s->judul }}
                            @elseif(trim($s->instruksi) !== '')
                                {{ \Illuminate\Support\Str::limit($s->instruksi,60) }}
                            @else
                                {{ 'Langkah '.$loop->iteration }}
                            @endif
                        </span>
                        <span class="text-[10px] text-gray-500 group-hover:text-indigo-500">(~{{ ceil($s->durasi_detik/60) }}m)</span>
                    </li>
                @endforeach
            </ol>
        </div>
    @else
        <div class="mt-10">
            <h2 class="font-semibold mb-3">Tahapan</h2>
            <ol class="list-decimal list-inside space-y-2 text-sm">
                @foreach($tahapan as $step)
                    @if(strlen(trim($step)))
                        <li>{{ $step }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    @endif

    @if($penanganan->tutorial_penanganan)
        <div class="mt-10">
            <h2 class="font-semibold mb-2">Tips / Tutorial Tambahan</h2>
            <div class="p-4 bg-amber-50 border border-amber-200 rounded text-sm leading-relaxed">{!! nl2br(e($penanganan->tutorial_penanganan)) !!}</div>
        </div>
    @endif

    <div class="mt-10 flex gap-3">
        <a href="{{ route('dass21.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Kembali ke DASS-21</a>
        <template x-if="!multiStep">
            <button x-show="started" @click="ack()" :disabled="!completed"
                :class="completed ? 'bg-green-600 hover:bg-green-700' : 'bg-green-300 cursor-not-allowed'"
                class="px-4 py-2 text-white rounded transition">
                Selesai
            </button>
        </template>
        <template x-if="multiStep">
            <button x-show="started" @click="finishAll()" :disabled="!completed" :class="completed ? 'bg-green-600 hover:bg-green-700' : 'bg-green-300 cursor-not-allowed'" class="px-4 py-2 text-white rounded transition">Selesai Semua</button>
        </template>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        window.penangananPlayer = ({initial, steps}) => ({
            // Mode flags
            multiStep: Array.isArray(steps) && steps.length > 0,
            // Single mode state
            secondsTotal: initial || 0,
            remaining: initial || 0,
            // Multi-step collections
            steps: steps || [],
            currentIndex: 0,
            stepRemaining: 0,
            totalSeconds: 0,
            overallRemaining: 0,
            stepFinished: false,
            // Common state
            interval: null,
            started: false,
            paused: false,
            completed: false,
            // Computed (single)
            get display(){
                if(this.multiStep) return this.overallDisplay; // fallback
                const m = Math.floor(this.remaining / 60).toString().padStart(2,'0');
                const s = (this.remaining % 60).toString().padStart(2,'0');
                return `${m}:${s}`;
            },
            // Computed (multi-step)
            get currentStep(){ return this.steps[this.currentIndex] || {}; },
            get isLastStep(){ return this.currentIndex === this.steps.length - 1; },
            get progressPercent(){
                if(!this.multiStep || !this.totalSeconds) return 0;
                const elapsed = this.totalSeconds - this.overallRemaining;
                return ((elapsed / this.totalSeconds) * 100).toFixed(1);
            },
            get stepDisplay(){
                const m = Math.floor(this.stepRemaining / 60).toString().padStart(2,'0');
                const s = (this.stepRemaining % 60).toString().padStart(2,'0');
                return `${m}:${s}`;
            },
            get overallDisplay(){
                const m = Math.floor(this.overallRemaining / 60).toString().padStart(2,'0');
                const s = (this.overallRemaining % 60).toString().padStart(2,'0');
                return `${m}:${s}`;
            },
            // Init
            init(){
                if(this.multiStep){
                    this.totalSeconds = this.steps.reduce((t,s)=>t + (s.durasi_detik||0),0);
                    this.overallRemaining = this.totalSeconds;
                    this.stepRemaining = this.steps[0]?.durasi_detik || 0;
                }
            },
            // Start
            start(){
                if(this.multiStep){
                    if(!this.totalSeconds){ this.totalSeconds = 300; this.overallRemaining = 300; }
                } else {
                    if(!this.secondsTotal){ this.secondsTotal = 300; this.remaining = 300; }
                }
                this.started = true; this.paused = false; this.completed = false; this.stepFinished=false;
                this.tick();
                this.playVideo();
            },
            // Timer loop
            tick(){
                if(this.interval) clearInterval(this.interval);
                this.interval = setInterval(()=>{
                    if(this.paused) return;
                    if(this.multiStep){
                        if(this.stepRemaining > 0){
                            this.stepRemaining--; this.overallRemaining--; 
                            if(this.stepRemaining === 0){
                                this.stepFinished = true;
                                if(this.isLastStep){
                                    this.completed = true; clearInterval(this.interval); this.stopVideo(); this.notify();
                                } else {
                                    // auto advance after 1s pause
                                    setTimeout(()=>{ this.nextStep(true); }, 800);
                                }
                            }
                        }
                    } else {
                        if(this.remaining > 0){
                            this.remaining--;
                        } else {
                            this.completed = true; clearInterval(this.interval); this.stopVideo(); this.notify();
                        }
                    }
                },1000);
            },
            // Navigation (multi-step)
            nextStep(auto=false){
                if(!this.multiStep) return;
                if(!this.stepFinished && !auto) return;
                if(this.isLastStep) return;
                this.currentIndex++; this.loadStep();
            },
            prevStep(){
                if(!this.multiStep) return;
                if(this.currentIndex === 0) return;
                this.currentIndex--; this.loadStep();
            },
            loadStep(){
                this.stepFinished = false;
                this.stepRemaining = this.currentStep.durasi_detik || 0;
                this.playVideo();
            },
            goTo(i){
                if(!this.multiStep) return;
                if(i < 0 || i >= this.steps.length) return;
                // Prevent jumping forward before finishing current step
                if(i > this.currentIndex && !this.stepFinished) return;
                this.currentIndex = i;
                this.loadStep();
            },
            finishAll(){
                if(!this.multiStep){ return this.ack(); }
                if(!this.completed) return;
                this.ack();
            },
            // Controls
            toggle(){
                this.paused = !this.paused;
                if(this.paused){ this.pauseVideo(); } else { this.playVideo(true); }
            },
            reset(){
                clearInterval(this.interval);
                if(this.multiStep){
                    this.currentIndex = 0;
                    this.overallRemaining = this.totalSeconds;
                    this.stepRemaining = this.steps[0]?.durasi_detik || 0;
                } else {
                    this.remaining = this.secondsTotal;
                }
                this.paused=false; this.completed=false; this.started=false; this.stepFinished=false;
                this.stopVideo(true);
            },
            // Single-mode acknowledgment
            ack(){
                if(!this.completed) return;
                this.toast('Latihan ditandai selesai. Bagus!');
            },
            // Video helpers
            playVideo(resume=false){
                const v = this.$refs.vid; if(!v) return;
                if(!resume){ v.currentTime = 0; try{ v.load(); }catch(e){} }
                const p = v.play(); if(p && p.catch){ p.catch(()=>{}); }
            },
            pauseVideo(){ const v = this.$refs.vid; if(v) v.pause(); },
            stopVideo(reset=false){ const v = this.$refs.vid; if(v){ v.pause(); if(reset) v.currentTime = 0; } },
            onVideoEnded(){
                if(!this.completed && !this.paused){ this.playVideo(); }
            },
            autoplayIfStarted(){ if(this.started && !this.paused && !this.completed) this.playVideo(true); },
            // Notifications
            notify(){
                if('Notification' in window){
                    if(Notification.permission === 'granted'){
                        new Notification('Latihan selesai',{ body: 'Bagus! Kamu telah menyelesaikan sesi.' });
                    } else if(Notification.permission !== 'denied'){
                        Notification.requestPermission();
                    }
                }
            },
            // Toast util
            toast(msg){
                let el = document.createElement('div');
                el.textContent = msg;
                el.className = 'fixed bottom-5 right-5 bg-green-600 text-white text-sm px-4 py-2 rounded shadow';
                document.body.appendChild(el);
                setTimeout(()=>{ el.classList.add('opacity-0','transition'); },2500);
                setTimeout(()=>{ el.remove(); },3200);
            }
        })
    })
</script>
@endpush