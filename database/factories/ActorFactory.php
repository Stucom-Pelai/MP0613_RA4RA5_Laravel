<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Cinema practice – Factory for the Actor model.
 * I use this factory in ActorFakerSeeder to generate 10 actors with Faker (technical design).
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Actor>
 */
class ActorFactory extends Factory
{
    protected $model = Actor::class;

    /**
     * I define the default state of the model: I respect the actors table column lengths
     * (name 30, surname 30, country 30, img_url 255) and I generate birthdate in YYYY-MM-DD format with Faker.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = ['USA', 'Spain', 'France', 'Germany', 'UK', 'Italy', 'Mexico', 'Argentina'];

        return [
            'name' => Str::limit(fake()->firstName(), 30),
            'surname' => Str::limit(fake()->lastName(), 30),
            'birthdate' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'country' => Str::limit(fake()->randomElement($countries), 30),
            'img_url' => Str::limit(fake()->imageUrl(200, 300), 255),
        ];
    }
}
