<?php

/**
 * Films table seeder (alternative) – seeds the films table using the Film factory.
 *
 * This seeder was updated to use the FilmFactory instead of any JSON or
 * hardcoded data. The films table is truncated and then filled with six
 * Faker-generated records via Film::factory(6)->create(), so that seeding
 * is consistent with the Eloquent ORM structure. This seeder is not called
 * by DatabaseSeeder by default but is available for standalone or test usage
 * (NFR1, Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * FilmsSeeder is an alternative seeder for the films table. The table is
 * cleared and then repopulated with six records so that tests or manual
 * runs can start from a known state without affecting other seeders.
 */
class FilmsSeeder extends Seeder
{
    /**
     * The films table is emptied so that previous data does not conflict with
     * the new run. Six Film records are then created via the factory so that
     * the table is filled with Faker-generated data only, without JSON or
     * hardcoded values.
     */
    public function run(): void
    {
        DB::table('films')->delete();

        Film::factory(6)->create();

        $this->command->info('Films table filled with test data (NFR1).');
    }
}
