<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\{
    Message,
    Apartment,
};


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Message::truncate();
        Schema::enableForeignKeyConstraints();
        for ($i=0; $i < 60; $i++) {
            $randomApartment = Apartment::inRandomOrder()->first();
            DB::table('messages')->insert([
                'content' => fake()->realText(),
                'user_email'=>fake()->email(),
                'firstname'=>fake()->firstName(),
                'lastname'=>fake()->lastName(),
                'apartment_id'=> $randomApartment->id,
            ]);
        }
    }
}
