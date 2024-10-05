<!-- resources/views/movies/watch.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $movie->title }}</h1>
        <p>{{ $movie->year }} | {{ $movie->genre }}</p>

        <!-- Deskripsi atau Detail Film -->
        <div class="mt-4">
            <h5>Deskripsi</h5>
            <p>{{ $movie->description }}</p>

            @if ($movie->type === 'tv')
                <p><strong>Episode:</strong> {{ $movie->episode_number }}</p>
            @endif
        </div>

        <div class="mt-4">
            <h5>Daftar Episode</h5>

            <div class="mt-5">
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Season</th>
                            <th>Episode</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movie->episode as $item)
                        <tr>
                            <td>{{ $item->season }}</td>
                            <td>{{ $item->episode }}</td>
                            <td><a href="{{ route('tvshow.watch', ['id' => $movie->id, 'season' => $item->season, 'episode' => $item->episode]) }}">tonton</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('movies.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Film</a>
    </div>
@endsection
