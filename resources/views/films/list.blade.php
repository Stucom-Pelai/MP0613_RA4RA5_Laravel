{{-- Author: Maxime Pol Marcet --}}
@extends('layouts.master')

@section('title', $title)

@section('extra-styles')
    <style>
        .table-apple {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-apple th {
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: var(--text-secondary);
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .table-apple td {
            padding: 24px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            background: white;
            font-size: 15px;
        }

        .table-apple tr:last-child td {
            border-bottom: none;
        }

        .table-apple tr:hover td {
            background-color: #FAFAFA;
        }

        .film-poster {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 70px;
            height: 105px;
            object-fit: cover;
            transition: transform 0.2s;
        }

        .film-poster:hover {
            transform: scale(1.05);
        }

        .badge-genre {
            background-color: #F2F2F7;
            color: var(--text-primary);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="text-center mb-5">
        <h1 class="mb-2">{{$title}}</h1>
        @if(!empty($films))
            <p>Showing {{ count($films) }} titles</p>
        @endif
    </div>

    @if(empty($films))
        <div class="card-apple text-center py-5">
            <h3 class="text-secondary">No films available</h3>
            <p class="mb-0">No films were found in the database.</p>
        </div>
    @else
        <div class="card-apple p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table-apple">
                    <thead>
                        <tr>
                            <th class="pl-4">Poster</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Genre</th>
                            <th>Country</th>
                            <th class="text-right pr-4">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($films as $film)
                            <tr>
                                <td class="pl-4" width="100">
                                    <img src="{{$film['img_url']}}" alt="{{$film['name']}}" class="film-poster"
                                        onerror="this.src='{{ asset('img/image-not-found-placeholder.png') }}';" />
                                </td>
                                <td>
                                    <span class="font-weight-bold" style="font-size: 1.1rem;">{{$film['name']}}</span>
                                </td>
                                <td class="text-secondary">{{$film['year']}}</td>
                                <td>
                                    <span class="badge-genre">{{$film['genre']}}</span>
                                </td>
                                <td>{{$film['country']}}</td>
                                <td class="text-right pr-4 font-weight-bold text-secondary">
                                    {{$film['duration']}} min
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="text-center mt-5">
        <a href="/" class="btn-apple">← Back to Home</a>
    </div>
@endsection