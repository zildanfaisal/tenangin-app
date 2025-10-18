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

        $latestAnalisis = Analisis::where('user_id', $user->id)->latest('id')->first();
        $lastSuara = Suara::where('user_id', $user->id)->latest('created_at')->first();

        $tanggalAnalisis = $lastSuara?->created_at
            ? Carbon::parse($lastSuara->created_at)->setTimezone('Asia/Jakarta')
            : null;

        $latestSession = (clone $query)->latest('completed_at')->first();

        $highestRiskEmotion = $this->getHighestRiskEmotion($query);

        $lastEmotion = $latestSession
            ? "Depresi: " . ($latestSession->depresi_kelas ?? '-') .
              ", Kecemasan: " . ($latestSession->anxiety_kelas ?? '-') .
              ", Stres: " . ($latestSession->stres_kelas ?? '-') : '-';

        $chart1 = $this->getChart1Data($query);
        $chart2 = $this->getChart2Data($query);

        $recentRekaman = (clone $query)
            ->where('user_id', $user->id)
            ->latest('completed_at')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'user',
            'assesmentCount',
            'highestRiskEmotion',
            'lastEmotion',
            'tanggalAnalisis',
            'chart1',
            'chart2',
            'recentRekaman',
            'latestAnalisis'
        ));
    }

    private function getHighestRiskEmotion($query)
    {
        $rank = [
            'Normal' => 0,
            'Risiko Ringan' => 1,
            'Risiko Sedang' => 2,
            'Risiko Parah' => 3,
            'Risiko Sangat Parah' => 4,
        ];

        $emotionMap = [
            'depresi_kelas' => 'Depresi',
            'stres_kelas' => 'Stres',
            'anxiety_kelas' => 'Kecemasan',
        ];

        $highestScore = -1;
        $mostFrequent = '-';
        foreach ($query->get() as $session) {
            foreach ($emotionMap as $key => $label) {
                $score = $rank[$session->$key ?? 'Normal'] ?? 0;
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $mostFrequent = $label . ' (' . ($session->$key ?? '-') . ')';
                }
            }
        }

        return $mostFrequent;
    }

    private function getChart1Data($query)
    {
        $sessions = (clone $query)->get();

        if ($sessions->isEmpty()) {
            return [
                'labels' => ['Tidak Ada Data'],
                'datasets' => [[
                    'label' => 'Data Kosong',
                    'data' => [0],
                    'borderColor' => '#9ca3af',
                    'backgroundColor' => '#d1d5db',
                ]]
            ];
        }

        $grouped = $sessions->groupBy(function ($s) {
            return Carbon::parse($s->completed_at)->format('d M Y');
        });

        $labels = $grouped->keys()->values()->toArray(); // ✅ ubah ke array
        $depresiCounts = [];
        $stresCounts = [];
        $anxietyCounts = [];
        $bahagiaCounts = [];

        foreach ($grouped as $date => $items) {
            $depresiCounts[] = $items->where('depresi_kelas', '!=', 'Normal')->count();
            $stresCounts[] = $items->where('stres_kelas', '!=', 'Normal')->count();
            $anxietyCounts[] = $items->where('anxiety_kelas', '!=', 'Normal')->count();

            // ✅ Bahagia = hasil Normal ATAU semua kategori Normal
            $bahagiaCounts[] = $items->filter(function ($s) {
                $isHasilNormal = ($s->hasil_kelas ?? '') === 'Normal';
                $allNormal = (
                    ($s->depresi_kelas ?? '') === 'Normal' &&
                    ($s->stres_kelas ?? '') === 'Normal' &&
                    ($s->anxiety_kelas ?? '') === 'Normal'
                );
                return $isHasilNormal || $allNormal;
            })->count();
        }

        // ✅ tambahkan dummy nol jika hanya 1 tanggal
        if (count($labels) === 1) {
            $firstDate = Carbon::parse($sessions->first()->completed_at)->subDay()->format('d M Y');
            array_unshift($labels, $firstDate);
            array_unshift($depresiCounts, 0);
            array_unshift($stresCounts, 0);
            array_unshift($anxietyCounts, 0);
            array_unshift($bahagiaCounts, 0);
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Depresi',
                    'data' => $depresiCounts,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => '#fecaca',
                    'fill' => false,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Stres',
                    'data' => $stresCounts,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => '#fde68a',
                    'fill' => false,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Kecemasan',
                    'data' => $anxietyCounts,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#bfdbfe',
                    'fill' => false,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Bahagia',
                    'data' => $bahagiaCounts,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => '#bbf7d0',
                    'fill' => false,
                    'tension' => 0.3,
                ],
            ]
        ];
    }

    private function getChart2Data($query)
    {
        $sessions = (clone $query)->get();

        if ($sessions->isEmpty()) {
            return [
                'labels' => ['Depresi', 'Stres', 'Kecemasan', 'Bahagia'],
                'data' => [0, 0, 0, 0],
            ];
        }

        $totalDepresi = $sessions->where('depresi_kelas', '!=', 'Normal')->count();
        $totalStres = $sessions->where('stres_kelas', '!=', 'Normal')->count();
        $totalAnxiety = $sessions->where('anxiety_kelas', '!=', 'Normal')->count();

        $totalBahagia = $sessions->filter(function ($s) {
            $isHasilNormal = ($s->hasil_kelas ?? '') === 'Normal';
            $allNormal = (
                ($s->depresi_kelas ?? '') === 'Normal' &&
                ($s->stres_kelas ?? '') === 'Normal' &&
                ($s->anxiety_kelas ?? '') === 'Normal'
            );
            return $isHasilNormal || $allNormal;
        })->count();

        return [
            'labels' => ['Depresi', 'Stres', 'Kecemasan', 'Bahagia'],
            'data' => [$totalDepresi, $totalStres, $totalAnxiety, $totalBahagia]
        ];
    }
}
