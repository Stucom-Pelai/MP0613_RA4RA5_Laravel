<?php

/**
 * Film Faker seeder – seeds the films table using the Film factory.
 *
 * This seeder was updated to use the new FilmFactory instead of any JSON or
 * hardcoded data. The films table is populated with exactly 10 records via
 * Film::factory()->count(10)->create(), so that database seeding is clean,
 * maintainable and consistent with the Eloquent ORM structure (Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

/**
 * FilmFakerSeeder is invoked by DatabaseSeeder so that the films table is
 * filled before FilmActorSeeder runs. The order is required because the
 * pivot table depends on existing film and actor ids.
 */
class FilmFakerSeeder extends Seeder
{
    /**
     * Ten Film records are created via the factory so that the films table
     * is seeded with Faker-generated data. A console message is output so
     * that the operator is informed when the seeder has finished.
     */
    public function run(): void
    {
        Film::factory()->count(10)->create();
        $this->command->info('Films table seeded with 10 films (FilmFakerSeeder).');
    }
}
