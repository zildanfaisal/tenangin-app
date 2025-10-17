<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - Tenangin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="h-screen flex bg-white overflow-hidden">

    <!-- Left Side: Form with Full White Background -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-10 bg-white relative overflow-y-auto">
        <div class="max-w-lg w-full space-y-4 py-8 md:py-3">

            <!-- Back -->
            <a href="/" class="flex items-center text-sm text-gray-500 hover:text-blue-600 md:absolute md:top-8 md:left-6">
                <i class="fa-solid fa-angles-left mr-2"></i> Kembali
            </a>

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 mb-1">Buat akun</h2>
            <p class="text-gray-500 mt-0 text-sm">Masukkan email dan password mu untuk masuk</p>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama*</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                               focus:ring focus:ring-blue-400 focus:border-blue-400"
                        placeholder="isi nama mu...">
                    @error('name')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor Telepon*</label>
                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                               focus:ring focus:ring-blue-400 focus:border-blue-400"
                        placeholder="08XXXXXXXXX">
                    @error('no_hp')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Umur -->
                <div>
                    <label for="usia" class="block text-sm font-medium text-gray-700">Umur*</label>
                    <input id="usia" type="number" name="usia" value="{{ old('usia') }}" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                               focus:ring focus:ring-blue-400 focus:border-blue-400"
                        placeholder="umur mu sekarang...">
                    @error('usia')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender*</label>
                    <div class="flex space-x-4 mt-1 text-sm">
                        <label class="flex items-center">
                            <input type="radio" name="jenis_kelamin" value="Laki-Laki" class="text-blue-600 focus:ring-blue-400" checked>
                            <span class="ml-2">Laki-Laki</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" class="text-blue-600 focus:ring-blue-400">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kesibukan -->
                <div>
                    <label for="kesibukan" class="block text-sm font-medium text-gray-700">Kesibukan*</label>
                    <select id="kesibukan" name="kesibukan" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                               focus:ring focus:ring-blue-400 focus:border-blue-400">
                        <option value="" disabled selected>Pilih kesibukan...</option>
                        <option value="mahasiswa" {{ old('kesibukan')=='mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="siswa" {{ old('kesibukan')=='siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="karyawan" {{ old('kesibukan')=='karyawan' ? 'selected' : '' }}>Karyawan</option>
                        <option value="fresh graduate" {{ old('kesibukan')=='fresh graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                        <option value="profesional" {{ old('kesibukan')=='profesional' ? 'selected' : '' }}>Profesional</option>
                        <option value="wiraswasta" {{ old('kesibukan')=='wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="wirausaha" {{ old('kesibukan')=='wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                    </select>
                    @error('kesibukan')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                               focus:ring focus:ring-blue-400 focus:border-blue-400"
                        placeholder="mail@example.com">
                    @error('email')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
                        <input id="password" type="password" name="password" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                                   focus:ring focus:ring-blue-400 focus:border-blue-400"
                            placeholder="Min. 8 characters">
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password*</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-2 text-sm
                                   focus:ring focus:ring-blue-400 focus:border-blue-400"
                            placeholder="Min. 8 characters">
                    </div>
                </div>

                <!-- Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm">
                        Buat Akun
                    </button>
                </div>
            </form>

            <!-- Login -->
            <p class="text-sm text-gray-600 text-center">
                Sudah terdaftar?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Sign In</a>
            </p>

            <!-- Footer (small) -->
            <p class="text-xs text-gray-400 text-center mt-4 hidden md:block">
                © 2025 Tenangin. All Rights Reserved.
            </p>
        </div>
    </div>

    <!-- Right Side: Background Image -->
    <div class="hidden md:flex w-1/2 relative bg-white">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('login.png') }}'); background-size: cover; background-position: center;">
        </div>
    </div>



</body>
</html>
