<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Film;

class FilmFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos un objeto de tipo Faker
        $faker = Faker::create();

        //Generamos 20 elementos de tipo aleatorio.
        for($i = 0; $i < 10; $i++){
            Film::create([
                'name' => $faker->sentence(3),
                'year' => $faker->year(),
                'genre' => $faker->word(),
                'country' => substr($faker->country(), 0, 3),
                'duration' => $faker->numberBetween(60, 180),
                'img_url' => $faker->imageUrl(),
            ]);
        }
    }
}
