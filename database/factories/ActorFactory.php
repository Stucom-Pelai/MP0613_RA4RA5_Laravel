<?php

/**
 * Actor factory for database seeding and testing.
 *
 * This factory was introduced so that actors can be generated in a clean and
 * maintainable way using Faker, instead of hardcoded or JSON-based data. It is
 * used by ActorFakerSeeder and ActorsSeeder to populate the actors table,
 * ensuring that all future features are built on a consistent data layer
 * (Issue #10).
 *
 * @author Maxime Pol Marcet
 */

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * The ActorFactory is bound to the Actor model so that Laravel can resolve the
 * correct model when factory() is called on the Actor class.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Actor>
 */
class ActorFactory extends Factory
{
    protected $model = Actor::class;

    /**
     * The default attribute set for a new Actor is defined here. Column lengths
     * from the actors migration (name 30, surname 30, country 30, img_url 255)
     * are respected via Str::limit() so that no database errors are caused.
     * Birthdate is generated in Y-m-d format so that it matches the date column
     * type and the Actor model’s cast. Faker is used for varied, realistic data.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = ['USA', 'Spain', 'France', 'Germany', 'UK', 'Italy', 'Mexico', 'Argentina'];

        return [
            'name' => Str::limit($this->faker->firstName(), 30),
            'surname' => Str::limit($this->faker->lastName(), 30),
            'birthdate' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'country' => Str::limit($this->faker->randomElement($countries), 30),
            'img_url' => Str::limit($this->faker->imageUrl(200, 300), 255),
        ];
    }
}
