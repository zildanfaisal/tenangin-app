<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dass21Session;
use App\Models\RekamanPenanganan;
use App\Models\Konsultan;

class DashboardController extends Controller
{
    public function index()
    {
    $user = Auth::user();

        // Statistik DASS-21
        $assesmentCount = Dass21Session::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();
        $lastSession = Dass21Session::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->first();

        // Emosi terakhir/terbanyak (sederhana: gunakan overall_risk dan kelas terbanyak based on count)
        $lastEmotion = $lastSession?->overall_risk;

        $topEmotion = Dass21Session::where('user_id', $user->id)
            ->selectRaw("overall_risk, COUNT(*) as c")
            ->whereNotNull('overall_risk')
            ->groupBy('overall_risk')
            ->orderByDesc('c')
            ->value('overall_risk');

        // Data rekaman konsultasi terbaru (join sederhana)
        $recentRekaman = RekamanPenanganan::with(['konsultan'])
            ->latest('id')
            ->limit(5)
            ->get();

        // Chart dummy fallback if no data. You can replace with real aggregates later.
        $chart1 = [
            'labels' => ['Hari 1','Hari 2','Hari 3','Hari 4','Hari 5','Hari 6','Hari 7'],
            'datasets' => [
                ['label' => 'Kebahagiaan','borderColor' => '#fde047','data' => [3,4,3,4,5,4,3]],
                ['label' => 'Stres','borderColor' => '#ef4444','data' => [4,3,4,2,3,4,3]],
                ['label' => 'Kecemasan','borderColor' => '#f97316','data' => [3,3,2,3,2,3,2]],
                ['label' => 'Ketenangan','borderColor' => '#22c55e','data' => [2,3,4,3,4,3,5]],
                ['label' => 'Kesedihan','borderColor' => '#64748b','data' => [2,2,3,3,2,2,3]],
                ['label' => 'Fokus','borderColor' => '#0ea5e9','data' => [3,4,3,4,3,4,3]],
            ],
        ];

        $chart2 = [
            'labels' => ['Kebahagiaan','Stres','Kecemasan','Ketenangan','Kesedihan','Fokus'],
            'data' => [3,8,2,6,4,5],
        ];

        return view('dashboard', compact(
            'user',
            'assesmentCount',
            'topEmotion',
            'lastEmotion',
            'lastSession',
            'recentRekaman',
            'chart1',
            'chart2'
        ));
    }
}
