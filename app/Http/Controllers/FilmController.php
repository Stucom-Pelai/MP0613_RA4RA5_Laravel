<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /**
     * Read films from storage
     */
    public static function readFilms(): array {
        return Storage::json('/public/films.json');
    }

    /**
     * List films older than input year 
     * if year is not informed 2000 year will be used as criteria
     */
    public function listOldFilms($year = null)
    {        
        $old_films = [];
        if (is_null($year)) {
            $year = 2000;
        }
    
        $title = "Listado de Pelis Antiguas (Antes de $year)";    
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] < $year) {
                $old_films[] = $film;
            }
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }

    /**
     * List films younger than input year
     * if year is not informed 2000 year will be used as criteria
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year)) {
            $year = 2000;
        }

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year) {
                $new_films[] = $film;
            }
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }

    /**
     * List films filtered by year
     */
    public function listFilmsByYear($year)
    {
        $films_filtered = [];
        $title = "Listado de todas las pelis filtrado por año $year";

        $films = FilmController::readFilms();
        foreach ($films as $film) {
            if ($film['year'] == $year) {
                $films_filtered[] = $film;
            }
        }

        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * List films filtered by genre
     */
    public function listFilmsByGenre($genre)
    {
        $films_filtered = [];
        $title = "Listado de todas las pelis filtrado por género $genre";

        $films = FilmController::readFilms();
        foreach ($films as $film) {
            if (strtolower($film['genre']) == strtolower($genre)) {
                $films_filtered[] = $film;
            }
        }

        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }
}
