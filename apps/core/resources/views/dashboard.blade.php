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
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

        {{-- 🔹 Total Assessment --}}
        <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm sm:text-base font-medium mb-2">Total Assessment</h3>
            <p class="text-3xl sm:text-4xl font-semibold  text-gray-800">{{ $assesmentCount ?? 0 }}</p>
        </div>

        {{-- 🔹 Kondisi Emosi Tertinggi --}}
        <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm sm:text-base font-medium mb-2">Kondisi Emosi Tertinggi</h3>
            <p class="text-2xl font-semibold sm:text-3xl text-gray-800 mt-1">
                {{ $highestRiskEmotion ?? '-' }}
            </p>
        </div>

        {{-- 🔹 Kondisi Emosi Terakhir --}}
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 shadow-md rounded-2xl p-6 border border-cyan-100 flex flex-col items-center justify-center text-center hover:shadow-lg transition">
            <h3 class="text-gray-600 text-sm sm:text-base font-medium mb-2">Kondisi Emosi Terakhir</h3>
            <div class="mt-1 space-y-1">
                @if($lastEmotion && $lastEmotion !== '-')
                    @php
                        $parts = explode(',', $lastEmotion);
                    @endphp
                    @foreach($parts as $p)
                        <p class="text-sm sm:text-base text-gray-800 font-semibold leading-relaxed">
                            {{ trim($p) }}
                        </p>
                    @endforeach
                @else
                    <p class="text-gray-500 text-sm italic">Belum ada data</p>
                @endif
            </div>
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
                                    {{ $rek->completed_at?->setTimezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') ?? '-' }} WIB
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
    // 🔹 Debug: Lihat data yang dikirim dari controller
    console.log('Chart1 Data:', @json($chart1));
    console.log('Chart2 Data:', @json($chart2));

    // 🔹 Chart 1 - Tren Harian
    const ctx1 = document.getElementById('chart1');
    if (ctx1) {
        const chart1Data = @json($chart1 ?? []);

        // Pastikan data ada struktur yang benar
        const validatedData = {
            labels: chart1Data.labels || ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            datasets: (chart1Data.datasets || []).map(dataset => ({
                label: dataset.label || '',
                borderColor: dataset.borderColor || '#000000',
                backgroundColor: dataset.backgroundColor || '#000000',
                data: Array.isArray(dataset.data) ? dataset.data : Array(7).fill(0),
                tension: 0.4,
                fill: false,
                borderWidth: 2
            }))
        };

        new Chart(ctx1, {
            type: 'line',
            data: validatedData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // 🔹 Chart 2 - Perbandingan
    const ctx2 = document.getElementById('chart2');
    if (ctx2) {
        const chart2Data = @json($chart2 ?? []);

        const validatedData2 = {
            labels: chart2Data.labels || ['Depresi', 'Stres', 'Kecemasan', 'Bahagia'],
            datasets: [{
                label: 'Skor Rata-Rata',
                data: Array.isArray(chart2Data.data) ? chart2Data.data : [0, 0, 0, 0],
                backgroundColor: ['#ef4444', '#f97316', '#0ea5e9', '#22c55e'],
                borderColor: ['#dc2626', '#ea580c', '#0284c7', '#16a34a'],
                borderWidth: 1
            }]
        };

        new Chart(ctx2, {
            type: 'bar',
            data: validatedData2,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
