@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="relative rounded-2xl overflow-hidden shadow">
        <img src="{{ asset('hero.png') }}" alt="Hero" class="w-full h-48 object-cover">
        <div class="absolute inset-0 flex flex-col justify-center px-8 text-white bg-black/30">
            <h2 class="text-xl font-semibold">Selamat Datang, {{ $user->name ?? 'Pengguna' }}</h2>
            <p class="text-sm mt-1 max-w-md">
                Mulailah hari dengan semangat baru. Lihat hasil asesmen Anda dan pantau perkembangan kesehatan mental Anda.
            </p>
            <a href="{{ route('dass21.intro') }}"
               class="mt-3 bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg hover:bg-blue-100 transition w-fit">
                Lakukan Assessment
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-sm">Total Assessment</h3>
            <p class="text-2xl font-semibold mt-2">{{ $assesmentCount ?? 0 }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
           <h3 class="text-gray-500 text-sm">Kondisi Emosi Terbanyak</h3>
            <p class="text-2xl font-semibold mt-2 text-blue-600">{{ $lastEmotion ?? '-' }}</p>

        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-sm">Kategori Dominan</h3>
            <p class="text-2xl font-semibold mt-2 text-indigo-600">
                @php
                    $dominant = collect($chart2['data'] ?? [])->max();
                    $idx = array_search($dominant, $chart2['data'] ?? []);
                    echo $chart2['labels'][$idx] ?? '-';
                @endphp
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2 text-gray-800">Tren Kondisi Emosi Harian</h3>
            <canvas id="chart1" height="200"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2 text-gray-800">Perbandingan Jumlah Assessment</h3>
            <canvas id="chart2" height="200"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800">Hasil Analisis Terbaru</h3>
            @if($latestAnalisis)
                <p class="text-gray-700 text-sm mb-2">
                    Tanggal: {{ $tanggalAnalisis?->translatedFormat('d F Y H:i') ?? '-' }}
                </p>
                    <span class="font-semibold text-blue-600">{{ $latestAnalisis->hasil_emosi }}</span>

            @else
                <p class="text-gray-500 text-sm">Belum ada hasil analisis.</p>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800">Rekaman Penanganan Konsultasi</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Pengguna</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Hasil Emosi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRekaman as $idx => $rek)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $idx + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $rek->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $rek->completed_at?->translatedFormat('d M Y H:i') ?? '-' }}</td>
                                <td class="px-4 py-2 border text-blue-600 font-semibold">{{ $rek->hasil_kelas ?? '-' }}</td>
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
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 5 } }
        }
    });
</script>
@endsection
