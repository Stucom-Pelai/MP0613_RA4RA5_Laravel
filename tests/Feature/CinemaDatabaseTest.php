<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Tests\Feature;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Cinema practice – Test cases to verify the cinema schema and dummy data.
 * I check database configuration, films/actors/films_actors table format, seeded data, foreign keys and cascade delete.
 */
class CinemaDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test case 1: I verify that the Laravel project is configured to use the database.
     */
    public function test_1_verify_laravel_project_is_configured_to_use_the_database(): void
    {
        $connection = config('database.default');
        $this->assertNotEmpty($connection, 'Default database connection must be defined.');

        $database = config('database.connections.' . $connection . '.database');
        $this->assertNotNull($database, 'Database name must be configured (e.g. :memory: in tests).');

        $this->assertTrue(
            DB::connection()->getPdo() instanceof \PDO,
            'A PDO connection to the database must be established.'
        );
    }

    /**
     * Test case 2: I verify that the films table is created with the correct format.
     */
    public function test_2_verify_table_films_is_created_with_correct_format(): void
    {
        $this->assertTrue(Schema::hasTable('films'), 'The films table must exist.');

        $expectedColumns = ['id', 'name', 'year', 'genre', 'country', 'duration', 'img_url', 'created_at', 'updated_at'];
        foreach ($expectedColumns as $column) {
            $this->assertTrue(Schema::hasColumn('films', $column), "The films table must have the column {$column}.");
        }

        $this->assertContains(Schema::getColumnType('films', 'id'), ['bigint', 'integer'], 'id must be bigint or integer.');
        $this->assertContains(Schema::getColumnType('films', 'name'), ['string', 'varchar'], 'name must be string/varchar.');
        $this->assertContains(Schema::getColumnType('films', 'year'), ['integer', 'int'], 'year must be numeric.');
        $this->assertContains(Schema::getColumnType('films', 'duration'), ['integer', 'int'], 'duration must be numeric.');
    }

    /**
     * Test case 3: I verify that the films table is seeded with dummy data.
     */
    public function test_3_verify_table_films_is_informed_with_dummy_data(): void
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmFakerSeeder']);
        $count = Film::count();
        $this->assertGreaterThanOrEqual(10, $count, 'The films table must have at least 10 records (FilmFakerSeeder).');
    }

    /**
     * Test case 4: I verify that the actors table is created with the correct format.
     */
    public function test_4_verify_table_actors_is_created_with_correct_format(): void
    {
        $this->assertTrue(Schema::hasTable('actors'), 'The actors table must exist.');

        $expectedColumns = ['id', 'name', 'surname', 'birthdate', 'country', 'img_url', 'created_at', 'updated_at'];
        foreach ($expectedColumns as $column) {
            $this->assertTrue(Schema::hasColumn('actors', $column), "The actors table must have the column {$column}.");
        }

        $this->assertContains(Schema::getColumnType('actors', 'birthdate'), ['date', 'datetime'], 'birthdate must be date.');
    }

    /**
     * Test case 5: I verify that the actors table is seeded with dummy data.
     */
    public function test_5_verify_table_actors_is_informed_with_dummy_data(): void
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ActorFakerSeeder']);
        $count = Actor::count();
        $this->assertGreaterThanOrEqual(10, $count, 'The actors table must have at least 10 records (ActorFakerSeeder).');
    }

    /**
     * Test case 6: I verify that the films_actors table is created with the correct foreign keys.
     */
    public function test_6_verify_table_films_actors_is_created_with_correct_foreign_keys(): void
    {
        $this->assertTrue(Schema::hasTable('films_actors'), 'The films_actors table must exist.');

        $expectedColumns = ['film_id', 'actor_id', 'created_at', 'updated_at'];
        foreach ($expectedColumns as $column) {
            $this->assertTrue(Schema::hasColumn('films_actors', $column), "The films_actors table must have the column {$column}.");
        }

        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            $foreignKeys = DB::select("
                SELECT COLUMN_NAME, REFERENCED_TABLE_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'films_actors'
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            $referencedTables = array_column($foreignKeys, 'REFERENCED_TABLE_NAME');
            $this->assertContains('films', $referencedTables, 'There must be a foreign key to the films table.');
            $this->assertContains('actors', $referencedTables, 'There must be a foreign key to the actors table.');
        }
        // With SQLite, FKs are created in the migration; film_id and actor_id existence is already checked above.
    }

    /**
     * Test case 7: I verify that the films_actors table is seeded with film and actor ids.
     */
    public function test_7_verify_table_films_actors_is_informed_with_films_and_actors_ids(): void
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ActorFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmActorSeeder']);

        $pivotCount = DB::table('films_actors')->count();
        $this->assertGreaterThan(0, $pivotCount, 'The films_actors table must have at least one record.');

        $rows = DB::table('films_actors')->get();
        foreach ($rows as $row) {
            $this->assertTrue(Film::where('id', $row->film_id)->exists(), "film_id {$row->film_id} must exist in films.");
            $this->assertTrue(Actor::where('id', $row->actor_id)->exists(), "actor_id {$row->actor_id} must exist in actors.");
        }
    }

    /**
     * Test case 8: I verify that a delete on films or actors cascades to films_actors rows.
     */
    public function test_8_verify_delete_on_films_or_actors_deletes_on_cascade_from_films_actors(): void
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ActorFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmActorSeeder']);

        $film = Film::has('actors')->first();
        $this->assertNotNull($film, 'At least one film with actors must exist to test cascade.');
        $filmId = $film->id;
        $countBefore = DB::table('films_actors')->where('film_id', $filmId)->count();
        $this->assertGreaterThan(0, $countBefore, 'The film must have rows in films_actors.');

        $film->delete();
        $countAfter = DB::table('films_actors')->where('film_id', $filmId)->count();
        $this->assertEquals(0, $countAfter, 'When a film is deleted, the corresponding films_actors rows must be removed by cascade.');
    }

    /**
     * Test case 9: I verify that the bug has been fixed (cascade and table format).
     */
    public function test_9_verify_bug_has_been_fixed(): void
    {
        $this->assertTrue(Schema::hasTable('films_actors'), 'The films_actors pivot table must exist.');
        $this->assertTrue(Schema::hasColumn('films_actors', 'film_id'), 'films_actors must have film_id.');
        $this->assertTrue(Schema::hasColumn('films_actors', 'actor_id'), 'films_actors must have actor_id.');

        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\ActorFakerSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\FilmActorSeeder']);

        $actor = Actor::has('films')->first();
        $this->assertNotNull($actor);
        $actorId = $actor->id;
        $actor->delete();
        $countAfter = DB::table('films_actors')->where('actor_id', $actorId)->count();
        $this->assertEquals(0, $countAfter, 'Bug fixed: when an actor is deleted, films_actors rows are removed by cascade.');
    }

    /**
     * Test case 10: I verify that the enhancement has been done (Faker seeders and dummy data).
     */
    public function test_10_verify_enhancement_has_been_done(): void
    {
        $this->assertTrue(class_exists(\Database\Seeders\FilmFakerSeeder::class), 'Enhancement: FilmFakerSeeder must exist.');
        $this->assertTrue(class_exists(\Database\Seeders\ActorFakerSeeder::class), 'Enhancement: ActorFakerSeeder must exist.');

        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\DatabaseSeeder']);
        $this->assertGreaterThanOrEqual(10, Film::count(), 'Enhancement: the films table must be seeded with at least 10 films (Faker).');
        $this->assertGreaterThanOrEqual(10, Actor::count(), 'Enhancement: the actors table must be seeded with at least 10 actors (Faker).');
        $this->assertGreaterThan(0, DB::table('films_actors')->count(), 'Enhancement: the films_actors table must have film-actor relations.');
    }
}
