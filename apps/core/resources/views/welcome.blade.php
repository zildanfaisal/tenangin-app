@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    <section class="bg-blue-900 text-white min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-6 flex flex-col-reverse lg:flex-row items-center justify-between w-full -mt-10 sm:-mt-16 lg:-mt-20">

            {{-- Text --}}
            <div class="lg:w-1/2 text-center lg:text-left mt-10 lg:mt-0">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-4">
                    Tenangin
                </h1>
                <p class="text-base sm:text-lg lg:text-xl leading-relaxed mb-6 max-w-lg mx-auto lg:mx-0">
                    Platform terapi kesehatan mental berbasis AI untuk deteksi kecemasan, burnout, dan PTSD dengan pendampingan personal.
                </p>
                <a href="#fitur"
                class="inline-block px-6 sm:px-8 py-2.5 sm:py-3 bg-white text-blue-900 rounded font-semibold text-sm sm:text-base lg:text-lg hover:bg-gray-100 transition">
                    Coba Sekarang
                </a>
            </div>

            {{-- Gambar --}}
            <div class="lg:w-1/2 flex justify-center">
                <img src="{{ asset('meditasi.svg') }}"
                    alt="Meditasi"
                    class="w-56 sm:w-72 lg:w-[380px] h-auto">
            </div>
        </div>
    </section>

    {{-- Fitur Section --}}
    <section id="fitur" class="py-20 max-w-7xl mx-auto px-6">
        {{-- Judul --}}
        <h2 class="text-2xl font-bold text-center mb-14">
            Fitur <span class="text-blue-700">Tenangin</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            {{-- Gambar --}}
            <div class="flex justify-center">
                <div class="w-80 h-64 bg-gray-200 flex items-center justify-center text-blue-700 rounded-lg">
                    Gambar
                </div>
            </div>

            {{-- Card Fitur --}}
            <div class="space-y-6">
                <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 text-lg mb-2">
                        Analisis Kecemasan, Burnout atau PTSD
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Tenangin menganalisis suara kamu dengan teknologi NLP + SER untuk mendeteksi kecemasan, burnout, dan PTSD.
                        Hasilnya disajikan dalam grafik perkembangan mingguan.
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 text-lg mb-2">
                        Rekomendasi Relaksasi Personal
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Kamu akan mendapat rekomendasi aktivitas relaksasi yang tepat hingga reminder cerdas agar healing lebih konsisten.
                        Semua terintegrasi dengan progress tracking & reward system untuk memotivasi perjalanan mental kamu.
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 text-lg mb-2">
                        Konsultasi Personal dengan Ahli
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Jika butuh pendampingan lebih lanjut, Tenangin menyediakan akses langsung ke psikolog dan terapis profesional.
                        Kamu bisa melanjutkan sesi konseling secara aman dan privat sesuai kebutuhanmu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- News Section --}}
    <section id="kenapa" class="py-20 max-w-7xl mx-auto px-6">
        {{-- Title --}}
        <div class="text-center mb-14">
            <h2 class="text-2xl font-bold">
                Kenapa <span class="text-blue-700">Tenangin?</span>
            </h2>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-sm sm:text-base">
                Platform kesehatan mental terdepan yang menggabungkan teknologi AI dengan pendekatan
                human-centered untuk memberikan solusi komprehensif bagi kesehatan mental Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            {{-- Left - Features --}}
            <div class="space-y-6">
                <div class="bg-white shadow rounded-lg p-6 border-r-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 mb-2">AI Personal Assistant</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Analisis emosional personal dengan teknologi NLP dan SER untuk deteksi gangguan mental secara real-time.
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 border-r-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 mb-2">Pendampingan Virtual</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Avatar virtual yang memberikan dukungan emosional dan panduan relaksasi interaktif.
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 border-r-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 mb-2">Privasi Terjaga</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Data kesehatan mental Anda aman dengan enkripsi tingkat enterprise dan privacy by design.
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 border-r-4 border-blue-700">
                    <h3 class="font-bold text-blue-800 mb-2">Dukungan Komunitas</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Terhubung dengan komunitas yang peduli kesehatan mental untuk saling mendukung.
                    </p>
                </div>
            </div>

            {{-- Right - Image --}}
            <div class="flex justify-center">
                <div class="w-80 h-64 bg-gray-200 flex items-center justify-center text-blue-700 rounded-lg">
                    Gambar
                </div>
            </div>
        </div>
    </section>

    {{--Use case section--}}
    <section id="usecase" class="py-20 max-w-7xl mx-auto px-6">
        {{-- Title --}}
        <div class="text-center mb-14">
            <h2 class="text-2xl font-bold">
                Tenangin <span class="text-blue-700">Use Case</span>
            </h2>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-sm sm:text-base">
                Berbagai skenario kehidupan dimana Tenangin dapat memberikan dukungan kesehatan mental yang tepat dan personal.
            </p>
        </div>

        {{-- Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- Card 1 --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-orange-100 text-orange-600 text-2xl mb-4">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="font-bold text-blue-800 text-lg mb-2">Burnout di Tempat Kerja</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Deteksi dini dan manajemen stres kerja dengan panduan relaksasi yang tepat untuk karyawan dan profesional.
                </p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Workplace</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Stress Management</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Professional</span>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-600 text-2xl mb-4">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="font-bold text-blue-800 text-lg mb-2">Kecemasan Mahasiswa</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Dukungan mental untuk mahasiswa menghadapi tekanan akademik, ujian, dan transisi kehidupan kampus.
                </p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Academic</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Anxiety</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Student Life</span>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-pink-100 text-pink-600 text-2xl mb-4">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3 class="font-bold text-blue-800 text-lg mb-2">PTSD Pasca Trauma</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Pendampingan sensitif untuk pemulihan trauma dengan teknik terapi berbasis bukti dan dukungan AI yang empatis.
                </p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">PTSD</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Theraphy</span>
                </div>
            </div>

            {{-- Card 4 --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600 text-2xl mb-4">
                    <i class="fas fa-home"></i>
                </div>
                <h3 class="font-bold text-blue-800 text-lg mb-2">Burnout di Rumah</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Manajemen stres akibat rutinitas rumah dan peran ganda dengan panduan relaksasi sederhana.
                </p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Household</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Stress Management</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Parenting</span>
                </div>
            </div>

            {{-- Card 5 --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 text-yellow-600 text-2xl mb-4">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="font-bold text-blue-800 text-lg mb-2">Kecemasan Mahasiswa</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Dukungan untuk mengatasi tekanan deadline, multitasking, dan kurangnya waktu istirahat.
                </p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Anxiety</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Time</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Productivity</span>
                </div>
            </div>

            {{-- Card 6 --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-cyan-100 text-cyan-600 text-2xl mb-4">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="font-bold text-blue-800 text-lg mb-2">PTSD dalam Keluarga</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Pendampingan trauma akibat konflik, kehilangan, atau dinamika keluarga yang berat.
                </p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">PTSD</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Theraphy</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">Family</span>
                </div>
            </div>

        </div>
    </section>




    {{-- Use Case Section --}}
    <section id="berita" class="py-20 max-w-7xl mx-auto px-6">
        {{-- Title --}}
        <div class="text-center mb-14">
            <h2 class="text-2xl font-bold">
                Berita <span class="text-blue-700">Tenangin</span>
            </h2>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-sm sm:text-base">
                Update terbaru tentang perkembangan dan riset kesehatan mental,
                dan pencapaian dalam membantu masyarakat Indonesia.
            </p>
        </div>

        {{-- News Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">

            {{-- News 1 --}}
            <div class="rounded-lg overflow-hidden shadow-lg">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-800 p-6 h-40"></div>
                <div class="bg-white p-6">
                    <h3 class="font-semibold text-gray-800 text-sm sm:text-base mb-3">
                        Hasil Survei I-NAMHS: Satu dari Tiga Remaja Indonesia Memiliki Masalah Kesehatan Mental
                    </h3>
                    <p class="text-gray-400 text-sm">24 Oktober 2022</p>
                </div>
            </div>

            {{-- News 2 --}}
            <div class="rounded-lg overflow-hidden shadow-lg">
                <div class="bg-gradient-to-r from-orange-400 to-yellow-400 p-6 h-40"></div>
                <div class="bg-white p-6">
                    <h3 class="font-semibold text-gray-800 text-sm sm:text-base mb-3">
                        PTSD and Burnout are Related to Lifetime Mood Spectrum in Emergency Healthcare Operator
                    </h3>
                    <p class="text-gray-400 text-sm">30 Juli 2020</p>
                </div>
            </div>

        </div>
    </section>

    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-center mb-10">Tenangin <span class="text-blue-700">Use Case</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow rounded-lg p-6">Burnout di Tempat Kerja</div>
                <div class="bg-white shadow rounded-lg p-6">Kecemasan Mahasiswa</div>
                <div class="bg-white shadow rounded-lg p-6">PTSD Pasca Trauma</div>
            </div>
        </div>
    </section>

    {{-- About Us --}}
    <section id="tentang" class="py-20 max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-center mb-10">Tentang <span class="text-blue-700">Kami</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold">Visi</h3>
                <p class="mt-2 text-sm">Menjadi pelopor platform kesehatan mental berbasis AI di Indonesia...</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold">Misi</h3>
                <p class="mt-2 text-sm">Menyediakan analisis personal berbasis AI untuk deteksi dini...</p>
            </div>
        </div>
    </section>

@endsection
