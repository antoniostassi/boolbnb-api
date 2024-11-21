<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // To be able to truncate()
        Schema::disableForeignKeyConstraints();
        DB::table('apartments')->truncate();
        
        Schema::enableForeignKeyConstraints();

        $apartments = config('apartments');
        foreach ($apartments as $index => $apartment) {
            DB::table('apartments')->insert([
                'title' => $apartment['title'],
                'user_id' => 1,
                'rooms' => $apartment['rooms'],
                'beds' => $apartment['beds'],
                'bathrooms' => $apartment['bathrooms'],
                'apartment_size' => $apartment['apartment_size'],
                'address' => $apartment['address'],
                'latitude' => $apartment['latitude'],
                'longitude' => $apartment['longitude'],
                'image' => $apartment['image'],
                'is_visible' => true
            ]);
        };
        
    }
}
