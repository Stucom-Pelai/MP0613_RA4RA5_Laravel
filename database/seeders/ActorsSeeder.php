<?php

/**
 * Actors table seeder (alternative) – seeds the actors table using the Actor factory.
 *
 * This seeder was updated to use the ActorFactory instead of any JSON or
 * hardcoded data. The actors table is filled with ten Faker-generated
 * records via Actor::factory(10)->create(), so that seeding is consistent
 * with the Eloquent ORM structure. This seeder is not called by
 * DatabaseSeeder by default but is available for standalone or test usage
 * (NFR2, Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

/**
 * ActorsSeeder is an alternative seeder for the actors table. Ten Actor
 * records are created via the factory so that tests or manual runs can
 * populate the table with Faker-generated data only.
 */
class ActorsSeeder extends Seeder
{
    /**
     * Ten Actor records are created via the factory so that the actors table
     * is filled with Faker-generated data. Birthdate and other attributes
     * are produced by the ActorFactory in the format expected by the model
     * and the database, without JSON or hardcoded values.
     */
    public function run(): void
    {
        Actor::factory(10)->create();

        $this->command->info('Actors table filled with test data (NFR2).');
    }
}
