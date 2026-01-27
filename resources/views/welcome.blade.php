@extends('layouts.app')

@section('name', 'Inicio')

@section('content')

<h1 class="mt-4">Lista de Peliculas</h1>

@if(isset($error) || session('error'))
    <div class="alert alert-danger">
        {{ $error ?? session('error') }}
    </div>
@endif

<ul>
    <li><a href="/filmout/oldFilms">Pelis antiguas</a></li>
    <li><a href="/filmout/newFilms">Pelis nuevas</a></li>
    <li><a href="/filmout/films">Pelis</a></li>
    <li><a href="/filmout/filmsGenre">Peliculas por genero</a></li>
    <li><a href="/filmout/filmsYear">Peliculas por año</a></li>
    <li><a href="/filmout/sortFilms">Ordenar Peliculas</a></li>
</ul>

<form action="{{ route('film') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="year" placeholder="Year" required><br>
    <input type="text" name="genre" placeholder="Genre" required><br>
    <input type="text" name="duration" placeholder="Duration" required><br>
    <input type="text" name="country" placeholder="Country" required><br>
    <input type="text" name="img_url" placeholder="Image URL" required><br>

    <button class="btn btn-primary mt-2">Create Film</button>
</form>

@endsection
