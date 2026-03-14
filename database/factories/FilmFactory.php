<?php

/**
 * Film factory for database seeding and testing.
 *
 * This factory was introduced so that films can be generated in a clean and
 * maintainable way using Faker, instead of hardcoded or JSON-based data. It is
 * used by FilmFakerSeeder and FilmsSeeder to populate the films table, ensuring
 * that all future features are built on a consistent data layer (Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * The FilmFactory is bound to the Film model so that Laravel can resolve the
 * correct model when factory() is called on the Film class.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;

    /**
     * The default attribute set for a new Film is defined here. Column lengths
     * from the films migration (name 100, genre 50, country 30, img_url 255)
     * are respected via Str::limit() so that no database errors are caused by
     * oversized values. Faker is used so that each seeded record is varied and
     * realistic for testing.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = ['Drama', 'Comedy', 'Science Fiction', 'Action', 'Thriller', 'Horror', 'Romance'];
        $countries = ['USA', 'Spain', 'France', 'Germany', 'UK', 'Italy', 'Japan', 'Brazil'];

        return [
            'name' => Str::limit($this->faker->words(3, true), 100),
            'year' => $this->faker->numberBetween(1980, 2025),
            'genre' => Str::limit($this->faker->randomElement($genres), 50),
            'country' => Str::limit($this->faker->randomElement($countries), 30),
            'duration' => $this->faker->numberBetween(60, 180),
            'img_url' => Str::limit($this->faker->imageUrl(640, 480), 255),
        ];
    }
}
