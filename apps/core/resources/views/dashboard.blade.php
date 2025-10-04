@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Card Chart -->
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="font-bold mb-2">Grafik Mood</h3>
        <canvas id="chart1"></canvas>
    </div>
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="font-bold mb-2">Distribusi Emosi</h3>
        <canvas id="chart2"></canvas>
    </div>
</div>

<div class="mt-6 bg-white shadow rounded-lg p-6">
    <h3 class="font-bold mb-2">Hasil Analisis</h3>
    <p>
        Hasil analisis bulan ini menunjukkan bahwa Anda mengalami gejala kecemasan...
    </p>
</div>
@endsection
