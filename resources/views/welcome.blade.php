@extends('layouts.master')

@section('title', 'Inicio - Laravel Films')

@section('content')
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold" style="letter-spacing: -1px;">Laravel Films</h1>
        <p style="font-size: 1.2rem; color: var(--text-secondary);">Gestiona tu colección de cine de forma sencilla.</p>
    </div>

    <div class="row justify-content-center">
        <!-- Navigation Menu -->
        <div class="col-md-8 mb-5">
            <div class="card-apple">
                <h3 class="mb-4">Menú Principal</h3>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a class="btn-apple m-2" href="{{ route('oldFilms') }}">Películas Antiguas</a>
                    <a class="btn-apple m-2" href="{{ route('newFilms') }}">Películas Nuevas</a>
                    <a class="btn-apple m-2" href="{{ route('listFilms') }}">Todas las Películas</a>
                    <a class="btn-apple m-2" href="{{ route('sortFilms') }}">Ordenadas por Año</a>
                    <a class="btn-apple m-2" href="{{ route('countFilms') }}">Contador</a>
                </div>
            </div>
        </div>

        <!-- Add Film Form -->
        <div class="col-md-8">
            <div class="card-apple">
                <h2 class="mb-4 text-center">Añadir Nueva Película</h2>

                <!-- Bloque de Errores -->
                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius: var(--radius-default); font-size: 0.95rem;">
                        <strong>Revisa los siguientes errores:</strong>
                        <ul class="mb-0 mt-2 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('film') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="name" class="font-weight-bold ml-1">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Ej: Titanic" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="year" class="font-weight-bold ml-1">Año</label>
                            <input type="number" name="year" id="year" class="form-control" value="{{ old('year') }}"
                                placeholder="Ej: 1997" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="genre" class="font-weight-bold ml-1">Género</label>
                            <input type="text" name="genre" id="genre" class="form-control" value="{{ old('genre') }}"
                                placeholder="Ej: Drama" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="country" class="font-weight-bold ml-1">País</label>
                            <input type="text" name="country" id="country" class="form-control" value="{{ old('country') }}"
                                placeholder="Ej: USA" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="duration" class="font-weight-bold ml-1">Duración (min)</label>
                            <input type="number" name="duration" id="duration" class="form-control"
                                value="{{ old('duration') }}" placeholder="Ej: 195" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="img_url" class="font-weight-bold ml-1">URL del Póster</label>
                            <input type="url" name="img_url" id="img_url" class="form-control" value="{{ old('img_url') }}"
                                placeholder="https://..." required>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn-apple px-5 py-3" style="font-size: 1.1rem;">
                            Añadir Película
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection