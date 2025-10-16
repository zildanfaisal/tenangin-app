@extends('layouts.dashboard')
@section('title','Sesi Curhat')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center relative text-white"
     style="background-image: url('{{ asset('bgbanner.png') }}'); background-size: cover; background-position: center;">

  {{-- Overlay biru transparan --}}
  <div class="absolute inset-0 bg-blue-900/40"></div>

  {{-- Konten utama --}}
  <div class="relative z-10 w-full max-w-6xl flex flex-col md:flex-row items-center justify-between px-4 sm:px-6 md:px-12 lg:px-16 py-8 md:py-12 gap-8 md:gap-0">

    {{-- Kiri: Mic dan teks --}}
    <div class="flex-1 flex flex-col items-center text-center w-full">

      {{-- Header atas --}}
      <div class="flex items-center justify-between w-full mb-4 sm:mb-6">
        {{-- Tombol Kembali --}}
        <a href="{{ route('dass21.result', $session->id) }}"
           class="flex items-center gap-1 sm:gap-2 text-white hover:text-blue-200 transition text-sm md:text-base font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali
        </a>
        {{-- Spacer --}}
        <div class="w-[60px] sm:w-[80px] md:w-[120px]"></div>
      </div>

      {{-- Judul --}}
      <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2 sm:mb-4">
        Sesi Curhat
      </h1>

      {{-- Subjudul --}}
      <p class="text-xs sm:text-sm md:text-base opacity-90 mb-6 sm:mb-8 px-2 sm:px-0">
        Ungkapkan kondisimu di sesi ini dengan realtime speech recognition
      </p>

      {{-- 🎙️ Mic besar di tengah --}}
      <button id="micBtn"
              class="w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 rounded-full bg-blue-500 flex items-center justify-center shadow-xl hover:scale-105 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" id="micIcon" fill="white" viewBox="0 0 24 24" class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14">
          <path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 1 0-6 0v6a3 3 0 0 0 3 3z"/>
          <path d="M19 11a1 1 0 0 0-2 0 5 5 0 0 1-10 0 1 1 0 0 0-2 0 7 7 0 0 0 6 6.92V21H8a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2h-3v-3.08A7 7 0 0 0 19 11z"/>
        </svg>
      </button>

      {{-- Status & timer --}}
      <div id="statusText" class="mt-3 sm:mt-4 text-xs sm:text-sm opacity-90">Klik untuk mulai merekam</div>
      <div id="timer" class="mt-1 text-sm sm:text-base font-semibold"></div>

      {{-- Progress bar --}}
      <div class="w-full max-w-xs sm:max-w-md mt-5 sm:mt-6">
        <div class="bg-white/30 rounded-full h-2 sm:h-3 overflow-hidden">
          <div id="progressBar" class="bg-white h-full rounded-full transition-all duration-300 w-0"></div>
        </div>
      </div>

      {{-- Textarea --}}
      <div class="w-full max-w-sm sm:max-w-2xl mt-6 sm:mt-8 px-2 sm:px-0" id="transcriptContainer">
        <h2 class="text-left text-xs sm:text-sm mb-2 opacity-90">Transkrip Berlangsung</h2>
        <textarea id="transcript" rows="6"
          class="w-full p-3 sm:p-4 rounded-xl text-white text-xs sm:text-sm outline-none resize-none placeholder-white/70 border border-white/20 focus:ring-2 focus:ring-white/50 transition"
          style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);"
          placeholder="Curhatanmu akan tampil di sini saat kamu sudah mulai merekam..." readonly></textarea>
      </div>

      {{-- Catatan bawah --}}
      <p class="text-[10px] sm:text-xs mt-5 opacity-80 leading-relaxed px-2 sm:px-0">
        Pastikan mikrofon kamu aktif dan bicaralah dengan jelas untuk hasil terbaik.<br>
        Waktu maksimum perekaman adalah 5 menit per sesi.
      </p>
    </div>

    {{-- Kanan: Maskot --}}
    <div class="mt-8 md:mt-0 md:ml-10 flex justify-center md:block">
      <img src="{{ asset('nai.png') }}" alt="Nai Mascot" class="w-52 sm:w-64 md:w-80 lg:w-96 mx-auto">
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
const statusText = document.getElementById('statusText');
const progressBar = document.getElementById('progressBar');
const transcript = document.getElementById('transcript');
const timer = document.getElementById('timer');
let suaraId = null;

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
  };

  recognition.onend = () => stopRecording();
} else {
  alert('Browser kamu belum mendukung Speech Recognition!');
}

async function startRecording() {
  recognizing = true;
  recognition.start();
  statusText.textContent = 'Merekam...';
  micBtn.style.backgroundColor = '#e74c3c';
  startTimer();

  const response = await fetch('/suara', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      dass21_session_id: {{ $session->id }},
      transkripsi: ''
    })
  });
  const data = await response.json();
  suaraId = data.id;
}

function stopRecording() {
  recognizing = false;
  recognition.stop();
  clearInterval(timerInterval);
  statusText.textContent = 'Rekaman selesai';
  micBtn.style.backgroundColor = '#2563eb';

  if (!suaraId) {
    alert('Gagal menyimpan suara, silakan coba lagi.');
    return;
  }

  fetch(`/suara/${suaraId}/transcribe`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ transkripsi: transcript.value })
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
