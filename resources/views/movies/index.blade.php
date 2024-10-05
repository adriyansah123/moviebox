<!-- resources/views/movies/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Film & Serial TV</h1>
        <div class="row">
            @foreach($movies as $movie)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $movie->thumbnail) }}" class="card-img-top" alt="{{ $movie->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ $movie->year }} | {{ $movie->genre }}</p>
                            @if ($movie->type == "movie")
                            <a href="{{ route('movies.watch', $movie->id) }}" class="btn btn-primary">Tonton</a>
                            @else
                            <a href="{{ route('tvshow.episode', $movie->id) }}" class="btn btn-primary">Tonton</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
