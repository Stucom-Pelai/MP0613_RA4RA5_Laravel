<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

/**
 * Cinema practice – ActorFakerSeeder (technical design).
 * I seed the actors table with 10 actors generated with Faker via Actor::factory.
 */
class ActorFakerSeeder extends Seeder
{
    /**
     * I run the seeder: I create 10 actors with Faker and output a message to the console when done.
     */
    public function run(): void
    {
        Actor::factory(10)->create();
        $this->command->info('Actors table seeded with 10 actors (ActorFakerSeeder).');
    }
}
