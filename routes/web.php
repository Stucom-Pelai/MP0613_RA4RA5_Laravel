<?php

use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta de bienvenida (formulario)
Route::get('/', function () {
    return view('welcome');
});

// Rutas de lectura (GET) - Features de listado y conteo
// He agrupado todas estas rutas bajo 'filmout' para tenerlo más ordenado, profe.
Route::group(['prefix' => 'filmout'], function () {
    Route::get('oldFilms/{year?}', [FilmController::class, "listOldFilms"])->name('oldFilms');
    Route::get('newFilms/{year?}', [FilmController::class, "listNewFilms"])->name('newFilms');
    Route::get('filmsByYear/{year}', [FilmController::class, "listFilmsByYear"])->name('filmsByYear');
    Route::get('filmsByGenre/{genre}', [FilmController::class, "listFilmsByGenre"])->name('filmsByGenre');
    Route::get('films', [FilmController::class, "listFilms"])->name('listFilms');
    Route::get('sortFilms', [FilmController::class, "sortFilms"])->name('sortFilms');
    Route::get('countFilms', [FilmController::class, "countFilms"])->name('countFilms');
});

// Ruta de creación (POST) - Feature de añadir película
// Diagram Flow: post filmin/film
// Aquí he creado el grupo 'filmin' tal como pedía el diseño técnico.
// También he aplicado mi middleware 'validateUrl' para asegurar que la imagen es correcta antes de pasar al controlador.
Route::group(['prefix' => 'filmin'], function () {
    Route::post('film', [FilmController::class, "createFilm"])
        ->name('film')
        ->middleware('validateUrl');
});