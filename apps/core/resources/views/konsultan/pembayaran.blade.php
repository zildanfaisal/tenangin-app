@extends('layouts.dashboard')
@section('title', 'Pembayaran Konsultasi')

@section('content')
<div class="min-h-screen bg-[#f4f6fb] py-10 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">

        {{-- 🧾 Pesanan Jadwal --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">
            {{-- Tombol Back --}}
            <div class="flex items-center justify-between mb-6">
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </a>
                <span class="text-gray-400 text-sm">Langkah 2 dari 2</span>
            </div>

            <h3 class="text-lg font-semibold text-gray-800 mb-6 flex justify-between items-center">
                <span>Pesanan Jadwal</span>
                <span class="text-blue-600 font-semibold">
                    Rp. {{ number_format($konsultan->harga, 0, ',', '.') }} / 2 Sesi
                </span>
            </h3>

            <div class="flex items-center gap-4 mb-6">
                <img src="{{ asset($konsultan->foto ?? 'default-user.png') }}"
                    alt="{{ $konsultan->nama_konsultan }}"
                    class="w-20 h-20 rounded-xl object-cover shadow-sm border border-gray-200">
                <div>
                    <h4 class="font-semibold text-gray-900 text-lg">{{ $konsultan->nama_konsultan }}</h4>
                    <p class="text-sm text-gray-500">{{ $konsultan->spesialisasi }}</p>
                    <div class="flex gap-3 mt-2 text-sm">
                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg shadow-sm">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}
                        </span>
                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg shadow-sm">
                            {{ $jam }} WIB
                        </span>
                    </div>
                </div>
            </div>

            {{-- Info Pemesan --}}
            <h4 class="text-gray-800 font-semibold mb-3">Info Pemesan</h4>
            <div class="grid grid-cols-1 gap-3 text-sm">
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex justify-between">
                    <span class="text-gray-500">Email</span>
                    <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex justify-between">
                    <span class="text-gray-500">Nama Lengkap</span>
                    <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex justify-between">
                    <span class="text-gray-500">Usia</span>
                    <span class="text-gray-900 font-medium">{{ $user->usia }} Tahun</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex justify-between">
                    <span class="text-gray-500">Jenis Kelamin</span>
                    <span class="text-gray-900 font-medium capitalize">{{ $user->jenis_kelamin }}</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex justify-between">
                    <span class="text-gray-500">Nomor HP</span>
                    <span class="text-gray-900 font-medium">{{ $user->no_hp }}</span>
                </div>
            </div>
        </div>

        {{-- 💰 Detail Pembayaran --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between">
            <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-5">Detail Pembayaran</h4>

                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                    <span class="text-gray-600 font-medium">Total</span>
                    <span class="text-xl font-semibold text-blue-600">
                        Rp. {{ number_format($konsultan->harga, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Dropdown Metode Pembayaran --}}
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Pilih Metode Pembayaran</label>
                    <div class="relative">
                        <select id="paymentMethod"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:ring-blue-500 focus:border-blue-500 appearance-none cursor-pointer">
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS (QR Code)</option>
                            <option value="ewallet">E-Wallet (OVO, GoPay, DANA)</option>
                            <option value="va">Virtual Account</option>
                            <option value="credit">Kartu Kredit / Debit</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-3 text-gray-400"></i>
                    </div>
                </div>

                {{-- Agreement --}}
                <div class="space-y-2 text-xs text-gray-600 mb-4">
                    <label class="flex items-start gap-2">
                        <input type="checkbox" class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Saya setuju dengan <a href="#" class="text-blue-600 font-semibold">Terms of Use</a>.</span>
                    </label>
                    <label class="flex items-start gap-2">
                        <input type="checkbox" class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Saya menyetujui penggunaan data saya untuk keperluan notifikasi & penjadwalan.</span>
                    </label>
                </div>

                {{-- Note --}}
                <p class="text-[11px] text-gray-400 italic">
                    *Dana akan disimpan sementara sampai jadwal dikonfirmasi. Jika pengajuan ditolak, dana akan dikembalikan sepenuhnya.
                </p>
            </div>

            <button
                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-6 py-3 shadow-md transition-all">
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>

{{-- JS Preview Payment --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('paymentMethod');
    select.addEventListener('change', () => {
        if (select.value) {
            const method = select.options[select.selectedIndex].text;
            alert(`Metode pembayaran dipilih: ${method}`);
        }
    });
});
</script>
@endsection
