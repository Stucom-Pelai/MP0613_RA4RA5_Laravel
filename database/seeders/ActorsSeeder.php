<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

/**
 * NFR2: Seeder for the actors table in the cinema database.
 * I seed the table with dummy data for testing (birthdate in YYYY-MM-DD format).
 */
class ActorsSeeder extends Seeder
{
    /**
     * I run the seeder: I create ten test actors with their data.
     */
    public function run(): void
    {
        // I define the list of actors that I insert as test data.
        $actors = [
            ['name' => 'Tom', 'surname' => 'Hanks', 'birthdate' => '1956-07-09', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/xxPMucou2wRDxLrud8i2D4dsyHj.jpg'],
            ['name' => 'Amy', 'surname' => 'Adams', 'birthdate' => '1974-08-20', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Woody', 'surname' => 'Allen', 'birthdate' => '1935-12-01', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Mia', 'surname' => 'Farrow', 'birthdate' => '1945-02-09', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Denis', 'surname' => 'Villeneuve', 'birthdate' => '1967-10-03', 'country' => 'Canada', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Javier', 'surname' => 'Bardem', 'birthdate' => '1969-03-01', 'country' => 'Spain', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Marina', 'surname' => 'Foïs', 'birthdate' => '1970-01-23', 'country' => 'France', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Vin', 'surname' => 'Diesel', 'birthdate' => '1967-07-18', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Emilio', 'surname' => 'Estévez', 'birthdate' => '1962-05-12', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
            ['name' => 'Robin', 'surname' => 'Wright', 'birthdate' => '1966-04-08', 'country' => 'USA', 'img_url' => 'https://image.tmdb.org/t/p/w185/2vYtVQdY0qR4QqL0Yf0qH0qH0qH.jpg'],
        ];

        foreach ($actors as $actor) {
            Actor::create($actor);
        }

        $this->command->info('Actors table filled with test data (NFR2).');
    }
}
