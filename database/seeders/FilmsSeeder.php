<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * NFR1: Seeder for the films table in the cinema database.
 * I seed the table with dummy data for testing.
 * Uses Faker via FilmFactory; no fixed data.
 */
class FilmsSeeder extends Seeder
{
    /**
     * I run the seeder: I empty the films table and create six test films with Faker-generated data.
     */
    public function run(): void
    {
        DB::table('films')->delete();

        Film::factory(6)->create();

        $this->command->info('Films table filled with test data (NFR1).');
    }
}
