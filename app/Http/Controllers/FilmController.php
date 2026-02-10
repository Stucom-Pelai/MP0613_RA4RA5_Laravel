<?php

/**
 * @author Maxime Pol Marcet
 */

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

/**
 * Film controller. I use the cinema database (films table) via the Film model.
 */
class FilmController extends Controller
{
    /**
     * I fetch all films from the cinema database (films table).
     */
    public static function readFilms()
    {
        return Film::all();
    }

    /**
     * I list all films ordered by year descending and return the films.list view.
     */
    public function listFilms()
    {
        $title = "All Films";
        $films = Film::orderBy('year', 'desc')->get();
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    /**
     * I list films with year before the given one (default 2000) and return the films.list view.
     */
    public function listOldFilms($year = null)
    {
        if (is_null($year)) {
            $year = 2000;
        }
        $title = "Classic Films (Before $year)";
        $films = Film::where('year', '<', $year)->orderBy('year', 'desc')->get();
        return view('films.list', ["films" => $films, "title" => $title]);
    }

    /**
     * I list films with year equal to or after the given one (default 2000) and return the films.list view.
     */
    public function listNewFilms($year = null)
    {
        if (is_null($year)) {
            $year = 2000;
        }
        $title = "New Releases (From $year)";
        $films = Film::where('year', '>=', $year)->orderBy('year', 'desc')->get();
        return view('films.list', ["films" => $films, "title" => $title]);
    }

    /**
     * I list films for the given year, ordered by name, and return the films.list view.
     */
    public function listFilmsByYear($year)
    {
        $title = "Films of $year";
        $films = Film::where('year', $year)->orderBy('name')->get();
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    /**
     * I list films for the given genre (case-insensitive comparison) and return the films.list view.
     */
    public function listFilmsByGenre($genre)
    {
        $title = "Genre: $genre";
        $films = Film::whereRaw('LOWER(genre) = ?', [strtolower($genre)])->orderBy('year', 'desc')->get();
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    /**
     * I list all films ordered by year descending (chronological) and return the films.list view.
     */
    public function sortFilms()
    {
        $title = "Films by Year (Chronological Order)";
        $films = Film::orderBy('year', 'desc')->get();
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    /**
     * I get the total number of films and return the films.count view.
     */
    public function countFilms()
    {
        $title = "Film Count";
        $count = Film::count();
        return view("films.count", ["count" => $count, "title" => $title]);
    }

    /**
     * I handle creating a new film in the cinema database: validate, check it does not exist by name, and create the record.
     */
    public function createFilm(Request $request)
    {
        $name = $request->input('name');
        $exists = $this->isFilm($name);

        if ($exists) {
            return redirect('/')
                ->withErrors(['name' => 'Error: This film already exists.'])
                ->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'year' => 'required|numeric',
            'genre' => 'required|string|max:50',
            'img_url' => 'required|string|max:255',
            'country' => 'required|string|max:30',
            'duration' => 'required|numeric'
        ]);

        Film::create([
            'name' => $request->input('name'),
            'year' => (int) $request->input('year'),
            'genre' => $request->input('genre'),
            'img_url' => $request->input('img_url'),
            'country' => $request->input('country'),
            'duration' => (int) $request->input('duration'),
        ]);

        return $this->listFilms();
    }

    /**
     * I check whether a film with the given name already exists in the database (case-insensitive comparison).
     */
    public function isFilm($name): bool
    {
        return Film::whereRaw('LOWER(name) = ?', [strtolower($name)])->exists();
    }
}
