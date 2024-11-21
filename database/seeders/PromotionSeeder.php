<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\{
    Promotion,
};

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // ● 2,99 € per 24 ore di sponsorizzazione
    // ● 5.99 € per 72 ore di sponsorizzazione
    // ● 9.99 € per 144 ore di sponsorizzazione
    public function run(): void
    {
        $promotions = [
            [
                'title' => 'Gold',
                'description' => 'Questa sponsorizzazione offre 6 giorni di alta visibilità per il tuo annuncio',
                'price' => 9.99,
                'duration_time' => 0000-00-06, // non funziona, da sistemare
            ],
        ];
        Schema::disableForeignKeyConstraints();
        Promotion::truncate();
        Schema::enableForeignKeyConstraints();
        foreach ($promotions as $singlePromotion) {
            DB::table('promotions')->insert([
                'title' => $singlePromotion['title'],
                'description' => $singlePromotion['description'],
                'price' => $singlePromotion['price'],
                'duration_time' => $singlePromotion['duration_time'],
            ]);
        }


    }
}
