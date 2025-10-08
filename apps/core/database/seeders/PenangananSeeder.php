<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penanganan;

class PenangananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_penanganan' => 'Calm Breath',
                'slug' => 'calm-breath',
                'deskripsi_penanganan' => 'Latihan pernapasan ritmis untuk menurunkan ketegangan dan meningkatkan fokus tenang.',
                'tahapan_penanganan' => implode("\n", [
                    'Duduk tegak di kursi atau lantai dengan punggung rileks',
                    'Tarik napas perlahan lewat hidung selama 4 detik',
                    'Tahan napas 2 detik tanpa tegang',
                    'Hembuskan perlahan lewat mulut selama 6 detik',
                    'Ulangi pola 10–15 kali atau hingga lebih tenang'
                ]),
                'tutorial_penanganan' => 'Fokuskan perhatian pada aliran udara. Jika pikiran melayang, kembalikan ke sensasi napas.',
                'video_penanganan' => null,
                'status' => 'published',
                'durasi_detik' => 300,
                'tingkat_kesulitan' => 'mudah',
                'ordering' => 1,
            ],
            [
                'nama_penanganan' => 'Grounding 5-4-3-2-1',
                'slug' => 'grounding-5-4-3-2-1',
                'deskripsi_penanganan' => 'Teknik grounding sensorik untuk meredakan kecemasan dengan mengembalikan fokus ke saat ini.',
                'tahapan_penanganan' => implode("\n", [
                    'Sebutkan 5 hal yang bisa kamu LIHAT',
                    'Sebutkan 4 hal yang bisa kamu RABA',
                    'Sebutkan 3 hal yang bisa kamu DENGAR',
                    'Sebutkan 2 hal yang bisa kamu CIUM',
                    'Sebutkan 1 hal yang bisa kamu RASAKAN (secara batin atau fisik)'
                ]),
                'tutorial_penanganan' => 'Ambil napas pelan di setiap pergantian langkah. Tujuan bukan sempurna, tapi menurunkan intensitas cemas.',
                'video_penanganan' => null,
                'status' => 'published',
                'durasi_detik' => 240,
                'tingkat_kesulitan' => 'mudah',
                'ordering' => 2,
            ],
            [
                'nama_penanganan' => 'Progressive Muscle Relaxation',
                'slug' => 'progressive-muscle-relaxation',
                'deskripsi_penanganan' => 'Mengencangkan lalu melemaskan kelompok otot untuk menurunkan ketegangan fisik dan mental.',
                'tahapan_penanganan' => implode("\n", [
                    'Kencangkan otot kaki selama 5 detik lalu lepaskan',
                    'Kencangkan betis – lepaskan',
                    'Kencangkan paha – lepaskan',
                    'Kencangkan perut – lepaskan',
                    'Kencangkan bahu & tangan – lepaskan',
                    'Akhiri dengan napas dalam 3 kali'
                ]),
                'tutorial_penanganan' => 'Jangan sampai sakit saat mengencangkan. Fokus pada kontras tegang vs rileks.',
                'video_penanganan' => null,
                'status' => 'draft',
                'durasi_detik' => 420,
                'tingkat_kesulitan' => 'sedang',
                'ordering' => 3,
            ],
        ];

        foreach ($data as $row) {
            Penanganan::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
