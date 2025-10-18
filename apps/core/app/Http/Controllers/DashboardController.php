<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Dass21Session;
use App\Models\Analisis;
use App\Models\Suara;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Dass21Session::whereNotNull('completed_at');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $assesmentCount = $query->count();

        // 🔹 ambil analisis & suara terbaru
        $latestAnalisis = Analisis::where('user_id', $user->id)
            ->latest('id')
            ->first();

        $lastSuara = Suara::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $tanggalAnalisis = $lastSuara?->created_at;

        // 🔹 hitung kondisi emosi terbanyak (dari hasil_kelas)
        $mostFrequentEmotion = $query->pluck('hasil_kelas')
            ->filter()
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first();

        $lastEmotion = $mostFrequentEmotion ?? '-';

        // 🔹 riwayat asesmen 5 terakhir
        $riwayat = (clone $query)
            ->select('id', 'completed_at', 'hasil_kelas', 'depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->latest('completed_at')
            ->take(5)
            ->get();

        // 🔹 FIX: Panggil method yang sudah diperbaiki
        $chart1 = $this->getChart1Data($query);
        $chart2 = $this->getChart2Data($query, $assesmentCount);

        $recentRekaman = Dass21Session::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->select('id', 'user_id', 'completed_at', 'hasil_kelas', 'depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->latest('completed_at')
            ->take(8)
            ->get();

        return view('dashboard', compact(
            'user',
            'assesmentCount',
            'lastEmotion',
            'tanggalAnalisis',
            'chart1',
            'chart2',
            'riwayat',
            'recentRekaman',
            'latestAnalisis'
        ));
    }

    private function getChart1Data($query)
    {
        $kategoriMap = [
            'Normal' => 1,
            'Mild' => 2,
            'Moderate' => 3,
            'Severe' => 4,
            'Extremely Severe' => 5,
        ];

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // 🔹 FIX: Ambil semua data dalam range tanggal tanpa grouping yang terlalu ketat
        $rawData = (clone $query)
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->select('completed_at', 'depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->orderBy('completed_at')
            ->get();

        // 🔹 Inisialisasi array untuk 7 hari terakhir
        $labels = [];
        $depresiData = array_fill(0, 7, 0);
        $stresData = array_fill(0, 7, 0);
        $anxietyData = array_fill(0, 7, 0);
        $bahagiaData = array_fill(0, 7, 0);

        // 🔹 Generate labels untuk 7 hari terakhir
        foreach (range(0, 6) as $i) {
            $date = $startDate->copy()->addDays($i);
            $labels[] = $date->translatedFormat('l');
        }

        // 🔹 FIX: Jika ada data, proses per hari
        if ($rawData->count() > 0) {
            $groupedByDay = [];

            // Kelompokkan data berdasarkan hari
            foreach ($rawData as $data) {
                $dayIndex = Carbon::parse($data->completed_at)->diffInDays($startDate);
                if ($dayIndex >= 0 && $dayIndex <= 6) {
                    if (!isset($groupedByDay[$dayIndex])) {
                        $groupedByDay[$dayIndex] = [];
                    }
                    $groupedByDay[$dayIndex][] = $data;
                }
            }

            // 🔹 Hitung rata-rata per hari
            foreach ($groupedByDay as $dayIndex => $dayData) {
                $totalItems = count($dayData);

                $totalDepresi = 0;
                $totalStres = 0;
                $totalAnxiety = 0;
                $bahagiaCount = 0;

                foreach ($dayData as $data) {
                    $totalDepresi += $kategoriMap[$data->depresi_kelas] ?? 0;
                    $totalStres += $kategoriMap[$data->stres_kelas] ?? 0;
                    $totalAnxiety += $kategoriMap[$data->anxiety_kelas] ?? 0;

                    // Hitung kondisi bahagia (semua normal)
                    if (($data->depresi_kelas === 'Normal') &&
                        ($data->stres_kelas === 'Normal') &&
                        ($data->anxiety_kelas === 'Normal')) {
                        $bahagiaCount++;
                    }
                }

                $depresiData[$dayIndex] = $totalItems > 0 ? round($totalDepresi / $totalItems, 2) : 0;
                $stresData[$dayIndex] = $totalItems > 0 ? round($totalStres / $totalItems, 2) : 0;
                $anxietyData[$dayIndex] = $totalItems > 0 ? round($totalAnxiety / $totalItems, 2) : 0;
                $bahagiaData[$dayIndex] = $totalItems > 0 ? round(($bahagiaCount / $totalItems) * 5, 2) : 0;
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Depresi',
                    'borderColor' => '#ef4444',
                    'backgroundColor' => '#ef4444',
                    'data' => $depresiData
                ],
                [
                    'label' => 'Stres',
                    'borderColor' => '#f97316',
                    'backgroundColor' => '#f97316',
                    'data' => $stresData
                ],
                [
                    'label' => 'Kecemasan',
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => '#0ea5e9',
                    'data' => $anxietyData
                ],
                [
                    'label' => 'Bahagia',
                    'borderColor' => '#22c55e',
                    'backgroundColor' => '#22c55e',
                    'data' => $bahagiaData
                ],
            ],
        ];
    }

    private function getChart2Data($query, $assesmentCount)
    {
        $kategoriMap = [
            'Normal' => 1,
            'Mild' => 2,
            'Moderate' => 3,
            'Severe' => 4,
            'Extremely Severe' => 5,
        ];

        $allData = (clone $query)
            ->select('depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->get();

        // 🔹 Default values
        $avgDepresi = 0;
        $avgStres = 0;
        $avgAnxiety = 0;
        $avgBahagia = 0;

        if ($allData->count() > 0) {
            $totalDepresi = 0;
            $totalStres = 0;
            $totalAnxiety = 0;
            $normalCount = 0;

            foreach ($allData as $data) {
                $totalDepresi += $kategoriMap[$data->depresi_kelas] ?? 0;
                $totalStres += $kategoriMap[$data->stres_kelas] ?? 0;
                $totalAnxiety += $kategoriMap[$data->anxiety_kelas] ?? 0;

                if (($data->depresi_kelas === 'Normal') &&
                    ($data->stres_kelas === 'Normal') &&
                    ($data->anxiety_kelas === 'Normal')) {
                    $normalCount++;
                }
            }

            $avgDepresi = round($totalDepresi / $allData->count(), 2);
            $avgStres = round($totalStres / $allData->count(), 2);
            $avgAnxiety = round($totalAnxiety / $allData->count(), 2);
            $avgBahagia = $normalCount > 0 ? round(($normalCount / $allData->count()) * 5, 2) : 0;
        }

        return [
            'labels' => ['Depresi', 'Stres', 'Kecemasan', 'Bahagia'],
            'data' => [$avgDepresi, $avgStres, $avgAnxiety, $avgBahagia],
        ];
    }
}
