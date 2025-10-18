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

        // 🔹 Ambil analisis & suara terbaru
        $latestAnalisis = Analisis::where('user_id', $user->id)
            ->latest('id')
            ->first();

        $lastSuara = Suara::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        // 🔹 Format ke zona waktu Jakarta
        $tanggalAnalisis = $lastSuara?->created_at
            ? Carbon::parse($lastSuara->created_at)->setTimezone('Asia/Jakarta')
            : null;

        // 🔹 Ambil asesmen terakhir
        $latestSession = (clone $query)
            ->latest('completed_at')
            ->first();

        // 🔹 Hitung kondisi emosi dengan tingkat risiko tertinggi (parah)
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

        $mostFrequent = null;
        $highestScore = -1;

        foreach ($query->get() as $session) {
            foreach ($emotionMap as $key => $label) {
                $val = $session->$key ?? 'Normal';
                $score = $rank[$val] ?? 0;
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $mostFrequent = $label . ' (' . $val . ')';
                }
            }
        }

        $highestRiskEmotion = $mostFrequent ?? '-';

        // 🔹 Kondisi emosi terakhir (dari asesmen terakhir)
        $lastEmotion = $latestSession
            ? "Depresi: " . ($latestSession->depresi_kelas ?? '-') .
              ", Kecemasan: " . ($latestSession->anxiety_kelas ?? '-') .
              ", Stres: " . ($latestSession->stres_kelas ?? '-')
            : '-';

        // 🔹 Riwayat asesmen 5 terakhir
        $riwayat = (clone $query)
            ->select('id', 'completed_at', 'hasil_kelas', 'depresi_kelas', 'stres_kelas', 'anxiety_kelas')
            ->latest('completed_at')
            ->take(5)
            ->get();

        // 🔹 Chart data
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
            'highestRiskEmotion',
            'lastEmotion',
            'tanggalAnalisis',
            'chart1',
            'chart2',
            'riwayat',
            'recentRekaman',
            'latestAnalisis'
        ));
    }

    // Chart data tetap sama...
    private function getChart1Data($query) { /* ... */ }
    private function getChart2Data($query, $assesmentCount) { /* ... */ }
}
