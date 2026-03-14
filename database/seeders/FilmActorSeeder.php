<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Actor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Cinema practice – FilmActorSeeder (technical design).
 * I randomly assign each film to between 1 and 3 actors.
 * I verify that on delete cascade removes films_actors rows when a film is deleted.
 */
class FilmActorSeeder extends Seeder
{
    /**
     * I run the seeder: I assign each film 1 to 3 actors chosen at random.
     * Then I run a cascade verification (I delete a film in a transaction and check the child table). I roll back so no data is lost.
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

        // I assign each film 1 to 3 distinct actors chosen at random.
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
     * I run a delete on the parent table (films) inside a transaction and check
     * that the child table films_actors loses that film's rows (on delete cascade). I roll back so no data is lost.
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
