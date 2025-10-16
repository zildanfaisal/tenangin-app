<?php

namespace Database\Seeders;

use App\Models\Dass21Session;
use App\Models\User;
use App\Services\Dass21ScoringService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Dass21SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('user')->get();

        $kelasList = [
            ['depresi_kelas' => 'Extremely Severe', 'anxiety_kelas' => 'Normal', 'stres_kelas' => 'Normal'],
            ['depresi_kelas' => 'Normal', 'anxiety_kelas' => 'Severe', 'stres_kelas' => 'Normal'],
            ['depresi_kelas' => 'Normal', 'anxiety_kelas' => 'Normal', 'stres_kelas' => 'Severe'],
            ['depresi_kelas' => 'Mild', 'anxiety_kelas' => 'Mild', 'stres_kelas' => 'Mild'],
            ['depresi_kelas' => 'Moderate', 'anxiety_kelas' => 'Moderate', 'stres_kelas' => 'Moderate'],
        ];

        $depresiRange = [
            'Normal' => [0,9], 'Mild' => [10,13], 'Moderate' => [14,20], 'Severe' => [21,27], 'Extremely Severe' => [28,34]
        ];
        $anxietyRange = [
            'Normal' => [0,7], 'Mild' => [8,9], 'Moderate' => [10,14], 'Severe' => [15,19], 'Extremely Severe' => [20,24]
        ];
        $stresRange = [
            'Normal' => [0,14], 'Mild' => [15,18], 'Moderate' => [19,25], 'Severe' => [26,33], 'Extremely Severe' => [34,40]
        ];

        $scoring = new Dass21ScoringService();

        foreach ($users as $i => $user) {
            for ($j = 0; $j < 3; $j++) {
                $kelas = $kelasList[($i + $j) % count($kelasList)];

                $depresi_skor = rand(...$depresiRange[$kelas['depresi_kelas']]);
                $anxiety_skor = rand(...$anxietyRange[$kelas['anxiety_kelas']]);
                $stres_skor = rand(...$stresRange[$kelas['stres_kelas']]);

                $session = new Dass21Session();
                $session->user_id = $user->id;
                $session->depresi_raw = intdiv($depresi_skor, 2);
                $session->anxiety_raw = intdiv($anxiety_skor, 2);
                $session->stres_raw = intdiv($stres_skor, 2);
                $session->depresi_skor = $depresi_skor;
                $session->anxiety_skor = $anxiety_skor;
                $session->stres_skor = $stres_skor;
                $session->total_skor = $depresi_skor + $anxiety_skor + $stres_skor;
                $session->depresi_kelas = $scoring->classify('depresi', $depresi_skor);
                $session->anxiety_kelas = $scoring->classify('anxiety', $anxiety_skor);
                $session->stres_kelas = $scoring->classify('stres', $stres_skor);
                $session->hasil_kelas = 'D:'.$session->depresi_kelas.' / A:'.$session->anxiety_kelas.' / S:'.$session->stres_kelas;
                // akses protected method via closure
                $overallRisk = function(array $labels) {
                    $ranks = array_map(fn($l)=>["Normal"=>0,"Mild"=>1,"Moderate"=>2,"Severe"=>3,"Extremely Severe"=>4][$l] ?? 0, $labels);
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
                };
                [$risk, $note] = $overallRisk([
                    'depresi' => $session->depresi_kelas,
                    'anxiety' => $session->anxiety_kelas,
                    'stres'   => $session->stres_kelas,
                ]);
                $session->overall_risk = $risk;
                $session->overall_risk_note = $note;
                $session->completed_at = now()->subDays(3 - $j);
                $session->save();
            }
        }
    }
}
