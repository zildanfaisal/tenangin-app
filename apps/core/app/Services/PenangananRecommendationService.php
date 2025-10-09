<?php

namespace App\Services;

use App\Models\Dass21Session;
use App\Models\Penanganan;
use Illuminate\Support\Collection;

class PenangananRecommendationService
{
    /**
     * Generate recommended Penanganan based on DASS-21 session severity.
     */
    public function forSession(Dass21Session $session, int $limit = 4): Collection
    {
        $rank = [
            'Normal' => 0,
            'Mild' => 1,
            'Moderate' => 2,
            'Severe' => 3,
            'Extremely Severe' => 4,
        ];

        // Determine the highest severity subscale
        $subscales = [
            'depresi' => $session->depresi_kelas,
            'anxiety' => $session->anxiety_kelas,
            'stres' => $session->stres_kelas,
        ];

        $highestKey = collect($subscales)
            ->map(fn($kelas,$k) => [ 'k' => $k, 'kelas' => $kelas, 'rank' => $rank[$kelas] ?? -1 ])
            ->sortByDesc('rank')
            ->first();

        $severityRank = $highestKey['rank'] ?? 0;

        // Map highest subscale to kelompok if available
        $kelompok = match ($highestKey['k'] ?? null) {
            'depresi' => 'depresi',
            'anxiety' => 'anxiety',
            'stres' => 'stres',
            default => null
        };

        $query = Penanganan::published();
        if ($kelompok) {
            $query->where('kelompok', $kelompok);
        }

        // Adjust the number of suggestions based on severity
        if ($severityRank >= 3) { // Severe / Extremely Severe
            $limit = min($limit, 2);
        } elseif ($severityRank === 2) { // Moderate
            $limit = min($limit, 3);
        }

        return $query->orderBy('ordering')->orderBy('id')->limit($limit)->get();
    }
}
