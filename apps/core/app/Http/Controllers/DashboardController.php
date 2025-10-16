<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Dass21Session;
use App\Models\Penanganan;
use App\Models\RekamanPenanganan;
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
        $lastSession = (clone $query)->latest('completed_at')->first();
        $lastEmotion = $lastSession?->hasil_kelas ?? '-';

        $riwayat = (clone $query)
            ->select('id', 'completed_at', 'hasil_kelas', 'depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->latest('completed_at')
            ->take(5)
            ->get();

        $kategoriMap = [
            'Normal' => 1,
            'Mild' => 2,
            'Moderate' => 3,
            'Severe' => 4,
            'Extremely Severe' => 5,
        ];

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $rawData = (clone $query)
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->select('completed_at', 'depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->orderBy('completed_at')
            ->get();

        $grouped = $rawData->groupBy(fn($row) => Carbon::parse($row->completed_at)->toDateString())
            ->map(function ($day) use ($kategoriMap) {
                $avgDepresi = $day->avg(fn($d) => $kategoriMap[$d->depresi_kelas] ?? 0);
                $avgStres = $day->avg(fn($d) => $kategoriMap[$d->stres_kelas] ?? 0);
                $avgAnxiety = $day->avg(fn($d) => $kategoriMap[$d->anxiety_kelas] ?? 0);
                $bahagia = $day->filter(fn($r) =>
                    $r->depresi_kelas === 'Normal' &&
                    $r->stres_kelas === 'Normal' &&
                    $r->anxiety_kelas === 'Normal'
                )->count();
                $bahagiaScore = $bahagia > 0 ? min(5, ($bahagia / $day->count()) * 5) : 0;
                return [
                    'depresi' => $avgDepresi,
                    'stres' => $avgStres,
                    'anxiety' => $avgAnxiety,
                    'bahagia' => $bahagiaScore
                ];
            });

        $labels = [];
        $dep = [];
        $str = [];
        $anx = [];
        $bah = [];

        foreach (range(0, 6) as $i) {
            $date = $startDate->copy()->addDays($i);
            $labels[] = $date->translatedFormat('l');
            $hari = $grouped[$date->toDateString()] ?? ['depresi' => 0, 'stres' => 0, 'anxiety' => 0, 'bahagia' => 0];
            $dep[] = round($hari['depresi'], 2);
            $str[] = round($hari['stres'], 2);
            $anx[] = round($hari['anxiety'], 2);
            $bah[] = round($hari['bahagia'], 2);
        }

        $chart1 = [
            'labels' => $labels,
            'datasets' => [
                ['label' => 'Depresi', 'borderColor' => '#ef4444', 'backgroundColor' => '#ef4444', 'data' => $dep],
                ['label' => 'Stres', 'borderColor' => '#f97316', 'backgroundColor' => '#f97316', 'data' => $str],
                ['label' => 'Kecemasan', 'borderColor' => '#0ea5e9', 'backgroundColor' => '#0ea5e9', 'data' => $anx],
                ['label' => 'Bahagia', 'borderColor' => '#22c55e', 'backgroundColor' => '#22c55e', 'data' => $bah],
            ],
        ];

        $allData = (clone $query)
            ->select('depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->get();

        $avgDepresi = $allData->avg(fn($r) => $kategoriMap[$r->depresi_kelas] ?? 0);
        $avgStres = $allData->avg(fn($r) => $kategoriMap[$r->stres_kelas] ?? 0);
        $avgAnxiety = $allData->avg(fn($r) => $kategoriMap[$r->anxiety_kelas] ?? 0);
        $normalCount = $allData->filter(fn($r) =>
            $r->depresi_kelas === 'Normal' &&
            $r->stres_kelas === 'Normal' &&
            $r->anxiety_kelas === 'Normal'
        )->count();
        $avgBahagia = $normalCount > 0 ? min(5, ($normalCount / max(1, $assesmentCount)) * 5) : 0;

        $chart2 = [
            'labels' => ['Depresi', 'Stres', 'Kecemasan', 'Bahagia'],
            'data' => [
                round($avgDepresi, 2),
                round($avgStres, 2),
                round($avgAnxiety, 2),
                round($avgBahagia, 2),
            ],
        ];

        $penanganan = Penanganan::published()
            ->orderBy('ordering')
            ->orderByDesc('id')
            ->get();

        $recentRekaman = RekamanPenanganan::with('konsultan')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'assesmentCount',
            'lastEmotion',
            'chart1',
            'chart2',
            'riwayat',
            'penanganan',
            'recentRekaman'
        ));
    }
}
