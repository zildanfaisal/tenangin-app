@extends('layouts.dashboard')
@section('title', 'Tingkatkan Fitur')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] pb-20">

  {{-- 🔹 Header --}}
  <div class="text-center py-10">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Tingkatkan Fitur</h1>
    <p class="max-w-2xl mx-auto text-gray-600 text-sm md:text-base leading-relaxed">
      Temukan tingkat dukungan yang tepat untuk Anda. Apakah Anda butuh ruang untuk sekadar memulai,
      konsistensi untuk terus bertumbuh, atau solusi menyeluruh untuk sebuah tim? Pilihan ada di tangan Anda.
    </p>
  </div>

  {{-- 🔹 Pricing Cards --}}
  <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-6">

    {{-- 🌟 Paket Free --}}
    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200 hover:shadow-2xl transition-all duration-300">
      <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block">Paling Populer</span>
      <h2 class="text-2xl font-bold text-gray-900 mb-1">Plus</h2>
      <p class="text-gray-700 mb-6">Free</p>

      <ul class="text-sm text-gray-700 space-y-3 mb-8">
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> 5 kali curhat</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> 5 menit per sesi</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Analisis gejala awal berdasarkan cerita pengguna</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Rekomendasi tindak lanjut</li>
      </ul>

      <a href="#" class="block text-center bg-[#0B0B90] hover:bg-[#08087a] text-white font-semibold rounded-full py-3 transition">
        Dapatkan Sekarang
      </a>
    </div>

    {{-- 🌟 Paket Pro --}}
    <div class="bg-white shadow-lg rounded-2xl p-8 border border-blue-400 hover:shadow-2xl transition-all duration-300 relative">
      <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block">Premium Edition</span>
      <h2 class="text-2xl font-bold text-gray-900 mb-1">Pro</h2>
      <p class="text-gray-700 mb-6">Rp. 55K <span class="text-gray-500 text-sm">/month</span></p>

      <ul class="text-sm text-gray-700 space-y-3 mb-8">
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> 50 kali curhat</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> 5 menit per sesi</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Analisis gejala awal berdasarkan cerita pengguna</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Rekomendasi tindak lanjut</li>
      </ul>

      <a href="#" class="block text-center bg-[#0B0B90] hover:bg-[#08087a] text-white font-semibold rounded-full py-3 transition">
        Dapatkan Sekarang
      </a>
    </div>

    {{-- 🌟 Paket Business --}}
    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200 hover:shadow-2xl transition-all duration-300">
      <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block">Unlimited Flow</span>
      <h2 class="text-2xl font-bold text-gray-900 mb-1">For Your Business</h2>
      <p class="text-gray-700 mb-6">Custom</p>

      <ul class="text-sm text-gray-700 space-y-3 mb-8">
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Akses Skalabel untuk Seluruh Tim</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Dashboard Analitik & Laporan Kesejahteraan</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Program yang Disesuaikan Sepenuhnya</li>
        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> Dukungan Kemitraan Jangka Panjang</li>
      </ul>

      <a href="#" class="block text-center bg-[#0B0B90] hover:bg-[#08087a] text-white font-semibold rounded-full py-3 transition">
        Hubungi Kontak
      </a>
    </div>
  </div>

  {{-- 🔹 FAQ --}}
  <div class="max-w-5xl mx-auto mt-16 px-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">FAQs</h2>
    <div x-data="{ open1: true, open2: false, open3: false }" class="space-y-6">

      <!-- FAQ 1 -->
      <div class="border-b border-gray-200 pb-3">
        <button @click="open1 = !open1" class="flex justify-between w-full text-left font-semibold text-gray-800">
          Apa keuntungan berlangganan paket Pro dibanding versi Free?
          <i :class="open1 ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
        </button>
        <div x-show="open1" x-collapse class="mt-2 text-gray-600 text-sm leading-relaxed">
          Paket Pro (Rp55.000/bulan) memberikan akses analisis emosi dengan lebih banyak kesempatan,
          menampilkan grafik perkembangan mingguan, serta rekomendasi aktivitas relaksasi personal.
        </div>
      </div>

      <!-- FAQ 2 -->
      <div class="border-b border-gray-200 pb-3">
        <button @click="open2 = !open2" class="flex justify-between w-full text-left font-semibold text-gray-800">
          Apa manfaat paket For Your Business bagi institusi atau perusahaan?
          <i :class="open2 ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
        </button>
        <div x-show="open2" x-collapse class="mt-2 text-gray-600 text-sm leading-relaxed">
          Paket ini dirancang untuk instansi, universitas, dan perusahaan yang ingin mendukung kesehatan mental timnya.
          Fitur-fiturnya mencakup dashboard analitik, laporan kesejahteraan, dan kemitraan jangka panjang.
        </div>
      </div>

      <!-- FAQ 3 -->
      <div>
        <button @click="open3 = !open3" class="flex justify-between w-full text-left font-semibold text-gray-800">
          Bagaimana Tenangin memastikan bahwa langganan berbayar memberikan dampak nyata bagi pengguna?
          <i :class="open3 ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
        </button>
        <div x-show="open3" x-collapse class="mt-2 text-gray-600 text-sm leading-relaxed">
          Tenangin menggunakan model berbasis AI untuk menganalisis curhat dan progres pengguna,
          memberikan insight berkala secara anonim untuk membantu memahami pola emosional.
        </div>
      </div>

      <div class="pt-6">
        <p class="text-gray-800 font-medium mb-2">Masih memiliki pertanyaan?</p>
        <a href="#" class="bg-[#0B0B90] hover:bg-[#08087a] text-white text-sm px-5 py-2 rounded-full font-semibold transition">
          Hubungi Kontak
        </a>
      </div>
    </div>
  </div>

</div>
@endsection
