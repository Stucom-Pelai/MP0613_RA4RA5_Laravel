<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Cinema practice – Factory for the Film model.
 * I use this factory in FilmFakerSeeder to generate 10 films with Faker (technical design).
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;

    /**
     * I define the default state of the model: I respect the films table column lengths
     * (name 100, genre 50, country 30, img_url 255) and I generate random data with Faker.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = ['Drama', 'Comedy', 'Science Fiction', 'Action', 'Thriller', 'Horror', 'Romance'];
        $countries = ['USA', 'Spain', 'France', 'Germany', 'UK', 'Italy', 'Japan', 'Brazil'];

        return [
            'name' => Str::limit(fake()->words(3, true), 100),
            'year' => fake()->numberBetween(1980, 2025),
            'genre' => Str::limit(fake()->randomElement($genres), 50),
            'country' => Str::limit(fake()->randomElement($countries), 30),
            'duration' => fake()->numberBetween(60, 180),
            'img_url' => Str::limit(fake()->imageUrl(640, 480), 255),
        ];
    }
}
