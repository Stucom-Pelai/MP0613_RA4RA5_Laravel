<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

/**
 * Cinema practice – FilmFakerSeeder (technical design).
 * I seed the films table with 10 films generated with Faker via Film::factory.
 */
class FilmFakerSeeder extends Seeder
{
    /**
     * I run the seeder: I create 10 films with Faker and output a message to the console when done.
     */
    public function run(): void
    {
        Film::factory(10)->create();
        $this->command->info('Films table seeded with 10 films (FilmFakerSeeder).');
    }
}
