{{-- Author: Maxime Pol Marcet --}}
@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">

            <h1 class="mb-5">{{$title}}</h1>

            <div class="card-apple mb-5 py-5">
                <p class="text-uppercase text-muted font-weight-bold mb-2" style="letter-spacing: 1px;">Total in Catalogue
                </p>
                <div class="display-1 font-weight-bold text-dark mb-2" style="letter-spacing: -3px;">
                    {{$count}}
                </div>
                <p class="h5 text-secondary font-weight-normal">Films available</p>
            </div>

            <a href="/" class="btn-apple">
                ← Back to Home
            </a>

        </div>
    </div>
@endsection