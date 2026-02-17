<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Actor;

class FilmActorSeeder extends Seeder
{
    public function run()
    {
        $films = Film::all();
        $actors = Actor::all();

        foreach ($films as $film) {
            $randomActors = $actors->random(rand(1, 3))->pluck('id')->toArray();
            $film->actors()->attach($randomActors);
        }
    }
}
