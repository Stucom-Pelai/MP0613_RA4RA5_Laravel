<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Read films from storage
     */
    public static function readFilms(): array
    {
        $films = Storage::json('public/films.json');
        return $films;
    }

    public static function isFilm($film)
    {
        // comprueba si el nombre de la peli ya existe
        $films = FilmController::readFilms();
        for ($i = 0; $i < count($films); $i++) {
            if ($films[$i]['name'] == $film['name']) {
                return true;
            }
        }
        return false;
    }
    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */

    public function listOldFilms($year = null)
    {
        $old_films = [];
        if (is_null($year))
            $year = 2000;

        $name = "Listado de Pelis Antiguas (Antes de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            //foreach ($this->datasource as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "name" => $name]);
    }

    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */

    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;

        $name = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "name" => $name]);
    }

    /**
     * Lista TODAS las películas categoría una vez en el buscador se pone el genero EJ Drama.
     */

    public function filmsByGenre($genre = null)
    {
        $films_filtered = [];

        $name = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        //if genre is null
        if (is_null($genre))
            return view('films.list', ["films" => $films, "name" => $name]);

        //list based on genre informed
        foreach ($films as $film) {
            if ((!is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
                $name = "Listado de todas las pelis filtrado x categoria";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "name" => $name]);
    }

    /**
     * Lista TODAS las películas categoría una vez en el buscador se pone el genero EJ Drama.
     */

    public function filmsByYear($year = null)
    {
        $films_filtered = [];

        $name = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        //if genre is null
        if (is_null($year))
            return view('films.list', ["films" => $films, "name" => $name]);

        //list based on genre informed
        foreach ($films as $film) {
            if ((!is_null($year)) && strtolower($film['year']) == strtolower($year)) {
                $name = "Listado de todas las pelis filtrado x año";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "name" => $name]);
    }


    public function asortByYear()
    {
        $name = "Listado de todas las pelis ordenadas por año";
        $films = FilmController::readFilms();

        usort($films, function ($a, $b) {
            return $a['year'] <=> $b['year'];
        });

        return view('films.list', ["films" => $films, "name" => $name]);
    }

    public function listFilms()
    {
        $name = "Listado de todas las pelis";
        $films = FilmController::readFilms();
        return view("films.list", ["films" => $films, "name" => $name]);
    }

    public function createFilm(Request $request)
    {
        $film = $request->only(['name', 'year', 'genre', 'duration', 'country', 'img_url']);

        if (!isset($film['year']) || !is_numeric($film['year']) || $film['year'] < 1900 || $film['year'] > 2024) {
            return view('welcome', ['error' => 'El año debe estar entre 1900 y 2024']);
        }

        if (FilmController::isFilm($film)) {
            return view('welcome', ['error' => 'This film already exists']);
        }

        $films = FilmController::readFilms();
        $films[] = $film;

        $saved = Storage::put('public/films.json', json_encode($films, JSON_PRETTY_PRINT));

        if (!$saved) {
            return view('welcome', ['error' => 'Error saving the film list']);
        }

        return $this->listFilms();
    }

}