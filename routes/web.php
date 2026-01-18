<?php

use App\Http\Controllers\FilmController;
use App\Http\Middleware\ValidateYear;
use App\Http\Middleware\ValidateUrl;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

Route::middleware('year')->group(function () {
    Route::group(['prefix' => 'filmout'], function () {
        // Routes included with prefix "filmout"
        Route::get('oldFilms/{year?}', [FilmController::class, "listOldFilms"])->name('oldFilms');
        Route::get('newFilms/{year?}', [FilmController::class, "listNewFilms"])->name('newFilms');
        Route::get('filmsGenre/{genre?}', [FilmController::class, "filmsByGenre"])->name('genereFilms');
        Route::get('filmsYear/{year?}', [FilmController::class, "filmsByYear"])->name('yearFilms');
        Route::get('sortFilms/', [FilmController::class, "asortByYear"])->name('asortFilms');
        Route::get('countFilms/', [FilmController::class, "countFilmsTotal"])->name('countFilms');
    });
});

Route::middleware('ValidateUrl')->group(function () {
    Route::group(['prefix' => 'filmin'], function () {
        // Routes included with prefix "filmIn"
        Route::post('film/', [FilmController::class, "createFilm"])->name('film');
    });
});