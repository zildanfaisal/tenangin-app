@extends('layouts.dashboard')
@section('title','Sesi Curhat')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center relative text-white"
     style="background-image: url('{{ asset('bgbanner.png') }}'); background-size: cover; background-position: center;">

  {{-- Overlay biru --}}
  <div class="absolute inset-0 bg-blue-900/40"></div>

  {{-- Konten utama --}}
  <div class="relative z-10 w-full max-w-6xl flex flex-col md:flex-row items-center justify-between px-6 md:px-16">

    {{-- Kiri: Mic dan teks --}}
    <div class="flex-1 flex flex-col items-center text-center">
      {{-- Header atas: tombol kembali + judul --}}
            <div class="flex items-center justify-between w-full mb-6">
        {{-- Tombol Kembali --}}
        <a href="{{ route('dass21.result', $session->id) }}"
           class="flex items-center gap-2 text-white hover:text-blue-200 transition text-sm md:text-base font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali
        </a>

        {{-- Spacer agar tombol kiri & kanan seimbang --}}
        <div class="w-[80px] md:w-[120px]"></div>
      </div>
      <div class="flex items-center justify-between w-full mb-6">

        {{-- Judul di tengah --}}
        <h1 class="text-2xl md:text-3xl font-bold flex-1 text-center translate-x-[-1rem] md:translate-x-[-2rem]">
          Sesi Curhat
        </h1>

        {{-- Spacer agar tombol kiri & kanan seimbang --}}
        <div class="w-[80px] md:w-[120px]"></div>
      </div>

      {{-- Subjudul --}}
      <p class="text-sm md:text-base opacity-90 mb-8">
        Ungkapkan kondisi mu di sesi ini dengan realtime speech recognition
      </p>

      {{-- 🎙️ Mic besar di tengah --}}
      <button id="micBtn"
              class="w-40 h-40 rounded-full bg-blue-500 flex items-center justify-center shadow-xl hover:scale-105 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" id="micIcon" fill="white" viewBox="0 0 24 24" class="w-14 h-14">
          <path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 1 0-6 0v6a3 3 0 0 0 3 3z"/>
          <path d="M19 11a1 1 0 0 0-2 0 5 5 0 0 1-10 0 1 1 0 0 0-2 0 7 7 0 0 0 6 6.92V21H8a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2h-3v-3.08A7 7 0 0 0 19 11z"/>
        </svg>
      </button>

      {{-- Status dan timer --}}
      <div id="statusText" class="mt-4 text-sm opacity-90">Klik untuk mulai merekam</div>
      <div id="timer" class="mt-1 text-base font-semibold"></div>

      {{-- Progress bar --}}
      <div class="w-full max-w-md mt-6">
        <div class="bg-white/30 rounded-full h-3 overflow-hidden">
          <div id="progressBar" class="bg-white h-3 rounded-full transition-all duration-300 w-0"></div>
        </div>
      </div>

      {{-- Textarea transparan (selalu tampil) --}}
      <div class="w-full max-w-2xl mt-8" id="transcriptContainer">
        <h2 class="text-left text-sm mb-2 opacity-90">Transkrip Berlangsung</h2>
        <textarea id="transcript" rows="6"
          class="w-full p-4 rounded-xl text-white text-sm outline-none resize-none placeholder-white/70 border border-white/20 focus:ring-2 focus:ring-white/50 transition"
          style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);"
          placeholder="Curhatanmu akan tampil di sini saat kamu sudah mulai merekam..." readonly></textarea>
      </div>

      <p class="text-xs mt-5 opacity-80">
        Pastikan mikrofon kamu aktif dan bicaralah dengan jelas untuk hasil terbaik.<br>
        Waktu maksimum perekaman adalah 5 menit per sesi.
      </p>
    </div>

    {{-- Kanan: Maskot --}}
    <div class="mt-10 md:mt-0 md:ml-10">
      <img src="{{ asset('nai.png') }}" alt="Nai Mascot" class="w-72 md:w-96">
    </div>
  </div>
</div>

{{-- 🎧 Script mic --}}
<script>
let recognizing = false;
let recognition;
let timerInterval;
let timeElapsed = 0;
const maxDuration = 300;
const micBtn = document.getElementById('micBtn');
const micIcon = document.getElementById('micIcon');
const statusText = document.getElementById('statusText');
const progressBar = document.getElementById('progressBar');
const transcript = document.getElementById('transcript');
const timer = document.getElementById('timer');

if ('webkitSpeechRecognition' in window) {
  recognition = new webkitSpeechRecognition();
  recognition.continuous = true;
  recognition.interimResults = true;
  recognition.lang = 'id-ID';

  let finalTranscript = '';

  recognition.onresult = (event) => {
    for (let i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        finalTranscript += (finalTranscript && event.results[i][0].transcript.trim() ? ' ' : '') + event.results[i][0].transcript;
      }
    }
    transcript.value = finalTranscript;

    // Kirim ke server, server yang broadcast
    fetch(`/dass21/session/{{ $session->id }}/save`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ transcript: transcript.value })
    });
  };

  recognition.onend = () => stopRecording();
} else {
  alert('Browser kamu belum mendukung Speech Recognition!');
}

function startRecording() {
  recognizing = true;
  recognition.start();
  statusText.textContent = 'Merekam...';
  micBtn.style.backgroundColor = '#e74c3c'; // 🔴 merah solid saat aktif
  startTimer();
}

function stopRecording() {
  recognizing = false;
  recognition.stop();
  clearInterval(timerInterval);
  statusText.textContent = 'Rekaman selesai';
  micBtn.style.backgroundColor = '#2563eb'; // 🔵 biru kembali

  fetch(`/dass21/session/{{ $session->id }}/save`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ transcript:transcript.value })
  })
  .then(res => res.json())
  .then(data => {
    console.log('saved: ', data);
    window.location.href = "{{ route('dass21.curhat.done', $session->id) }}";
  });
}


function startTimer() {
  timeElapsed = 0;
  timerInterval = setInterval(() => {
    timeElapsed++;
    const minutes = Math.floor(timeElapsed / 60);
    const seconds = timeElapsed % 60;
    timer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')} / 5:00`;
    progressBar.style.width = `${(timeElapsed / maxDuration) * 100}%`;
    if (timeElapsed >= maxDuration) stopRecording();
  }, 1000);
}

async function requestMicPermission() {
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    try {
      await navigator.mediaDevices.getUserMedia({ audio: true });
      // Izin diberikan, bisa mulai merekam
      startRecording();
    } catch (err) {
      alert('Akses mikrofon ditolak. Silakan izinkan mikrofon untuk merekam suara.');
    }
  } else {
    alert('Browser kamu tidak mendukung akses mikrofon.');
  }
}

micBtn.addEventListener('click', () => {
  if (!recognition) return;
  if (!recognizing) {
    requestMicPermission();
  } else {
    stopRecording();
  }
});
</script>
@endsection
