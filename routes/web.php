<?php

/**
 * @author Maxime Pol Marcet
 */

use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome route (home page with form). The database name and film/actor counts are passed to the view.
// Counts are obtained via the Eloquent models (Film::count(), Actor::count()) so that no JSON or
// file-based data is used; if the database is unavailable, the counts are left at zero and the
// page is still rendered (Issue #10).
Route::get('/', function () {
    $connection = config('database.default');
    $dbName = config('database.connections.' . $connection . '.database');
    $filmCount = 0;
    $actorCount = 0;
    try {
        $filmCount = \App\Models\Film::count();
        $actorCount = \App\Models\Actor::count();
    } catch (\Throwable $e) {
        report($e);
    }
    return view('welcome', [
        'dbName' => $dbName,
        'filmCount' => $filmCount,
        'actorCount' => $actorCount,
    ]);
});

// Read routes (GET) – listing and count features. I group them under the 'filmout' prefix.
Route::group(['prefix' => 'filmout'], function () {
    Route::get('oldFilms/{year?}', [FilmController::class, 'listOldFilms'])->name('oldFilms')->middleware('validateYear');
    Route::get('newFilms/{year?}', [FilmController::class, 'listNewFilms'])->name('newFilms')->middleware('validateYear');
    Route::get('filmsByYear/{year}', [FilmController::class, 'listFilmsByYear'])->name('filmsByYear')->middleware('validateYear');
    Route::get('filmsByGenre/{genre}', [FilmController::class, 'listFilmsByGenre'])->name('filmsByGenre');
    Route::get('films', [FilmController::class, 'listFilms'])->name('listFilms');
    Route::get('films/dump', [FilmController::class, 'showFilmsDump'])->name('filmsDump');
    Route::get('sortFilms', [FilmController::class, 'sortFilms'])->name('sortFilms');
    Route::get('countFilms', [FilmController::class, 'countFilms'])->name('countFilms');
});

// Create route (POST) – add film feature. Diagram flow: POST filmin/film.
// I define the 'filmin' group as per the technical design and apply the validateUrl middleware so the image URL is validated before reaching the controller.
Route::group(['prefix' => 'filmin'], function () {
    Route::post('film', [FilmController::class, 'createFilm'])
        ->name('film')
        ->middleware('validateUrl');
});