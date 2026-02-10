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

// Welcome route (home page with form); I pass db name and film/actor counts to the view.
Route::get('/', function () {
    $connection = config('database.default');
    $dbName = config('database.connections.' . $connection . '.database');
    $filmCount = \App\Models\Film::count();
    $actorCount = \App\Models\Actor::count();
    return view('welcome', [
        'dbName' => $dbName,
        'filmCount' => $filmCount,
        'actorCount' => $actorCount,
    ]);
});

// Read routes (GET) – listing and count features. I group them under the 'filmout' prefix.
Route::group(['prefix' => 'filmout'], function () {
    Route::get('oldFilms/{year?}', [FilmController::class, "listOldFilms"])->name('oldFilms');
    Route::get('newFilms/{year?}', [FilmController::class, "listNewFilms"])->name('newFilms');
    Route::get('filmsByYear/{year}', [FilmController::class, "listFilmsByYear"])->name('filmsByYear');
    Route::get('filmsByGenre/{genre}', [FilmController::class, "listFilmsByGenre"])->name('filmsByGenre');
    Route::get('films', [FilmController::class, "listFilms"])->name('listFilms');
    Route::get('sortFilms', [FilmController::class, "sortFilms"])->name('sortFilms');
    Route::get('countFilms', [FilmController::class, "countFilms"])->name('countFilms');
});

// Create route (POST) – add film feature. Diagram flow: POST filmin/film.
// I define the 'filmin' group as per the technical design and apply the validateUrl middleware so the image URL is validated before reaching the controller.
Route::group(['prefix' => 'filmin'], function () {
    Route::post('film', [FilmController::class, "createFilm"])
        ->name('film')
        ->middleware('validateUrl');
});