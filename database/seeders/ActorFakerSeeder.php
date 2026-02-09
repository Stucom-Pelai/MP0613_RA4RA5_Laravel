<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Actor;

class ActorFakerSeeder extends Seeder
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
            Actor::create([
                'name' => $faker->name(),
                'surname' => $faker->lastName(),
                'birthdate' => $faker->date(),
                'country' => substr($faker->country(), 0, 3),
                'img_url' => $faker->imageUrl(),
            ]);
        }
    }
}
