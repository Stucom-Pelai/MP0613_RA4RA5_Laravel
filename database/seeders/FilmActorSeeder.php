<?php

/**
 * Film–Actor pivot seeder – seeds the films_actors table using Eloquent relations.
 *
 * This seeder was adapted to use only Eloquent models (Film::all(), Actor::all())
 * and the actors() relationship ($film->actors()->syncWithoutDetaching()). No
 * JSON or raw SQL is used, so that the seeding process is consistent with the
 * new ORM structure and the pivot table is filled after FilmFakerSeeder and
 * ActorFakerSeeder have run (Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Actor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * FilmActorSeeder populates the films_actors pivot table so that each film is
 * linked to between 1 and 3 actors at random. Cascade behaviour is verified
 * in a transaction that is rolled back so that no data is lost.
 */
class FilmActorSeeder extends Seeder
{
    /**
     * All films and actors are loaded via Eloquent. For each film, between 1
     * and 3 distinct actor ids are chosen at random and attached via the
     * actors() relationship so that the pivot table is filled through the ORM.
     * Cascade verification is run afterwards to ensure the migration’s
     * onDelete cascade is respected.
     */
    public function run(): void
    {
        $films = Film::all();
        $actors = Actor::all();

        if ($films->isEmpty() || $actors->isEmpty()) {
            $this->command->warn('Run FilmFakerSeeder and ActorFakerSeeder first.');
            return;
        }

        $actorIds = $actors->pluck('id')->toArray();

        // Each film is assigned 1 to 3 distinct actors at random via the Eloquent relationship.
        foreach ($films as $film) {
            $shuffled = $actorIds;
            shuffle($shuffled);
            $numActors = min(random_int(1, 3), count($shuffled));
            $selected = array_slice($shuffled, 0, $numActors);
            $film->actors()->syncWithoutDetaching($selected);
        }

        $this->command->info('films_actors table seeded (FilmActorSeeder): each film with 1 to 3 actors.');

        $this->verifyCascadeOnDelete();
    }

    /**
     * A film is deleted inside a transaction and the films_actors row count for
     * that film is checked so that the migration’s on delete cascade is verified.
     * The transaction is rolled back so that no data is permanently removed.
     */
    private function verifyCascadeOnDelete(): void
    {
        $filmId = Film::first()?->id;
        if ($filmId === null) {
            return;
        }

        $countBefore = DB::table('films_actors')->where('film_id', $filmId)->count();

        DB::beginTransaction();
        try {
            Film::where('id', $filmId)->delete();
            $countAfter = DB::table('films_actors')->where('film_id', $filmId)->count();
            if ($countAfter === 0 && $countBefore > 0) {
                $this->command->info('On delete cascade verification: OK. When the film was deleted, the films_actors rows were removed.');
            }
        } finally {
            DB::rollBack();
        }
    }
}
