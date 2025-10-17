<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="scroll-behavior: smooth;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Tenangin'))</title>

        <!-- Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind -->
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'brand-blue': '#0B0A5A',
                            'brand-dark': '#111827',
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <!-- Default Laravel Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Style for Animation -->
        <style>
            body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
            .scroll-animate { opacity: 0; transform: translateY(40px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
            .scroll-animate.is-visible { opacity: 1; transform: translateY(0); }
            .hero-fade-in { opacity: 0; animation: fade-in 1s ease-out forwards; }
            @keyframes fade-in { to { opacity: 1; } }
        </style>

        @stack('styles')
    </head>

    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Header untuk halaman-halaman yang punya $header --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Content --}}
        <main>
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        {{-- Footer --}}
        @includeIf('layouts.footer')

        {{-- Script untuk animasi scroll & mobile menu --}}
        <script>
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOpenIcon = document.getElementById('menu-open-icon');
            const menuCloseIcon = document.getElementById('menu-close-icon');

            if (menuBtn) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    menuOpenIcon.classList.toggle('hidden');
                    menuCloseIcon.classList.toggle('hidden');
                });
            }

            const animatedElements = document.querySelectorAll('.scroll-animate');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('is-visible');
                    else entry.target.classList.remove('is-visible');
                });
            }, { threshold: 0.1 });
            animatedElements.forEach(element => observer.observe(element));
        </script>

        @stack('scripts')
    </body>
</html>
