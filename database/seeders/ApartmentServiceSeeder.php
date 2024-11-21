<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // To be able to truncate()
        Schema::disableForeignKeyConstraints();
        DB::table('apartment_service')->truncate();

        Schema::enableForeignKeyConstraints();

        $couples = [];

        for ($i=0; $i < 50; $i++) { 
            $serviceId = rand(1,20);
            $apartmentId = rand(1,50);

            if(!in_array([$serviceId, $apartmentId], $couples)) { // Filtra e controlla se la coppie non è già stata inserita.
                DB::table('apartment_service')->insert([
                    'apartment_id' => $apartmentId,
                    'service_id' => $serviceId,
                ]);

                $couples[] = [$serviceId, $apartmentId]; // Salva le coppie create 
            }
            
            //dd($couples);
        }
        
    }
}
