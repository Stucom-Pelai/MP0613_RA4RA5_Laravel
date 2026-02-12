<?php

/**
 * @author Maxime Pol Marcet
 */

namespace Database\Factories;

use App\Models\Producer;
use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Cinema practice – Factory for the Producer model.
 * I use this factory to generate producers with Faker (RA6).
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producer>
 */
class ProducerFactory extends Factory
{
    protected $model = Producer::class;

    /**
     * I define the default state of the model: I respect the producers table column lengths
     * (name 100, company 100, country 30) and I generate random data with Faker.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = ['Warner Bros', 'Universal Pictures', 'Paramount Pictures', 'Sony Pictures', '20th Century Studios', 'Lionsgate', 'A24', 'Focus Features'];
        $countries = ['USA', 'Spain', 'France', 'Germany', 'UK', 'Italy', 'Japan', 'Brazil'];

        return [
            'film_id' => Film::factory(),
            'name' => Str::limit(fake()->name(), 100),
            'company' => fake()->boolean(70) ? Str::limit(fake()->randomElement($companies), 100) : null,
            'country' => Str::limit(fake()->randomElement($countries), 30),
        ];
    }
}
