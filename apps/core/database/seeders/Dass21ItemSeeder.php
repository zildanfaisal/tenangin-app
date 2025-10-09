<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dass21Item;

class Dass21ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // 1
            ['S1', 'stres', 'Saya merasa sulit untuk menenangkan diri'],
            // 2
            ['A1', 'anxiety', 'Saya menyadari mulut saya terasa kering'],
            // 3
            ['D1', 'depresi', 'Saya merasa tidak dapat merasakan perasaan positif sama sekali'],
            // 4
            ['A2', 'anxiety', 'Saya mengalami kesulitan bernapas (misalnya napas terasa cepat atau sesak meskipun tidak beraktivitas fisik)'],
            // 5
            ['D2', 'depresi', 'Saya merasa sulit untuk memiliki semangat melakukan sesuatu'],
            // 6
            ['S2', 'stres', 'Saya cenderung bereaksi berlebihan terhadap situasi'],
            // 7
            ['A3', 'anxiety', 'Saya merasakan tubuh saya gemetar (misalnya pada tangan)'],
            // 8
            ['S3', 'stres', 'Saya merasa menggunakan banyak energi karena gugup'],
            // 9
            ['A4', 'anxiety', 'Saya khawatir berada dalam situasi di mana saya bisa panik dan mempermalukan diri sendiri'],
            // 10
            ['D3', 'depresi', 'Saya merasa tidak memiliki hal yang dapat saya harapkan'],
            // 11
            ['S4', 'stres', 'Saya merasa mudah gelisah'],
            // 12
            ['S5', 'stres', 'Saya merasa sulit untuk rileks'],
            // 13
            ['D4', 'depresi', 'Saya merasa sedih dan murung'],
            // 14
            ['S6', 'stres', 'Saya merasa tidak sabar terhadap hal-hal yang menghambat apa yang sedang saya lakukan'],
            // 15
            ['A5', 'anxiety', 'Saya merasa hampir panik'],
            // 16
            ['D5', 'depresi', 'Saya merasa tidak dapat bersemangat terhadap apa pun'],
            // 17
            ['D6', 'depresi', 'Saya merasa diri saya tidak berharga'],
            // 18
            ['S7', 'stres', 'Saya merasa mudah tersinggung'],
            // 19
            ['A6', 'anxiety', 'Saya menyadari detak jantung saya berdetak cepat atau tidak teratur meskipun tidak beraktivitas fisik'],
            // 20
            ['A7', 'anxiety', 'Saya merasa takut tanpa alasan yang jelas'],
            // 21
            ['D7', 'depresi', 'Saya merasa hidup ini tidak berarti'],
        ];

        $urut = 1;
        foreach ($items as $it) {
            Dass21Item::updateOrCreate(
                ['kode' => $it[0]],
                ['subskala' => $it[1], 'pernyataan' => $it[2], 'urutan' => $urut++]
            );
        }
    }
}