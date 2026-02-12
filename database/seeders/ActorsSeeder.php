<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

/**
 * NFR2: Seeder for the actors table in the cinema database.
 * I seed the table with dummy data for testing (birthdate in YYYY-MM-DD format).
 * Uses Faker via ActorFactory; no fixed data.
 */
class ActorsSeeder extends Seeder
{
    /**
     * I run the seeder: I create ten test actors with Faker-generated data.
     */
    public function run(): void
    {
        Actor::factory(10)->create();

        $this->command->info('Actors table filled with test data (NFR2).');
    }
}
