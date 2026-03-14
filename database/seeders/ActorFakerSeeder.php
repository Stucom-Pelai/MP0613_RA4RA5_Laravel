<?php

/**
 * Actor Faker seeder – seeds the actors table using the Actor factory.
 *
 * This seeder was updated to use the new ActorFactory instead of any JSON or
 * hardcoded data. The actors table is populated with exactly 10 records via
 * Actor::factory()->count(10)->create(), so that database seeding is clean,
 * maintainable and consistent with the Eloquent ORM structure (Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

/**
 * ActorFakerSeeder is invoked by DatabaseSeeder so that the actors table is
 * filled before FilmActorSeeder runs. The order is required because the
 * pivot table depends on existing film and actor ids.
 */
class ActorFakerSeeder extends Seeder
{
    /**
     * Ten Actor records are created via the factory so that the actors table
     * is seeded with Faker-generated data. A console message is output so
     * that the operator is informed when the seeder has finished.
     */
    public function run(): void
    {
        Actor::factory()->count(10)->create();
        $this->command->info('Actors table seeded with 10 actors (ActorFakerSeeder).');
    }
}
