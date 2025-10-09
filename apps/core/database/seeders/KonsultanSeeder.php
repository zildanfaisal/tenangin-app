<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konsultan;

class KonsultanSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama_konsultan' => 'Dr. Andi Pratama, M.Psi., Psikolog',
                'foto' => null,
                'deskripsi' => 'Psikolog klinis dengan fokus pada terapi kognitif perilaku (CBT) untuk kecemasan dan depresi.',
                'spesialisasi' => 'Psikolog Klinis',
                'pengalaman' => 8,
                'jadwal_praktik' => 'Senin-Jumat 09:00-17:00 WIB',
                'harga' => 200000,
                'rating' => 4.8,
            ],
            [
                'nama_konsultan' => 'Nadia Kusuma, S.Psi., M.Psi',
                'foto' => null,
                'deskripsi' => 'Berpengalaman menangani stres kerja dan burnout, menggunakan pendekatan mindfulness & ACT.',
                'spesialisasi' => 'Kesehatan Mental Kerja',
                'pengalaman' => 6,
                'jadwal_praktik' => 'Selasa-Kamis 13:00-20:00 WIB',
                'harga' => 180000,
                'rating' => 4.7,
            ],
            [
                'nama_konsultan' => 'Budi Santoso, M.Psi., Psikolog',
                'foto' => null,
                'deskripsi' => 'Fokus pada intervensi kecemasan sosial dan peningkatan keterampilan komunikasi.',
                'spesialisasi' => 'Kecemasan Sosial',
                'pengalaman' => 5,
                'jadwal_praktik' => 'Rabu-Sabtu 10:00-18:00 WIB',
                'harga' => 150000,
                'rating' => 4.6,
            ],
            [
                'nama_konsultan' => 'dr. Rina Astuti, Sp.KJ',
                'foto' => null,
                'deskripsi' => 'Spesialis kejiwaan, kolaborasi terapi dan farmakoterapi sesuai kebutuhan pasien.',
                'spesialisasi' => 'Psikiatri',
                'pengalaman' => 10,
                'jadwal_praktik' => 'Senin, Rabu, Jumat 16:00-21:00 WIB',
                'harga' => 300000,
                'rating' => 4.9,
            ],
            [
                'nama_konsultan' => 'Sari Dewi, S.Psi',
                'foto' => null,
                'deskripsi' => 'Konselor dengan pendekatan solution-focused brief therapy untuk masalah hubungan.',
                'spesialisasi' => 'Konseling Relasi',
                'pengalaman' => 4,
                'jadwal_praktik' => 'Kamis-Minggu 12:00-20:00 WIB',
                'harga' => 120000,
                'rating' => 4.5,
            ],
        ];

        foreach ($items as $it) {
            Konsultan::updateOrCreate(
                ['nama_konsultan' => $it['nama_konsultan']],
                $it
            );
        }
    }
}
