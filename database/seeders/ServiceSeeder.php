<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $services = config('label_services');
        foreach ($services as $index => $service) {
            DB::table('services')->insert([
                'title' => $service['title'],
                'image' => $service['image']
            ]);
        };
    }
}
