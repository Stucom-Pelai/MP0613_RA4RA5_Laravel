{{-- Author: Maxime Pol Marcet --}}
@extends('layouts.master')

@section('title', 'Home - Laravel Films')

@section('content')
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold" style="letter-spacing: -1px;">Laravel Films</h1>
        <p style="font-size: 1.2rem; color: var(--text-secondary);">Manage your film collection easily.</p>
        {{-- I display cinema database connection info and film/actor counts --}}
        <div class="small text-muted mb-2">
            <strong>Database:</strong> {{ $dbName ?? '—' }}
            &nbsp;|&nbsp;
            <strong>Films:</strong> {{ $filmCount ?? 0 }}
            &nbsp;|&nbsp;
            <strong>Actors:</strong> {{ $actorCount ?? 0 }}
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Navigation Menu -->
        <div class="col-md-8 mb-5">
            <div class="card-apple">
                <h3 class="mb-4">Main Menu</h3>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a class="btn-apple m-2" href="{{ route('oldFilms') }}">Classic Films</a>
                    <a class="btn-apple m-2" href="{{ route('newFilms') }}">New Releases</a>
                    <a class="btn-apple m-2" href="{{ route('listFilms') }}">All Films</a>
                    <a class="btn-apple m-2" href="{{ route('sortFilms') }}">Sorted by Year</a>
                    <a class="btn-apple m-2" href="{{ route('countFilms') }}">Count</a>
                </div>
            </div>
        </div>

        <!-- Add Film Form -->
        <div class="col-md-8">
            <div class="card-apple">
                <h2 class="mb-4 text-center">Add New Film</h2>

                <!-- Errors block -->
                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius: var(--radius-default); font-size: 0.95rem;">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Add film form -->
                <form action="{{ route('film') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="name" class="font-weight-bold ml-1">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                placeholder="e.g. Titanic" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="year" class="font-weight-bold ml-1">Year</label>
                            <input type="number" name="year" id="year" class="form-control" value="{{ old('year') }}"
                                placeholder="e.g. 1997" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="genre" class="font-weight-bold ml-1">Genre</label>
                            <input type="text" name="genre" id="genre" class="form-control" value="{{ old('genre') }}"
                                placeholder="e.g. Drama" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="country" class="font-weight-bold ml-1">Country</label>
                            <input type="text" name="country" id="country" class="form-control" value="{{ old('country') }}"
                                placeholder="e.g. USA" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="duration" class="font-weight-bold ml-1">Duration (min)</label>
                            <input type="number" name="duration" id="duration" class="form-control"
                                value="{{ old('duration') }}" placeholder="e.g. 195" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="img_url" class="font-weight-bold ml-1">Poster URL</label>
                            <input type="url" name="img_url" id="img_url" class="form-control" value="{{ old('img_url') }}"
                                placeholder="https://..." required>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn-apple px-5 py-3" style="font-size: 1.1rem;">
                            Add Film
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection