<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use app\Models\{
    Apartment,
    Promotion
};

class ApartmentPromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartmentsPromotions = [];

        Schema::disableForeignKeyConstraints();
        DB::table('apartment_promotion')->truncate();

        for ($i=0; $i < 10; $i++) {

            $randomApartment = Apartment::inRandomOrder()->first();
            $randomPromotion = Promotion::inRandomOrder()->first();

            if(!in_array([$randomApartment->id, $randomPromotion->id], $apartmentsPromotions)) {

                $now = new \DateTime(date('Y-m-d')); // lo slash prima del dateTime usa il namespace globale

                DB::table('apartment_promotion')->insert([
                    'apartment_id' => $randomApartment->id,
                    'promotion_id' => $randomPromotion->id,
                    'start_date'=> date("Y-m-d"),
                    'end_date' => $now->modify('+'.$randomPromotion->duration_time.' days'),
                ]);

                $apartmentsPromotions[] = [$randomApartment->id, $randomPromotion->id]; // Salva le coppie create
            }


        }
    }
}
