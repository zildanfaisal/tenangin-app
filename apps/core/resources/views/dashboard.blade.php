@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- 🔹 Hero Section --}}
    <div class="relative rounded-2xl overflow-hidden shadow">
        <img src="{{ asset('hero.png') }}" alt="Hero" class="w-full h-40 sm:h-48 object-cover">
        <div class="absolute inset-0 flex flex-col justify-center px-4 sm:px-8 text-white bg-black/30">
            <h2 class="text-lg sm:text-xl font-semibold">
                Selamat Datang, {{ $user->name ?? 'Pengguna' }}
            </h2>
            <p class="text-xs sm:text-sm mt-1 max-w-md">
                Mulailah hari dengan semangat baru. Lihat hasil asesmen Anda dan pantau perkembangan kesehatan mental Anda.
            </p>
            <a href="{{ route('dass21.intro') }}"
               class="mt-3 bg-white text-blue-700 font-semibold px-3 py-2 sm:px-4 sm:py-2 rounded-lg hover:bg-blue-100 transition w-fit text-sm sm:text-base">
                Lakukan Assessment
            </a>
        </div>
    </div>

    {{-- 🔹 Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-xs sm:text-sm">Total Assessment</h3>
            <p class="text-xl sm:text-2xl font-semibold mt-2">{{ $assesmentCount ?? 0 }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-xs sm:text-sm">Kondisi Emosi Terbanyak</h3>
            <p class="text-xl sm:text-2xl font-semibold mt-2 text-blue-600">
                {{ $lastEmotion ?? '-' }}
            </p>
        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-xs sm:text-sm">Kategori Dominan</h3>
            <p class="text-xl sm:text-2xl font-semibold mt-2 text-indigo-600">
                {{-- 🔸 Default "-" jika belum ada asesmen --}}
                @if(($assesmentCount ?? 0) == 0)
                    -
                @else
                    @php
                        $dominant = collect($chart2['data'] ?? [])->max();
                        $idx = array_search($dominant, $chart2['data'] ?? []);
                        echo $chart2['labels'][$idx] ?? '-';
                    @endphp
                @endif
            </p>
        </div>
    </div>

    {{-- 🔹 Chart Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2 text-gray-800 text-sm sm:text-base">Tren Kondisi Emosi Harian</h3>
            <div class="overflow-x-auto">
                <canvas id="chart1" height="200" class="min-w-[300px]"></canvas>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2 text-gray-800 text-sm sm:text-base">Perbandingan Jumlah Assessment</h3>
            <div class="overflow-x-auto">
                <canvas id="chart2" height="200" class="min-w-[300px]"></canvas>
            </div>
        </div>
    </div>

    {{-- 🔹 Analisis & Konsultasi --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Hasil Analisis --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800 text-sm sm:text-base">Hasil Analisis Terbaru</h3>
            @if($latestAnalisis)
                <p class="text-gray-700 text-xs sm:text-sm mb-2">
                    Tanggal: {{ $tanggalAnalisis?->translatedFormat('d F Y H:i') ?? '-' }}
                </p>
                <span class="font-semibold text-blue-600 text-xs sm:text-base text-justify">
                    {{ $latestAnalisis->hasil_emosi }}
                </span>
            @else
                <p class="text-gray-500 text-sm">Belum ada hasil analisis.</p>
            @endif
        </div>

        {{-- Tabel Konsultasi --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800 text-sm sm:text-base">Rekaman Penanganan Konsultasi</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm text-left border min-w-[500px]">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 border">No</th>
                            <th class="px-3 sm:px-4 py-2 border">Nama Pengguna</th>
                            <th class="px-3 sm:px-4 py-2 border">Tanggal</th>
                            <th class="px-3 sm:px-4 py-2 border">Hasil Emosi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRekaman as $idx => $rek)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 border">{{ $idx + 1 }}</td>
                                <td class="px-3 sm:px-4 py-2 border">{{ $rek->user->name ?? '-' }}</td>
                                <td class="px-3 sm:px-4 py-2 border">
                                    {{ $rek->completed_at?->translatedFormat('d M Y H:i') ?? '-' }}
                                </td>
                                <td class="px-3 sm:px-4 py-2 border font-semibold">
                                    Depresi: Risiko {{ $rek->depresi_kelas ?? '-' }}<br>
                                    Anxiety: Risiko {{ $rek->anxiety_kelas ?? '-' }}<br>
                                    Stres: Risiko {{ $rek->stres_kelas ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                    Belum ada data konsultasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- 🔹 Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('chart1').getContext('2d');
    const chart1Data = @json($chart1 ?? []);
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: chart1Data.labels ?? [],
            datasets: (chart1Data.datasets ?? []).map(ds => ({
                ...ds, tension: 0.4, fill: false, borderWidth: 2
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true, max: 5 } }
        }
    });

    const ctx2 = document.getElementById('chart2').getContext('2d');
    const chart2Data = @json($chart2 ?? []);
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: chart2Data.labels ?? [],
            datasets: [{
                label: 'Skor Rata-Rata',
                data: chart2Data.data ?? [],
                backgroundColor: ['#ef4444', '#f97316', '#0ea5e9', '#22c55e']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 5 } }
        }
    });
</script>
@endsection
