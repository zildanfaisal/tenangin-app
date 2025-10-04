<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg text-blue-700">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8">
                Tenangin
            </a>
            <ul class="flex items-center gap-6 text-sm font-medium">
                <li><a href="#layanan" class="hover:text-blue-600">Layanan</a></li>
                <li><a href="#berita" class="hover:text-blue-600">Berita</a></li>
                <li><a href="#konsultasi" class="hover:text-blue-600">Daftar Konsultasi</a></li>
                <li><a href="#tentang" class="hover:text-blue-600">Tentang Kami</a></li>
                <li><a href="#kontak" class="hover:text-blue-600">Kontak</a></li>
            </ul>
            <div class="flex gap-3">
                <a href="#" class="px-4 py-2 text-sm border rounded hover:bg-gray-100">Login</a>
                <a href="#" class="px-4 py-2 text-sm bg-blue-700 text-white rounded hover:bg-blue-800">Sign Up</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#0a0a23] text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h2 class="font-bold text-lg">Tenangin</h2>
                <p class="mt-2 text-sm">Platform kesehatan mental berbasis AI yang mendukung personal untuk deteksi dan penanganan gangguan kecemasan, burnout, dan PTSD.</p>
            </div>
            <div>
                <h3 class="font-semibold">Kontak</h3>
                <ul class="mt-2 space-y-1 text-sm">
                    <li>Email: hello@tenangin.com</li>
                    <li>Telp: +62 21 1234 5678</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold">Ikuti Kami</h3>
                <div class="flex gap-3 mt-2">
                    <a href="#" class="hover:text-blue-400">Facebook</a>
                    <a href="#" class="hover:text-sky-400">Twitter</a>
                    <a href="#" class="hover:text-pink-400">Instagram</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
