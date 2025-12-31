<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /**
     * Read films from storage
     */
    public static function readFilms(): array
    {
        // He creado esta función para no repetir código al leer el JSON.
        // Se lee el JSON desde storage/app/public/films.json
        if (Storage::exists('public/films.json')) {
            $json = Storage::get('public/films.json');
            return json_decode($json, true) ?? [];
        }
        return [];
    }

    /**
     * List all films
     */
    public function listFilms()
    {
        $title = "Todas las Películas";
        $films = FilmController::readFilms();
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    public function listOldFilms($year = null)
    {
        $old_films = [];
        if (is_null($year))
            $year = 2000;
        $title = "Películas Clásicas (Antes de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }

    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;
        $title = "Nuevos Lanzamientos (Desde $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }

    public function listFilmsByYear($year)
    {
        $films_filtered = [];
        $title = "Películas del Año: $year";
        $films = FilmController::readFilms();
        foreach ($films as $film) {
            if ($film['year'] == $year)
                $films_filtered[] = $film;
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    public function listFilmsByGenre($genre)
    {
        $films_filtered = [];
        $title = "Género: $genre";
        $films = FilmController::readFilms();
        foreach ($films as $film) {
            if (strtolower($film['genre']) == strtolower($genre))
                $films_filtered[] = $film;
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    public function sortFilms()
    {
        $title = "Películas por Año (Orden Cronológico)";
        $films = FilmController::readFilms();
        usort($films, function ($a, $b) {
            return $b['year'] - $a['year'];
        });
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    public function countFilms()
    {
        $title = "Contador de Películas";
        $films = FilmController::readFilms();
        $count = count($films);
        // Apuntamos a films.count (resources/views/films/count.blade.php)
        return view("films.count", ["count" => $count, "title" => $title]);
    }

    /**
     * Diagram Step: createFilm()
     * Handles the creation of a new film following the rigorous sequence diagram.
     */
    public function createFilm(Request $request)
    {
        // 1. Diagram Flow: FilmController -> isFilm()
        // Primero recojo el nombre enviado por el formulario.
        $name = $request->input('name');
        // Y llamo a mi función auxiliar isFilm() para ver si ya la tenemos.
        $exists = $this->isFilm($name);

        // 2. Diagram Flow: if film exists -> welcome(error)
        // Si la película ya existe, lo siento pero devuelvo al usuario al inicio con un error, como marca el diagrama.
        if ($exists) {
            return redirect('/')
                ->withErrors(['name' => 'Error: Esta película ya existe.'])
                ->withInput();
        }

        // Validation (Auxiliary step to ensure data integrity)
        // Por seguridad, valido también el resto de campos aquí en el controlador.
        $request->validate([
            'name' => 'required',
            'year' => 'required|numeric',
            'genre' => 'required',
            'img_url' => 'required',
            'country' => 'required',
            'duration' => 'required|numeric'
        ]);

        // 3. Diagram Flow: if film does not exist -> Storage:put
        // Si todo está bien, leo las pelis actuales...
        $films = FilmController::readFilms();

        // Creo el array de la nueva película...
        $newFilm = [
            "name" => $request->input('name'),
            "year" => (int) $request->input('year'),
            "genre" => $request->input('genre'),
            "img_url" => $request->input('img_url'),
            "country" => $request->input('country'),
            "duration" => (int) $request->input('duration')
        ];

        // La añado al array de películas...
        $films[] = $newFilm;

        // Writing to storage (films.json)
        // Y guardo todo el array actualizado en el JSON.
        Storage::put('public/films.json', json_encode($films, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // 4. Diagram Flow: listFilms() -> list
        // Finalmente muestro el listado con la nueva inclusión.
        return $this->listFilms();
    }

    /**
     * Diagram Step: isFilm() : bool
     * Checks if the film already exists in storage.
     */
    public function isFilm($name): bool
    {
        // Diagram Flow: readFilms() -> Storage:json -> films[]
        // Aquí recorro todas las películas para comparar los nombres.
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            // Uso strtolower para que no importe si escriben en mayúsculas o minúsculas.
            if (strtolower($film['name']) === strtolower($name)) {
                return true;
            }
        }

        return false;
    }
}