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

        <div class="bg-white shadow-md rounded-2xl p-6 text-center hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm sm:text-base font-medium mb-2">Total Assessment</h3>
            <p class="text-3xl sm:text-4xl font-semibold text-gray-800">{{ $assesmentCount ?? 0 }}</p>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-6 text-center hover:shadow-lg transition">
            <h3 class="text-gray-500 text-sm sm:text-base font-medium mb-2">Kondisi Emosi Tertinggi</h3>
            <p class="text-2xl font-semibold sm:text-3xl text-gray-800 mt-1">
                {{ $highestRiskEmotion ?? '-' }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 shadow-md rounded-2xl p-6 text-center border border-cyan-100 hover:shadow-lg transition">
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
            <div class="relative h-64">
                <canvas id="chart1"></canvas>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2 text-gray-800 text-sm sm:text-base">Perbandingan Jumlah Assessment</h3>
            <div class="relative h-64">
                <canvas id="chart2"></canvas>
            </div>
        </div>
    </div>

    {{-- 🔹 Analisis & Konsultasi --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800 text-sm sm:text-base">Hasil Analisis Terbaru</h3>

            @if($latestAnalisis)
                <p class="text-gray-700 text-xs sm:text-sm mb-2">
                    Tanggal: {{ $tanggalAnalisis?->translatedFormat('d F Y H:i') ?? '-' }} WIB
                </p>

                @php
                    // Ambil hanya 3 kalimat pertama dari hasil_emosi
                    $text = $latestAnalisis->hasil_emosi;
                    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
                    $shortened = implode(' ', array_slice($sentences, 0, 8));
                    if (count($sentences) > 3) $shortened .= '...';
                @endphp

                <p class="text-blue-600 text-sm sm:text-base font-medium leading-relaxed text-justify">
                    {{ $shortened }}
                </p>
            @else
                <p class="text-gray-500 text-sm italic">Belum ada hasil analisis.</p>
            @endif
        </div>


        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800 text-sm sm:text-base">Rekaman Penanganan Konsultasi</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm text-left border min-w-[500px]">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-3 py-2 border">No</th>
                            <th class="px-3 py-2 border">Nama Pengguna</th>
                            <th class="px-3 py-2 border">Tanggal</th>
                            <th class="px-3 py-2 border">Hasil Emosi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRekaman as $idx => $rek)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 border">{{ $idx + 1 }}</td>
                                <td class="px-3 py-2 border">{{ $rek->user->name ?? '-' }}</td>
                                <td class="px-3 py-2 border">
                                    {{ $rek->completed_at?->setTimezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') ?? '-' }} WIB
                                </td>
                                <td class="px-3 py-2 border font-semibold">
                                    Depresi: Risiko {{ $rek->depresi_kelas ?? '-' }}<br>
                                    Anxiety: Risiko {{ $rek->anxiety_kelas ?? '-' }}<br>
                                    Stres: Risiko {{ $rek->stres_kelas ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">Belum ada data konsultasi.</td>
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
document.addEventListener("DOMContentLoaded", () => {
    const chart1Data = @json($chart1 ?? []);
    const chart2Data = @json($chart2 ?? []);

    // Chart 1 - Line
    new Chart(document.getElementById('chart1'), {
        type: 'line',
        data: chart1Data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            spanGaps: true,
            showLine: true,
            elements: {
                line: {
                    borderWidth: 2,
                    tension: 0.3
                },
                point: {
                    radius: 5,
                    hitRadius: 10,
                    hoverRadius: 6
                }
            },
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.dataset.label}: ${ctx.formattedValue} kali`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Chart 2 - Bar
    new Chart(document.getElementById('chart2'), {
        type: 'bar',
        data: {
            labels: chart2Data.labels,
            datasets: [{
                label: 'Jumlah',
                data: chart2Data.data,
                backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6', '#22c55e'],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.formattedValue} kali`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>
@endsection
