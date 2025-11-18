<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use Faker\Factory as Faker;

class TestimonySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) {

            Testimonial::create([
                'name'        => $faker->name(),
                'designation' => $faker->randomElement(['Traveler', 'Customer', 'Tourist', 'Explorer', 'Honeymoon Couple', 'Solo Traveler']),
                'message'     => $faker->paragraph(2),

                // random placeholder image (300x300)
                'image'       => "https://i.pravatar.cc/300?img={$i}"
            ]);
        }
    }
}
