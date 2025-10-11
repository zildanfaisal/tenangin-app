<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonsultanSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel konsultan.
     */
    public function run(): void
    {
        DB::table('konsultan')->insert([
            [
                'nama_konsultan' => 'Anggia Kirana Candra',
                'foto' => 'images/konsultan/anggia.jpg',
                'jenis_kelamin' => 'P',
                'deskripsi' => 'Terapis di Universitas Negeri Surabaya, berpengalaman menangani kecemasan dan burnout.',
                'spesialisasi' => 'Psikolog Klinis',
                'kategori' => 'konselor',
                'pengalaman' => 10,
                'jadwal_praktik' => 'Senin - Jumat, 09:00 - 17:00 WIB',
                'harga' => 35000,
                'rating' => 5.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_konsultan' => 'Citra Rahmadani',
                'foto' => 'images/konsultan/citra.jpg',
                'jenis_kelamin' => 'P',
                'deskripsi' => 'Konselor profesional dengan pengalaman di bidang pengembangan diri dan trauma healing.',
                'spesialisasi' => 'Konselor Psikologi',
                'kategori' => 'konselor',
                'pengalaman' => 8,
                'jadwal_praktik' => 'Selasa - Sabtu, 10:00 - 18:00 WIB',
                'harga' => 45000,
                'rating' => 4.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_konsultan' => 'Rizky Ardiansyah',
                'foto' => 'images/konsultan/rizky.jpg',
                'jenis_kelamin' => 'L',
                'deskripsi' => 'Psikolog industri dan organisasi yang fokus pada keseimbangan kerja dan kesehatan mental.',
                'spesialisasi' => 'Psikolog Industri',
                'kategori' => 'konsultan',
                'pengalaman' => 7,
                'jadwal_praktik' => 'Senin - Kamis, 13:00 - 20:00 WIB',
                'harga' => 50000,
                'rating' => 4.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_konsultan' => 'Dewi Maharani',
                'foto' => 'images/konsultan/dewi.jpg',
                'deskripsi' => 'Ahli terapi perilaku kognitif untuk mengatasi stres, kecemasan, dan depresi ringan.',
                'spesialisasi' => 'Psikoterapis',
                'jenis_kelamin' => 'P',
                'kategori' => 'konsultan',
                'pengalaman' => 9,
                'jadwal_praktik' => 'Rabu - Minggu, 08:00 - 16:00 WIB',
                'harga' => 40000,
                'rating' => 4.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_konsultan' => 'Andra Yuliana',
                'foto' => 'images/konsultan/andra.jpg',
                'deskripsi' => 'Konselor keluarga dan hubungan interpersonal dengan pendekatan empatik.',
                'spesialisasi' => 'Konselor Keluarga',
                'jenis_kelamin' => 'P',
                'kategori' => 'konselor',
                'pengalaman' => 6,
                'jadwal_praktik' => 'Senin - Jumat, 10:00 - 18:00 WIB',
                'harga' => 38000,
                'rating' => 4.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
