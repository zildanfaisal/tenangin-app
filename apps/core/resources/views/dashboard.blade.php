@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Hero Section -->
    <div class="relative rounded-2xl overflow-hidden shadow">
        <img src="{{ asset('hero.png') }}" alt="Hero" class="w-full h-48 object-cover">
        <div class="absolute inset-0 flex flex-col justify-center px-8 text-white">
            <h2 class="text-xl font-semibold">Selamat Datang, Regi</h2>
            <p class="text-sm mt-1 max-w-md">
                Hari ini adalah kesempatan baru untuk merawat diri. Mari lihat bagaimana kondisi mental Anda dan apa yang bisa kita lakukan bersama.
            </p>
            <button class="mt-3 bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg hover:bg-blue-100 transition w-fit">
                Lakukan Assesment
            </button>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-sm">Jumlah Assesment</h3>
            <p class="text-2xl font-semibold mt-2">5</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-sm">Emosi Terbanyak</h3>
            <p class="text-2xl font-semibold mt-2 text-blue-600">Senang</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h3 class="text-gray-500 text-sm">Emosi Terakhir</h3>
            <p class="text-2xl font-semibold mt-2 text-green-600">Kecemasan Rendah</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2">Trend kondisi emosi harian</h3>
            <canvas id="chart1" height="200"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2">Hasil kondisi emosi</h3>
            <canvas id="chart2" height="200"></canvas>
        </div>
    </div>

    <!-- Analisis & Konsultasi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold text-gray-800">Hasil Analisis Terakhir</h3>
                <button class="flex items-center text-sm text-blue-600 hover:underline">
                    <i class="fa-solid fa-clock-rotate-left mr-1"></i> History
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-3">12:23 WIB, 05 Oktober 2025</p>
            <div class="text-sm text-gray-700 space-y-2 leading-relaxed">
                <p>
                    Hasil analisis bulan menunjukkan kalau kamu mengalami kecemasan ringan. Gejala seperti merasa khawatir, susah tidur, atau mudah tegang masih bisa dikendalikan dengan kebiasaan positif.
                </p>
                <p>
                    Biasanya, kecemasan muncul akibat pikiran negatif yang berulang, tekanan pekerjaan, kurang istirahat, atau faktor lingkungan. Penting untuk mengenali pemicu agar lebih mudah menanganinya.
                </p>
                <p>
                    Coba latihan relaksasi napas, olahraga ringan, atau journaling untuk menenangkan pikiran. Jika diperlukan, sesi konseling dengan psikolog juga bisa membantu menemukan solusi yang tepat.
                </p>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3 text-gray-800">Rekaman penanganan konsultasi</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Konsultan</th>
                            <th class="px-4 py-2 border">Waktu Dilakukan</th>
                            <th class="px-4 py-2 border">Hasil Emosi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">1</td>
                            <td class="px-4 py-2 border">Zidan Faisal</td>
                            <td class="px-4 py-2 border">05 Okt 2025</td>
                            <td class="px-4 py-2 border text-red-500 font-semibold">Depresi Berat</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">2</td>
                            <td class="px-4 py-2 border">Alya Putri</td>
                            <td class="px-4 py-2 border">28 Sep 2025</td>
                            <td class="px-4 py-2 border text-yellow-500 font-semibold">Kecemasan Sedang</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">3</td>
                            <td class="px-4 py-2 border">Rama Dwi</td>
                            <td class="px-4 py-2 border">21 Sep 2025</td>
                            <td class="px-4 py-2 border text-green-600 font-semibold">Tenang</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('chart1').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'],
            datasets: [
                { label: 'Kebahagiaan', borderColor: '#fde047', data: [3,4,3,4,5,4,3], tension: 0.4 },
                { label: 'Stres', borderColor: '#ef4444', data: [4,3,4,2,3,4,3], tension: 0.4 },
                { label: 'Kecemasan', borderColor: '#f97316', data: [3,3,2,3,2,3,2], tension: 0.4 },
                { label: 'Ketenangan', borderColor: '#22c55e', data: [2,3,4,3,4,3,5], tension: 0.4 },
                { label: 'Kesedihan', borderColor: '#64748b', data: [2,2,3,3,2,2,3], tension: 0.4 },
                { label: 'Fokus', borderColor: '#0ea5e9', data: [3,4,3,4,3,4,3], tension: 0.4 }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const ctx2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Kebahagiaan', 'Stres', 'Kecemasan', 'Ketenangan', 'Kesedihan', 'Fokus'],
            datasets: [{
                label: 'Jumlah',
                data: [3, 8, 2, 6, 4, 5],
                backgroundColor: ['#67e8f9', '#38bdf8', '#fb923c', '#4ade80', '#a78bfa', '#0ea5e9']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection
