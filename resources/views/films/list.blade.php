@extends('layouts.app')

@section('title', 'Lista de Peliculas')

@section('content')
<h1>{{$title}}</h1>

@if(empty($films))
    <div class="alert alert-danger">No se ha encontrado ninguna película</div>
@else
    <div class="film-grid">
        @foreach($films as $film)
            <div class="film-card">
                <img src="{{$film['img_url']}}" class="film-image" alt="{{$film['title']}}">
                <div class="film-info">
                    <div class="film-title">{{$film['title']}}</div>
                    <div class="film-meta">{{$film['genre']}}</div>
                    <div class="film-meta">{{$film['year']}} &bull; {{$film['duration']}} min</div>
                    <div class="film-meta">{{$film['country']}}</div>
                </div>
            </div>
        @endforeach
    </div>
@endif