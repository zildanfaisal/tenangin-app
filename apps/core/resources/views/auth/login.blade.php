<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Tenangin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Daftar!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                heightAuto: false, // penting untuk mencegah SweetAlert auto resize dengan body
                customClass: {
                    confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded-md'
                }
            });
        });
    </script>
    @endif
</head>
<body class="h-screen flex">

    <!-- Left Side: Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-8 md:px-16 bg-white relative">
        <div class="max-w-md w-full space-y-6">

            <!-- Back (Responsif + Icon) -->
            <a href="/" class="flex items-center text-sm text-gray-500 hover:text-blue-600 md:absolute md:top-6 md:left-8">
                <i class="fa-solid fa-angles-left mr-1"></i> Kembali
            </a>

            <!-- Title -->
            <h2 class="text-3xl font-bold text-gray-900 mt-8 md:mt-16">Sign In</h2>
            <p class="text-gray-500">Masukkan email dan password mu untuk masuk</p>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm
                            focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="mail@example.com">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm
                            focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Min. 8 characters">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2">Biarkan saya tetap masuk</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                            text-white bg-blue-600 hover:bg-blue-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign In
                    </button>
                </div>
            </form>

            <!-- Register -->
            <p class="text-sm text-gray-600 text-center">
                Belum terdaftar?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Buat Akun</a>
            </p>

            <!-- Footer -->
            <p class="text-xs text-gray-400 text-center mt-8">
                © 2025 Tenangin. All Rights Reserved. Made with love by Mie Ayam team
            </p>
        </div>
    </div>


    <!-- Right Side: Background Image -->
    <div class="hidden md:flex w-1/2 bg-cover bg-center relative"
         style="background-image: url('{{ asset('login.png') }}');">
    </div>

</body>
</html>
