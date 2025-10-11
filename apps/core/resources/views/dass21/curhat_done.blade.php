@extends('layouts.dashboard')
@section('title', 'Sesi Curhat Selesai')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center text-white relative overflow-hidden"
     style="background-image: url('{{ asset('bgbanner.png') }}'); background-size: cover; background-position: center;">

  {{-- Overlay biru --}}
  <div class="absolute inset-0 bg-blue-900/40"></div>

  {{-- Konten utama --}}
  <div class="relative z-10 flex flex-col items-center text-center space-y-6">
    {{-- Judul --}}
    <h1 class="text-3xl md:text-4xl font-bold">Sesi Curhat Selesai...</h1>
    <p class="text-base opacity-80">Silahkan tunggu sebentar</p>

    {{-- 🌊 Loading Spinner Modern --}}
    <div class="relative flex items-center justify-center mt-8">
      <div class="w-20 h-20 border-4 border-white/30 border-t-white rounded-full animate-spin"></div>
      <div class="absolute inset-0 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-8 h-8 opacity-90 animate-pulse">
          <path d="M12 3C7.03 3 3 7.03 3 12s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm1 13h-2v-2h2v2zm0-4h-2V7h2v5z"/>
        </svg>
      </div>
    </div>

    {{-- Deskripsi bawah --}}
    <p class="text-sm opacity-80 mt-6">Memproses laporan hasil kondisi emosimu...</p>
  </div>

</div>

{{-- Auto redirect ke hasil asesmen setelah 5 detik --}}
<script>
  setTimeout(() => {
    window.location.href = "{{ route('dass21.result', $session->id) }}";
  }, 5000);
</script>
@endsection
