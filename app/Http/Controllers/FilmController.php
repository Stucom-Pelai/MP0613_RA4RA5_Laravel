<?php

/**
 * Film controller – HTTP actions for the films resource.
 *
 * This controller was adapted to use only Eloquent ORM (the Film model) for
 * all database access. No JSON files or file-based data sources are used; every
 * read and write is performed via Film:: queries and Film::create(), so that the
 * application behaves exactly as before while relying on a consistent and
 * maintainable data layer (Issue #10). The showFilmsDump method still returns
 * JSON as an output format, but the data are loaded from the database via
 * Eloquent, not from a JSON file.
 *
 * @author Maxime Pol Marcet
 */

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * All film-related HTTP actions are handled here. Database queries are wrapped
 * in handleDatabaseQuery so that connection failures are caught and the user
 * is redirected with a friendly message instead of a raw exception.
 */
class FilmController extends Controller
{
    /**
     * The given callback is executed inside a try-catch so that any database
     * exception is reported and the user is redirected to the home page with
     * a database_error message. This is used by all public methods that perform
     * Eloquent queries so that the application degrades gracefully when the
     * database is unavailable.
     */
    private function handleDatabaseQuery(callable $callback): mixed
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            report($e);
            return redirect('/')->with(
                'database_error',
                'Database is temporarily unavailable. Please start MySQL (e.g. from XAMPP) and try again.'
            );
        }
    }

    /**
     * All films are fetched from the database via the Film model so that
     * no JSON or file-based source is used. This method is used internally
     * or by other components that need the full collection.
     */
    public static function readFilms()
    {
        return Film::all();
    }

    /**
     * Films are retrieved via Eloquent (orderBy and get) and passed to the
     * films.list view so that the list is always built from the database
     * rather than from static or JSON data.
     */
    public function listFilms()
    {
        return $this->handleDatabaseQuery(function () {
            $title = "All Films";
            $films = Film::orderBy('year', 'desc')->get();
            return view("films.list", ["films" => $films, "title" => $title]);
        });
    }

    /**
     * Films with year before the given threshold are retrieved via Eloquent
     * where() so that the classic films list is driven by the database.
     */
    public function listOldFilms(int|string|null $year = null)
    {
        if (is_null($year)) {
            $year = 2000;
        }
        return $this->handleDatabaseQuery(function () use ($year) {
            $title = "Classic Films (Before $year)";
            $films = Film::where('year', '<', $year)->orderBy('year', 'desc')->get();
            return view('films.list', ["films" => $films, "title" => $title]);
        });
    }

    /**
     * Films with year equal to or after the given threshold are retrieved
     * via Eloquent where() so that the new releases list is driven by the
     * database.
     */
    public function listNewFilms(int|string|null $year = null)
    {
        if (is_null($year)) {
            $year = 2000;
        }
        return $this->handleDatabaseQuery(function () use ($year) {
            $title = "New Releases (From $year)";
            $films = Film::where('year', '>=', $year)->orderBy('year', 'desc')->get();
            return view('films.list', ["films" => $films, "title" => $title]);
        });
    }

    /**
     * Films for the given year are retrieved via Eloquent where() and
     * orderBy so that the list is built from the database only.
     */
    public function listFilmsByYear($year)
    {
        return $this->handleDatabaseQuery(function () use ($year) {
            $title = "Films of $year";
            $films = Film::where('year', $year)->orderBy('name')->get();
            return view("films.list", ["films" => $films, "title" => $title]);
        });
    }

    /**
     * Films for the given genre are retrieved via Eloquent whereRaw so that
     * case-insensitive comparison is performed in the database and no JSON
     * or file-based filtering is used.
     */
    public function listFilmsByGenre($genre)
    {
        return $this->handleDatabaseQuery(function () use ($genre) {
            $title = "Genre: $genre";
            $films = Film::whereRaw('LOWER(genre) = ?', [strtolower($genre)])->orderBy('year', 'desc')->get();
            return view("films.list", ["films" => $films, "title" => $title]);
        });
    }

    /**
     * Films are retrieved via Eloquent orderBy and get so that the
     * chronological list is built from the database only.
     */
    public function sortFilms()
    {
        return $this->handleDatabaseQuery(function () {
            $title = "Films by Year (Chronological Order)";
            $films = Film::orderBy('year', 'desc')->get();
            return view("films.list", ["films" => $films, "title" => $title]);
        });
    }

    /**
     * The total number of films is obtained via Film::count() so that the
     * count view is always fed from the database rather than from a static
     * or JSON source.
     */
    public function countFilms()
    {
        return $this->handleDatabaseQuery(function () {
            $title = "Film Count";
            $count = Film::count();
            return view("films.count", ["count" => $count, "title" => $title]);
        });
    }

    /**
     * Films are loaded via Eloquent and then serialized to JSON for the
     * response. The data source is the database (Film model), not a JSON
     * file; only the output format is JSON for debugging or API use.
     */
    public function showFilmsDump(): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $result = $this->handleDatabaseQuery(function () {
            return response()->json(Film::orderBy('year', 'desc')->get());
        });

        return $result instanceof JsonResponse ? $result : $result;
    }

    /**
     * The request is validated and then a new Film record is created via
     * Film::create() so that new data are stored in the database through
     * Eloquent. Duplicate names are detected via an Eloquent exists() query
     * so that no JSON or file-based check is used.
     */
    public function createFilm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'year' => 'required|numeric',
            'genre' => 'required|string|max:50',
            'img_url' => 'required|string|max:255',
            'country' => 'required|string|max:30',
            'duration' => 'required|numeric',
        ]);

        try {
            if ($this->isFilm($request->input('name'))) {
                return redirect('/')
                    ->withErrors(['name' => 'Error: This film already exists.'])
                    ->withInput();
            }

            Film::create([
                'name' => $request->input('name'),
                'year' => (int) $request->input('year'),
                'genre' => $request->input('genre'),
                'img_url' => $request->input('img_url'),
                'country' => $request->input('country'),
                'duration' => (int) $request->input('duration'),
            ]);
        } catch (\Throwable $e) {
            report($e);
            return redirect('/')->with('database_error', 'Database is temporarily unavailable. Please start MySQL (e.g. from XAMPP) and try again.')->withInput();
        }

        return $this->listFilms();
    }

    /**
     * Existence of a film with the given name is checked via an Eloquent
     * whereRaw and exists() query so that duplicate detection is performed
     * against the database, not against a JSON file or static data.
     */
    public function isFilm($name): bool
    {
        return Film::whereRaw('LOWER(name) = ?', [strtolower($name)])->exists();
    }
}
