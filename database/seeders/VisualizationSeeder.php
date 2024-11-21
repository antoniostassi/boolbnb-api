<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VisualizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // To be able to truncate()
        Schema::disableForeignKeyConstraints();
        DB::table('visualizations')->truncate();
        
        date_default_timezone_set('Europe/Rome');
        
        for ($i=0; $i < 50; $i++) { 
            DB::table('visualizations')->insert([
                'apartment_id' => rand(1,50),
                'ip_address' => rand(100,199).'.'.rand(10,99).'.'.rand(1,9).'.'.rand(1,199), // Ip randomico generato con numeri random
                'visit_date' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
