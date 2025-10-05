<?php

namespace App\Services;

use App\Models\Dass21Session;

class Dass21ScoringService
{
    protected array $rankMap = [
        'Normal' => 0,
        'Mild' => 1,
        'Moderate' => 2,
        'Severe' => 3,
        'Extremely Severe' => 4,
    ];
    public function classify(string $type, int $score): string
    {
        $map = [
            'depresi' => [
                [0,9,'Normal'], [10,13,'Mild'], [14,20,'Moderate'], [21,27,'Severe'], [28,999,'Extremely Severe'],
            ],
            'anxiety' => [
                [0,7,'Normal'], [8,9,'Mild'], [10,14,'Moderate'], [15,19,'Severe'], [20,999,'Extremely Severe'],
            ],
            'stres' => [
                [0,14,'Normal'], [15,18,'Mild'], [19,25,'Moderate'], [26,33,'Severe'], [34,999,'Extremely Severe'],
            ],
        ];
        foreach ($map[$type] as [$min,$max,$label]) {
            if ($score >= $min && $score <= $max) return $label;
        }
        return 'Unknown';
    }

    public function finalize(Dass21Session $session): Dass21Session
    {
        $responses = $session->responses()->with('item')->get();
        $raw = ['depresi' => 0, 'anxiety' => 0, 'stres' => 0];
        foreach ($responses as $r) {
            $raw[$r->item->subskala] += $r->nilai;
        }
        $session->depresi_raw = $raw['depresi'];
        $session->anxiety_raw = $raw['anxiety'];
        $session->stres_raw = $raw['stres'];
        $session->depresi_skor = $raw['depresi'] * 2;
        $session->anxiety_skor = $raw['anxiety'] * 2;
        $session->stres_skor = $raw['stres'] * 2;
        $session->total_skor = $session->depresi_skor + $session->anxiety_skor + $session->stres_skor;
        $session->depresi_kelas = $this->classify('depresi', $session->depresi_skor);
        $session->anxiety_kelas = $this->classify('anxiety', $session->anxiety_skor);
        $session->stres_kelas = $this->classify('stres', $session->stres_skor);
        $session->hasil_kelas = 'D:'.$session->depresi_kelas.' / A:'.$session->anxiety_kelas.' / S:'.$session->stres_kelas;

        // Overall risk heuristic classification
        [$risk,$note] = $this->overallRisk([
            'depresi' => $session->depresi_kelas,
            'anxiety' => $session->anxiety_kelas,
            'stres'   => $session->stres_kelas,
        ]);
        $session->overall_risk = $risk;
        $session->overall_risk_note = $note;
        $session->completed_at = now();
        $session->save();
        return $session;
    }

    protected function overallRisk(array $labels): array
    {
        $ranks = array_map(fn($l)=>$this->rankMap[$l] ?? 0, $labels);
        $max = max($ranks);
        $countSevere = collect($ranks)->filter(fn($r)=>$r===3)->count();
        $countModerate = collect($ranks)->filter(fn($r)=>$r===2)->count();

        $risk = 'Low';
        $note = 'Semua subskala berada pada kategori normal.';
        if ($max === 4) {
            $risk = 'High Risk';
            $note = 'Ada subskala Extremely Severe; rekomendasi evaluasi profesional.';
        } elseif ($max === 3 && ($countModerate >= 1 || $countSevere > 1)) {
            $risk = 'High Risk';
            $note = 'Kombinasi Severe dengan Moderate/Severe lain meningkatkan risiko keseluruhan.';
        } elseif ($max === 3) {
            $risk = 'Moderate-High';
            $note = 'Satu subskala Severe; pantau dan pertimbangkan konsultasi.';
        } elseif ($max === 2) {
            $risk = 'Moderate';
            $note = 'Minimal satu subskala Moderate hadir.';
        } elseif ($max === 1) {
            $risk = 'Mild';
            $note = 'Gejala ringan pada salah satu subskala.';
        }
        return [$risk,$note];
    }
}
