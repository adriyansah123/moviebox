<!-- resources/views/movies/watch.blade.php -->
@extends('layouts.app')

@section('content')
    
    <div class="container">
        @isset($movie)

            <h1>{{ $movie->title }}</h1>
            <p>{{ $movie->year }} | {{ $movie->genre }}</p>

            <!-- Tampilkan Video Player -->
            <div class="video-container">
                <video width="100%" height="auto" id="player" class="plyr" controls>
                    <source src="{{ asset('storage/' . $movie->video_url) }}" type="video/mp4" />
                    <!-- Captions -->
                    <track kind="captions" label="English" src="captions.vtt" srclang="en" default />
                </video>
            </div>

            <!-- Deskripsi atau Detail Film -->
            <div class="mt-4">
                <h5>Deskripsi</h5>
                <p>{{ $movie->description }}</p>

                @if ($movie->type === 'tv')
                    <p><strong>Episode:</strong> {{ $movie->episode_number }}</p>
                @endif
            </div>

            <a href="{{ route('movies.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Film</a>

        @endisset
        
        @isset($episode)

            <h1>{{ $episode->movie->title }}</h1>
            <h3>Season {{ $episode->season }} | Episode {{ $episode->episode }}</h3>
            <p>{{ $episode->movie->year }} | {{ $episode->movie->genre }}</p>

            <!-- Tampilkan Video Player -->
            <div class="video-container">
                <video  crossorigin playsinline controls width="100%" height="auto" id="player" class="plyr">
                    <source src="{{ asset('storage/' . $episode->file) }}" type="video/mp4">
                    Browser Anda tidak mendukung video tag.
                </video>
            </div>

            <!-- Deskripsi atau Detail Film -->
            <div class="mt-4">
                <h5>Deskripsi</h5>
                <p>{{ $episode->movie->description }}</p>
            </div>

            <h5 class="mt-3">Daftar Episode</h5>

            <div class="mt-3">
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Season</th>
                            <th>Episode</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($episode->movie->episode as $item)
                        <tr>
                            <td>{{ $item->season }}</td>
                            <td>{{ $item->episode }}</td>
                            <td><a href="{{ route('tvshow.watch', ['id' => $episode->movie->id, 'season' => $item->season, 'episode' => $item->episode]) }}">tonton</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('movies.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar Film</a>

        @endisset
    </div>

@endsection
