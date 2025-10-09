@extends('layouts.dashboard')
@section('title','Rekam Curhat')
@section('content')
<div class="max-w-3xl mx-auto" x-data="curhatRecorder()">
  <nav class="mb-6 text-xs text-gray-500 flex items-center gap-1">
      <a href="/dashboard" class="hover:text-indigo-600">Dashboard</a>
      <span>/</span>
      <span class="text-gray-700">Rekam Curhat</span>
  </nav>

  <div class="p-4 bg-white rounded shadow space-y-4">
    <div class="flex items-center gap-3">
      <button @click="toggleRecord" class="px-4 py-2 rounded text-white" :class="recording ? 'bg-red-600' : 'bg-indigo-600'" x-text="recording ? 'Stop' : 'Mulai Rekam'"></button>
      <span class="text-sm text-gray-600" x-text="statusText"></span>
    </div>

    <div class="space-y-2">
      <label class="text-sm font-medium">Transkrip (auto/ketik manual)</label>
      <textarea x-model="transcript" rows="6" class="w-full border rounded px-2 py-1" placeholder="Ceritakan apa yang kamu rasakan..."></textarea>
      <div class="text-xs text-gray-500">Kamu bisa merekam dulu, lalu kirim transkrip untuk dianalisis.</div>
    </div>

    <div class="flex items-center gap-3">
      <button @click="upload" class="px-4 py-2 bg-gray-700 text-white rounded" :disabled="!blob">Upload Audio</button>
      <button @click="sendTranscript" class="px-4 py-2 bg-green-600 text-white rounded" :disabled="!suaraId || !transcript">Kirim Transkrip</button>
      <template x-if="analysisLink">
        <a :href="analysisLink" class="text-indigo-600 text-sm" target="_blank">Lihat Hasil Analisis</a>
      </template>
    </div>

    <div class="text-xs text-gray-500" x-show="suaraId">ID Suara: <span x-text="suaraId"></span></div>
    <div class="text-xs text-gray-500" x-show="poll.status">Status: <span x-text="poll.status"></span></div>

    <audio x-ref="audio" class="w-full mt-2" controls x-show="audioUrl"></audio>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
  window.curhatRecorder = () => ({
    media: null,
    chunks: [],
    blob: null,
    audioUrl: null,
    recording: false,
    transcript: '',
    suaraId: null,
    poll: { id: null, status: null },
    analysisLink: null,

    get statusText(){
      if(this.recording) return 'Merekam...';
      if(this.blob) return 'Rekaman siap diupload';
      return 'Siap merekam';
    },

    async toggleRecord(){
      if(this.recording){
        this.media.stop();
        this.recording = false;
      } else {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        const mr = new MediaRecorder(stream);
        this.chunks = [];
        mr.ondataavailable = e => { if(e.data.size>0) this.chunks.push(e.data); };
        mr.onstop = () => {
          this.blob = new Blob(this.chunks, { type: 'audio/webm' });
          this.audioUrl = URL.createObjectURL(this.blob);
          this.$refs.audio.src = this.audioUrl;
        };
        mr.start();
        this.media = mr;
        this.recording = true;
      }
    },

    async upload(){
      if(!this.blob) return;
      const fd = new FormData();
      fd.append('audio', this.blob, 'curhat.webm');
      try {
        const resp = await fetch('/api/suara', {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
          body: fd
        });
        if(!resp.ok) throw new Error('Upload gagal');
        const data = await resp.json();
        this.suaraId = data.id;
        this.pollStatus();
      } catch(e) { alert(e.message); }
    },

    async sendTranscript(){
      if(!this.suaraId || !this.transcript) return;
      try {
        const resp = await fetch(`/api/suara/${this.suaraId}/transcribe`, {
          method: 'POST',
          headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ transkripsi: this.transcript, language: 'id' })
        });
        if(!resp.ok) throw new Error('Gagal kirim transkrip');
        this.pollStatus();
      } catch(e) { alert(e.message); }
    },

    async pollStatus(){
      if(!this.suaraId) return;
      clearInterval(this.poll.id);
      this.poll.id = setInterval(async ()=>{
        const r = await fetch(`/api/suara/${this.suaraId}/status`);
        if(!r.ok) return;
        const d = await r.json();
        this.poll.status = d.status;
        if(d.status === 'analyzed'){
          clearInterval(this.poll.id);
          this.analysisLink = `/api/suara/${this.suaraId}/analisis`;
        }
      }, 1500);
    }
  });
});
</script>
@endpush