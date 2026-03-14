<?php

/**
 * Main application database seeder.
 *
 * The cinema seeders (FilmFakerSeeder, ActorFakerSeeder, FilmActorSeeder) are
 * invoked in a fixed order so that the films and actors tables are filled via
 * factories first, and the films_actors pivot table is then populated using
 * Eloquent relationships. This order is required because the pivot table
 * depends on existing film and actor ids. No JSON-based or file-based seeding
 * is used; all data is generated through Eloquent models and factories
 * (Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder is the entry point for php artisan db:seed. The cinema
 * seeders are called in sequence so that foreign key constraints are
 * satisfied and the database is left in a consistent state.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * FilmFakerSeeder is run first so that 10 films are created via the
     * Film factory. ActorFakerSeeder is run second so that 10 actors are
     * created via the Actor factory. FilmActorSeeder is run last so that
     * the films_actors pivot table is filled using the Film–Actor
     * relationship. This order ensures that the database can be seeded
     * successfully using factories only.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            FilmFakerSeeder::class,
            ActorFakerSeeder::class,
            FilmActorSeeder::class,
        ]);
    }
}
