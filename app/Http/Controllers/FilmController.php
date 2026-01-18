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
            if ($films[$i]['title'] == $film['title']) {
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

        $title = "Listado de Pelis Antiguas (Antes de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            //foreach ($this->datasource as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
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

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }

    /**
     * Lista TODAS las películas categoría una vez en el buscador se pone el genero EJ Drama.
     */

    public function filmsByGenre($genre = null)
    {
        $films_filtered = [];

        $title = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        //if genre is null
        if (is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

        //list based on genre informed
        foreach ($films as $film) {
            if ((!is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
                $title = "Listado de todas las pelis filtrado x categoria";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * Lista TODAS las películas categoría una vez en el buscador se pone el genero EJ Drama.
     */

    public function filmsByYear($year = null)
    {
        $films_filtered = [];

        $title = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        //if genre is null
        if (is_null($year))
            return view('films.list', ["films" => $films, "title" => $title]);

        //list based on genre informed
        foreach ($films as $film) {
            if ((!is_null($year)) && strtolower($film['year']) == strtolower($year)) {
                $title = "Listado de todas las pelis filtrado x año";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }


    public function asortByYear()
    {
        $title = "Listado de todas las pelis ordenadas por año";
        $films = FilmController::readFilms();

        usort($films, function ($a, $b) {
            return $a['year'] <=> $b['year'];
        });

        return view('films.list', ["films" => $films, "title" => $title]);
    }

    public function listFilms()
    {
        $title = "Listado de todas las pelis";
        $films = FilmController::readFilms();
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    public function createFilm(Request $request)
    {
        $film = $request->only(['title', 'year', 'genre', 'duration', 'country', 'img_url']);

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