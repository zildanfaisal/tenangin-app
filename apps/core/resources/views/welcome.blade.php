@extends('layouts.app')

@section('title', 'Tenangin - Company Profile')

@section('content')

{{-- ================= NAVBAR ================= --}}
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 md:px-12 flex items-center justify-between h-16">
        <a href="/" class="flex items-center gap-2">
            <img src="{{ asset('logo.png') }}" alt="Logo Tenangin" class="h-8 w-8 rounded-full">
            <span class="font-bold text-brand-blue text-lg">Tenangin</span>
        </a>
        <div class="hidden md:flex gap-6 items-center">
            <a href="#fitur" class="text-gray-700 hover:text-brand-blue font-medium">Fitur</a>
            <a href="#usecase" class="text-gray-700 hover:text-brand-blue font-medium">Use Case</a>
            <a href="#berita" class="text-gray-700 hover:text-brand-blue font-medium">Berita</a>
            <a href="#tentang-kami" class="text-gray-700 hover:text-brand-blue font-medium">Tentang Kami</a>
        </div>
        <div class="flex gap-2 items-center">
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition">Login</a>
            <a href="{{ route('register') }}" class="bg-white border border-blue-600 text-blue-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-blue-50 transition">Register</a>
        </div>
    </div>
</nav>

{{-- ================= HERO SECTION ================= --}}
<section class="bg-gradient-to-b from-brand-dark to-brand-blue text-white">
    <div class="container mx-auto px-4 sm:px-6 md:px-12 py-10 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">
            {{-- Left Text --}}
            <div class="text-center md:text-left mb-8 md:mb-0">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight hero-fade-in" style="animation-delay: 0.5s;">Tenangin</h1>
                <p class="mt-6 text-lg md:text-xl text-gray-300 max-w-xl mx-auto md:mx-0 hero-fade-in" style="animation-delay: 0.8s;">
                    Platform terapi kesehatan mental berbasis AI untuk deteksi kecemasan, burnout, dan PTSD dengan pendampingan personal.
                </p>
                <div class="mt-10 hero-fade-in" style="animation-delay: 1.1s;">
                    <a href="{{ route('register') }}" class="bg-white text-brand-blue font-bold py-3 px-8 rounded-lg text-lg hover:bg-gray-200 transition-transform transform hover:scale-105 inline-block">
                        Coba Sekarang
                    </a>
                </div>
            </div>

            {{-- Right Image --}}
            <div class="flex justify-center items-center order-first md:order-last hero-fade-in mb-8 md:mb-0" style="animation-delay: 0.2s;">
                <img src="{{ asset('Avatar1.png') }}"
                     alt="Ilustrasi Tenangin"
                     class="w-full max-w-xs sm:max-w-md h-56 sm:h-80 md:h-full object-cover rounded-2xl mt-1">
            </div>
        </div>
    </div>
</section>

{{-- ================= FITUR SECTION ================= --}}
<section id="fitur" class="bg-white">
    <div class="container mx-auto px-6 md:px-12 py-16 md:py-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-blue">Fitur Tenangin</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center scroll-animate">
            {{-- Image --}}
            <div class="flex justify-center items-center mb-8 md:mb-0">
                <img src="{{ asset('Avatar2.png') }}" alt="Maskot Tenangin" class="w-full max-w-xs sm:max-w-lg h-56 sm:h-[28rem] rounded-2xl object-cover">
            </div>

            {{-- Features List --}}
            <div class="flex flex-col space-y-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">Analisis Kecemasan, Burnout atau PTSD</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Tenangin menganalisis suara kamu dengan teknologi NLP + SER untuk mendeteksi kecemasan, burnout, dan PTSD. Hasilnya disajikan dalam grafik perkembangan mingguan.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">Rekomendasi Relaksasi Personal</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Kamu akan mendapat rekomendasi aktivitas relaksasi yang tepat hingga reminder cerdas agar healing lebih konsisten. Semua terintegrasi dengan progress tracking & reward system untuk memotivasi perjalanan mental kamu.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">Konsultasi Personal dengan Ahli</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Jika butuh pendampingan lebih lanjut, Tenangin menyediakan akses langsung ke psikolog dan terapis profesional. Kamu bisa melanjutkan sesi konseling secara aman dan privat sesuai kebutuhanmu.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= KENAPA TENANGIN ================= --}}
<section class="bg-slate-50">
    <div class="container mx-auto px-6 md:px-12 py-16 md:py-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-blue">Kenapa Tenangin?</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
                Platform kesehatan mental terdepan yang menggabungkan teknologi AI dengan pendekatan human-centered untuk memberikan solusi komprehensif bagi kesehatan mental Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center scroll-animate">
            {{-- Left Content --}}
            <div class="flex flex-col space-y-8 mb-8 md:mb-0">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">AI Personal Assistant</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Analisis emosional personal dengan teknologi NLP dan SER untuk deteksi gangguan mental secara real-time.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">Pendampingan Virtual</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Avatar virtual yang memberikan dukungan emosional dan panduan relaksasi interaktif.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">Privasi Terjaga</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Data kesehatan mental Anda aman dengan enkripsi tingkat enterprise dan privacy by design.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-brand-blue mb-2">Dukungan Komunitas</h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Terhubung dengan komunitas yang peduli kesehatan mental untuk saling mendukung.
                    </p>
                </div>
            </div>

            {{-- Right Image --}}
            <div class="flex justify-center items-center mb-8 md:mb-0">
                <img src="{{ asset('Avatar3.png') }}" alt="Maskot Tenangin" class="w-full max-w-xs sm:max-w-lg h-56 sm:h-[28rem] rounded-2xl object-cover">
            </div>
        </div>
    </div>
</section>

{{-- ================= PRICING ================= --}}

<section id="pricing" class="bg-white py-16 md:py-24">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800">Cerita Sepuasnya?</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
                Temukan tingkat dukungan yang tepat untuk Anda. Apakah Anda butuh ruang untuk sekadar memulai, konsistensi untuk terus bertumbuh, atau solusi menyeluruh untuk sebuah tim? Pilihan ada di tangan Anda.
            </p>
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto scroll-animate">

            {{-- Free Plan --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200 flex flex-col hover:shadow-2xl transition duration-300">
                <div class="flex-grow">
                    <span class="inline-block bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4">Paling Populer</span>
                    <h3 class="text-2xl font-bold text-gray-800">Plus</h3>
                    <p class="mt-2 text-4xl font-bold text-gray-900">Free</p>
                    <ul class="mt-6 space-y-4 text-gray-700 text-sm">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            5 Kali Curhat
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            5 Menit Per Sesi
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Analisis Gejala Awal Berdasarkan Cerita Pengguna
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Rekomendasi Tindak Lanjut
                        </li>
                    </ul>
                </div>
                <a href="{{ route('login') }}" class="mt-8 w-full text-center bg-[#0B0A5A] hover:bg-indigo-800 text-white font-semibold py-3 px-6 rounded-lg transition-colors">Dapatkan Sekarang</a>
            </div>

            {{-- Pro Plan --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200 flex flex-col hover:shadow-2xl transition duration-300">
                <div class="flex-grow">
                    <span class="inline-block bg-blue-200 text-blue-800 text-xs font-bold px-3 py-1 rounded-full mb-4">Premium Edition</span>
                    <h3 class="text-2xl font-bold text-gray-800">Pro</h3>
                    <p class="mt-2 text-4xl font-bold text-gray-900">Rp 55K <span class="text-lg text-gray-500">/bulan</span></p>
                    <ul class="mt-6 space-y-4 text-gray-700 text-sm">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            50 Kali Curhat
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            5 Menit Per Sesi
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Analisis Gejala Awal
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Rekomendasi Tindak Lanjut
                        </li>
                    </ul>
                </div>
                <a href="{{ route('login') }}" class="mt-8 w-full text-center bg-[#0B0A5A] hover:bg-indigo-800 text-white font-semibold py-3 px-6 rounded-lg transition-colors">Dapatkan Sekarang</a>
            </div>

            {{-- Business Plan --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200 flex flex-col hover:shadow-2xl transition duration-300">
                <div class="flex-grow">
                    <span class="inline-block bg-gray-200 text-gray-800 text-xs font-bold px-3 py-1 rounded-full mb-4">Unlimited Flow</span>
                    <h3 class="text-2xl font-bold text-gray-800">For Your Business</h3>
                    <p class="mt-2 text-4xl font-bold text-gray-900">Custom</p>
                    <ul class="mt-6 space-y-4 text-gray-700 text-sm">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Akses Skalabel untuk Seluruh Tim
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Dashboard Analitik & Laporan Kesejahteraan
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Program yang Disesuaikan Sepenuhnya
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Dukungan Kemitraan Jangka Panjang
                        </li>
                    </ul>
                </div>
                <a href="http://wa.me/+62895379669588" class="mt-8 w-full text-center bg-[#0B0A5A] hover:bg-indigo-800 text-white font-semibold py-3 px-6 rounded-lg transition-colors">Hubungi Kontak</a>
            </div>

        </div>
    </div>
</section>

{{-- ================= USE CASE ================= --}}
<section id="usecase" class="bg-white">
    <div class="container mx-auto px-6 md:px-12 py-16 md:py-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-blue">Tenangin Use Case</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
                Berbagai skenario kehidupan dimana Tenangin dapat memberikan dukungan kesehatan mental yang tepat dan personal.
            </p>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 scroll-animate">
            @foreach([
                ['title'=>'Burnout di Tempat Kerja','desc'=>'Deteksi dini dan manajemen stres kerja dengan panduan relaksasi yang tepat untuk karyawan dan profesional.','color'=>'from-orange-400 to-red-500','tags'=>['Workplace','Stress Management','Professional']],
                ['title'=>'Kecemasan Mahasiswa','desc'=>'Dukungan mental untuk mahasiswa menghadapi tekanan akademik, ujian, dan transisi kehidupan kampus.','color'=>'from-blue-400 to-indigo-500','tags'=>['Academic','Anxiety','Student Life']],
                ['title'=>'PTSD Pasca Trauma','desc'=>'Pendampingan sensitif untuk pemulihan trauma dengan teknik terapi berbasis bukti dan dukungan AI yang empatis.','color'=>'from-pink-400 to-purple-500','tags'=>['PTSD','Therapy']],
                ['title'=>'Stres Rumah Tangga','desc'=>'Manajemen stres akibat rutinitas rumah dan peran ganda dengan panduan relaksasi sederhana.','color'=>'from-green-400 to-teal-500','tags'=>['Household','Parenting','Stress Management']],
                ['title'=>'Tekanan Waktu','desc'=>'Dukungan untuk mengatasi tekanan deadline, multitasking, dan kurangnya waktu istirahat.','color'=>'from-yellow-400 to-orange-500','tags'=>['Anxiety','Time','Productivity']],
                ['title'=>'PTSD dalam Keluarga','desc'=>'Pendampingan trauma akibat konflik, kehilangan, atau dinamika keluarga yang berat.','color'=>'from-cyan-400 to-sky-500','tags'=>['PTSD','Therapy','Family']]
            ] as $use)
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-gradient-to-br {{ $use['color'] }}">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-800">{{ $use['title'] }}</h3>
                    <p class="mt-2 text-gray-500 text-base flex-grow">{{ $use['desc'] }}</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach($use['tags'] as $tag)
                            <span class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= BERITA ================= --}}
<section id="berita" class="bg-slate-50">
    <div class="container mx-auto px-6 md:px-12 py-16 md:py-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-blue">Berita Tenangin</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
                Update terbaru tentang perkembangan dan riset kesehatan mental, dan pencapaian dalam membantu masyarakat Indonesia.
            </p>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 max-w-5xl mx-auto scroll-animate">
            <a href="#" class="block bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="h-48 bg-blue-600"></div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800">Hasil Survei I-NAMHS: Satu dari Tiga Remaja Indonesia Memiliki Masalah Kesehatan Mental</h3>
                    <p class="mt-4 text-gray-500 text-sm">24 Oktober 2022</p>
                </div>
            </a>

            <a href="#" class="block bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-yellow-400 to-lime-400"></div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800">PTSD and Burnout are Related to Lifetime Mood Spectrum in Emergency Healthcare Operator</h3>
                    <p class="mt-4 text-gray-500 text-sm">30 Juli 2020</p>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ================= KONSULTASI ================= --}}
<section id="konsultasi" class="bg-white">
    <div class="container mx-auto px-6 md:px-12 py-20 text-center scroll-animate">
        <h2 class="text-3xl font-bold text-gray-800">Tidak Menemukan Kasus Anda?</h2>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
            Tenangin dapat beradaptasi dengan berbagai situasi kesehatan mental. Mari diskusikan kebutuhan spesifik Anda dengan tim ahli kami.
        </p>
        <div class="mt-8">
            <a href="https://docs.google.com/forms/d/e/1FAIpQLSc7kIDLkh9vQwNfMCXv5ibHGaZYSLgo70n7IS7I91b_JRdOGg/viewform" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors text-lg">Konsultasi Sekarang</a>
        </div>
    </div>
</section>

{{-- ================= TENTANG KAMI ================= --}}
<section id="tentang-kami" class="bg-slate-50">
    <div class="container mx-auto px-6 md:px-12 py-16 md:py-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-blue">Tentang Kami</h2>
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 max-w-5xl mx-auto scroll-animate">
            {{-- Visi --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-gradient-to-br from-pink-400 to-purple-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                </div>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    Menjadi pelopor platform kesehatan mental terdepan di Indonesia, dengan memanfaatkan teknologi AI yang inovatif dan inklusif untuk mewujudkan masyarakat yang sehat secara mental dan emosional.
                </p>
            </div>

            {{-- Misi --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-gradient-to-br from-cyan-400 to-sky-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h10a2 2 0 002-2v-1a2 2 0 012-2h1.945"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                </div>
                <ul class="mt-6 space-y-3 text-gray-600 list-disc list-inside">
                    <li>Menyediakan analisis emosi personal berbasis AI (NLP & SER) dengan pendampingan avatar virtual yang interaktif.</li>
                    <li>Membangun komunitas suportif dan memperluas jangkauan melalui edukasi serta kemitraan strategis.</li>
                    <li>Melakukan inovasi berkelanjutan untuk pengembangan fitur dan ekspansi pasar nasional.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ================= OUR TEAM ================= --}}
<section class="bg-white">
    <div class="container mx-auto px-6 md:px-12 py-16 md:py-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-brand-blue">Our Team</h2>
        </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12 max-w-4xl mx-auto scroll-animate">
            <div class="text-center">
                <img class="w-40 h-40 rounded-full object-cover mx-auto shadow-md" src="{{ asset('isaac.png') }}" alt="Foto Isaac Shabri">
                <h3 class="mt-6 text-xl font-bold text-gray-800">Isaac Shabri</h3>
                <p class="mt-1 text-indigo-600 font-semibold">Hipster</p>
            </div>
            <div class="text-center">
                <img class="w-40 h-40 rounded-full object-cover mx-auto shadow-md" src="{{ asset('satriyo.png') }}" alt="Foto Satriyo Imam">
                <h3 class="mt-6 text-xl font-bold text-gray-800">Satriyo Imam</h3>
                <p class="mt-1 text-indigo-600 font-semibold">Hustler</p>
            </div>
            <div class="text-center">
                <img class="w-40 h-40 rounded-full object-cover mx-auto shadow-md" src="{{ asset('regi.png') }}" alt="Foto Regi Muhammar">
                <h3 class="mt-6 text-xl font-bold text-gray-800">Regi Muhammar</h3>
                <p class="mt-1 text-indigo-600 font-semibold">Hacker</p>
            </div>
        </div>
    </div>
</section>

{{-- ================= KOLABORASI CTA ================= --}}
<section class="bg-slate-100">
    <div class="container mx-auto px-6 md:px-12 py-20 text-center scroll-animate">
        <h2 class="text-3xl font-bold text-gray-800">Ingin berkolaborasi dan menjadi bagian dari kami?</h2>
        <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
            Kami terbuka untuk diskusi, kolaborasi riset, atau konsultasi mengenai implementasi teknologi kesehatan mental di organisasi Anda. Daftarkan dirimu menjadi konselor ataupun konsultan kebanggaan kami.
        </p>
        <div class="mt-8">
            <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors text-lg">Hubungi Tim Kami</a>
        </div>
    </div>
</section>

@endsection
