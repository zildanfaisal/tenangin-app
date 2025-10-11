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
                'kelompok' => 'anxiety',
                'status' => 'published',
                'ordering' => 1,
            ],
            [
                'nama_penanganan' => 'Grounding 5-4-3-2-1',
                'slug' => 'grounding-5-4-3-2-1',
                'deskripsi_penanganan' => 'Teknik grounding sensorik untuk meredakan kecemasan dengan mengembalikan fokus ke saat ini.',
                'kelompok' => 'depresi',
                'status' => 'published',
                'ordering' => 2,
            ],
            [
                'nama_penanganan' => 'Progressive Muscle Relaxation',
                'slug' => 'progressive-muscle-relaxation',
                'deskripsi_penanganan' => 'Mengencangkan lalu melemaskan kelompok otot untuk menurunkan ketegangan fisik dan mental.',
                'kelompok' => 'stres',
                'status' => 'draft',
                'ordering' => 3,
            ],
        ];

        foreach ($data as $row) {
            Penanganan::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
