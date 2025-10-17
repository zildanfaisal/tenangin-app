@extends('layouts.dashboard')
@section('title', 'Pembayaran Konsultasi')

@section('content')
<div class="min-h-screen bg-[#f4f6fb] py-8 px-4 sm:py-10 sm:px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">

        {{-- Pesanan --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center justify-center text-blue-600 hover:text-blue-700 font-medium transition w-full sm:w-auto text-center">
                    ← Kembali
                </a>
                <span class="text-gray-400 text-sm text-center sm:text-right">Langkah 2 dari 2</span>
            </div>

            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <span>Pesanan Jadwal</span>
                <span class="text-blue-600 font-semibold text-base sm:text-lg">
                    Rp. {{ number_format($konsultan->harga,0,',','.') }} / 2 Sesi
                </span>
            </h3>

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 mb-6">
                <img src="{{ asset($konsultan->foto ?? 'default-user.png') }}" 
                     alt="{{ $konsultan->nama_konsultan }}" 
                     class="w-24 h-24 sm:w-20 sm:h-20 rounded-xl object-cover shadow-sm border border-gray-200">
                <div class="text-center sm:text-left">
                    <h4 class="font-semibold text-gray-900 text-lg">{{ $konsultan->nama_konsultan }}</h4>
                    <p class="text-sm text-gray-500">{{ $konsultan->spesialisasi }}</p>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-3 text-sm">
                        @if($tanggal)
                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg shadow-sm">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}
                        </span>
                        @endif
                        @if($jam)
                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg shadow-sm">
                            {{ $jam }} WIB
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            @isset($user)
            <h4 class="text-gray-800 font-semibold mb-3 text-center sm:text-left">Info Pemesan</h4>
            <div class="grid grid-cols-1 gap-3 text-sm">
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex flex-col sm:flex-row justify-between text-center sm:text-left">
                    <span class="text-gray-500">Email</span>
                    <span class="text-gray-900 font-medium break-all">{{ $user->email }}</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex flex-col sm:flex-row justify-between text-center sm:text-left">
                    <span class="text-gray-500">Nama Lengkap</span>
                    <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex flex-col sm:flex-row justify-between text-center sm:text-left">
                    <span class="text-gray-500">Usia</span>
                    <span class="text-gray-900 font-medium">{{ $user->usia }} Tahun</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex flex-col sm:flex-row justify-between text-center sm:text-left">
                    <span class="text-gray-500">Jenis Kelamin</span>
                    <span class="text-gray-900 font-medium capitalize">{{ $user->jenis_kelamin }}</span>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 flex flex-col sm:flex-row justify-between text-center sm:text-left">
                    <span class="text-gray-500">Nomor HP</span>
                    <span class="text-gray-900 font-medium break-all">{{ $user->no_hp }}</span>
                </div>
            </div>
            @endisset
        </div>

        {{-- QR + Status --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 text-center">
            <h4 class="text-lg sm:text-xl font-semibold text-gray-800 mb-5">Pembayaran QR (Scan untuk konfirmasi)</h4>

            <div class="flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 pb-3 mb-6 text-center sm:text-left">
                <span class="text-gray-600 font-medium text-base sm:text-lg">Total yang harus dibayar</span>
                <span class="text-xl sm:text-2xl font-semibold text-blue-600 mt-2 sm:mt-0">
                    Rp. {{ number_format($totalBayar,0,',','.') }}
                </span>
            </div>

            <p class="text-sm text-gray-600 mb-4">Scan QR di bawah lalu buka tautan yang muncul untuk mengonfirmasi.</p>

            {{-- QR image --}}
            <div class="flex justify-center">
                <img src="{{ $qrImage }}" alt="QR konfirmasi" class="w-56 h-56 sm:w-64 sm:h-64 rounded-lg border mb-6 shadow-md object-contain">
            </div>

            <div id="statusBox" class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-yellow-50 text-yellow-700 text-sm text-center">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10"/>
                </svg>
                Menunggu pembayaran...
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2 mt-6">
                <div class="bg-blue-600 h-2 rounded-full progress-bar transition-all duration-500" style="width: 10%"></div>
            </div>

            <p class="text-xs text-gray-400 italic mt-4">
                Halaman akan otomatis berubah menjadi sukses setelah konfirmasi dari pemindai.
            </p>
        </div>
    </div>
</div>

{{-- Polling status --}}
<script>
    const sid = @json($sid);
    const statusUrl = "{{ route('konsultan.bayar.qris.status') }}" + "?sid=" + encodeURIComponent(sid);
    const suksesUrl = "{{ route('konsultan.bayar.sukses') }}";
    const box = document.getElementById('statusBox');
    const bar = document.querySelector('.progress-bar');

    async function poll() {
        try {
            const res = await fetch(statusUrl, { cache: 'no-store' });
            if (!res.ok) throw new Error('network');
            const data = await res.json();

            if (data.paid) {
                box.className = "inline-flex items-center justify-center px-3 py-2 rounded-lg bg-green-50 text-green-700 text-sm";
                box.innerHTML = `<svg class='w-4 h-4 mr-2' viewBox='0 0 24 24' fill='currentColor'><path d='M9 12l2 2 4-4'/></svg> Pembayaran terkonfirmasi!`;
                bar.style.width = '100%';
                setTimeout(() => { window.location.href = suksesUrl; }, 700);
                return;
            } else {
                const current = parseInt(bar.style.width) || 10;
                bar.style.width = (current >= 90 ? 10 : current + 10) + '%';
            }
        } catch (e) {}
        setTimeout(poll, 2500);
    }

    document.addEventListener('DOMContentLoaded', poll);
</script>
@endsection
