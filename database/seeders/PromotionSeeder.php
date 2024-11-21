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
        $promotions = config('promotions');
        
        // To be able to truncate()
        Schema::disableForeignKeyConstraints();
        Promotion::truncate();
        
        Schema::enableForeignKeyConstraints();

        foreach ($promotions as $promotion) {
            DB::table('promotions')->insert([
                'title' => $promotion['title'],
                'description' => $promotion['description'],
                'price' => $promotion['price'],
                'duration_time' => $promotion['duration_time'],
            ]);
        }


    }
}
