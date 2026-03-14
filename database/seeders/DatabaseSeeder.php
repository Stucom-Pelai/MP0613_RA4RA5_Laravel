<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Cinema practice – Main application seeder.
 * I call the cinema seeders in this order: FilmFakerSeeder, ActorFakerSeeder, FilmActorSeeder,
 * so that the films, actors and films_actors tables are filled consistently.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * I run the seeders: first FilmFakerSeeder (10 films with Faker), then ActorFakerSeeder (10 actors with Faker),
     * and finally FilmActorSeeder (random 1-to-3 actors per film and on delete cascade verification).
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
