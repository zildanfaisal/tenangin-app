@extends('layouts.dashboard')
@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] flex justify-center py-6 px-4 sm:px-6">
  <div class="bg-white w-full max-w-5xl rounded-3xl shadow-lg p-6 sm:p-10 text-gray-800">

    {{-- 🔹 Bagian Foto Profil --}}
    <div class="flex flex-col items-center mb-6">
        <div class="relative">
            {{-- Foto profil --}}
            <img id="profile-preview"
                src="{{ $user->profile_photo
                    ? asset('storage/'.$user->profile_photo)
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-blue-100 shadow-md object-cover">

            {{-- 🔸 Tombol Hapus Foto --}}
            @if($user->profile_photo)
            <form id="delete-photo-form" action="{{ route('user.delete_photo') }}" method="POST" class="absolute top-2 right-2">
                @csrf
                @method('DELETE')
                <button type="button" id="delete-photo-btn"
                        title="Hapus Foto"
                        class="bg-white rounded-full p-1 shadow hover:bg-red-100">
                    <i class="fa fa-trash text-red-500"></i>
                </button>
            </form>
            @endif

            {{-- 🔸 Input Ganti Foto --}}
            <label for="profile_photo"
                class="absolute bottom-0 right-0 bg-blue-600 text-white text-xs px-2 py-1 rounded-full cursor-pointer">
                Ganti
            </label>
        </div>
    </div>

    {{-- 🔹 Form Update Profil --}}
    <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden">

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('email')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- No HP -->
        <div>
            <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('no_hp')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Usia -->
        <div>
            <label for="usia" class="block text-sm font-medium text-gray-700">Usia</label>
            <input type="number" name="usia" id="usia" value="{{ old('usia', $user->usia) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('usia')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Kesibukan -->
        <div>
            <label for="kesibukan" class="block text-sm font-medium text-gray-700">Kesibukan</label>
            <select name="kesibukan" id="kesibukan"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="Mahasiswa" {{ old('kesibukan', $user->kesibukan) == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="Siswa" {{ old('kesibukan', $user->kesibukan) == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="Karyawan" {{ old('kesibukan', $user->kesibukan) == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                <option value="Fresh Graduate" {{ old('kesibukan', $user->kesibukan) == 'Fresh Graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                <option value="Wiraswasta" {{ old('kesibukan', $user->kesibukan) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                <option value="Wirausaha" {{ old('kesibukan', $user->kesibukan) == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
            </select>
            @error('kesibukan')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
  </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Preview foto
document.getElementById('profile_photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// SweetAlert2 konfirmasi hapus foto
document.getElementById('delete-photo-btn')?.addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Hapus Foto Profil?',
        text: 'Foto profil akan dihapus dan tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-photo-form').submit();
        }
    });
});

// SweetAlert2 sukses hapus foto
// @if(session('success'))
//     Swal.fire({
//         icon: 'success',
//         title: 'Berhasil!',
//         text: '{{ session('success') }}',
//         confirmButtonColor: '#3085d6',
//     });
// @endif
</script>
@endsection
