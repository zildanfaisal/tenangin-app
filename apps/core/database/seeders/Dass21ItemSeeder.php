<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dass21Item;

class Dass21ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['D1','depresi','Saya merasa sulit untuk menjadi antusias terhadap sesuatu'],
            ['D2','depresi','Saya tidak dapat merasakan perasaan positif'],
            ['D3','depresi','Saya merasa hidup tidak berarti'],
            ['D4','depresi','Saya merasa tidak ada harapan'],
            ['D5','depresi','Saya merasa sedih dan tertekan'],
            ['D6','depresi','Saya merasa tidak berharga'],
            ['D7','depresi','Saya sulit menikmati hal-hal'],
            ['A1','anxiety','Saya merasa mulut saya kering'],
            ['A2','anxiety','Saya mengalami pernapasan tidak teratur (misal: sulit bernapas)'],
            ['A3','anxiety','Saya mengalami gemetar (misal: tangan)'],
            ['A4','anxiety','Saya merasa takut tanpa alasan yang jelas'],
            ['A5','anxiety','Saya merasa cemas'],
            ['A6','anxiety','Saya merasa panik'],
            ['A7','anxiety','Saya merasa gugup'],
            ['S1','stres','Saya sulit untuk rileks'],
            ['S2','stres','Saya cenderung bereaksi berlebihan pada situasi'],
            ['S3','stres','Saya merasa gelisah'],
            ['S4','stres','Saya merasa tegang'],
            ['S5','stres','Saya sulit untuk bersabar dengan hambatan'],
            ['S6','stres','Saya merasa menggunakan banyak energi untuk cemas'],
            ['S7','stres','Saya mudah tersinggung'],
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