<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User for test purposes ( password = 'password');
        /* User::factory()->create([
            'firstname' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        $this->call([
            PromotionSeeder::class,
            ApartmentSeeder::class,
            MessageSeeder::class,
            VisualizationSeeder::class,
            ServiceSeeder::class,
            ApartmentServiceSeeder::class
        ]);

    }
}
