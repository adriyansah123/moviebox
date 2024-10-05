@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Film atau Serial TV Baru</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form untuk pencarian film dari API OMDb -->
    <form action="{{ route('movies.search') }}" method="GET">
        <div class="form-group">
            <label for="search_title">Cari Film atau Serial TV</label>
            <input type="text" name="title" class="form-control" id="search_title" placeholder="Masukkan judul" required>
        </div>
        <button type="submit" class="btn btn-info">Cari</button>
    </form>

    @if(isset($movieData))
    <hr>
    <h3>Film/Serial Ditemukan:</h3>
    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Pilihan apakah ini film atau serial TV -->
        <div class="form-group">
            <label for="type">Jenis Konten</label>
            <select name="type" class="form-control" id="type" required>
                <option value="movie">Film</option>
                <option value="tv_show">Serial TV</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $movieData['Title'] }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" id="description" required>{{ $movieData['Plot'] }}</textarea>
        </div>

        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" name="genre" class="form-control" id="genre" value="{{ $movieData['Genre'] }}" required>
        </div>

        <div class="form-group">
            <label for="release_date">Tanggal Rilis</label>
            <input type="text" name="release_date" class="form-control" id="release_date" value="{{ $movieData['Year'] }}" required>
        </div>

        <div class="form-group" id="episode-field" style="display: none;">
            <label for="episode_number">Nomor Episode</label>
            <input type="number" name="episode_number" class="form-control" id="episode_number" min="1" placeholder="Masukkan nomor episode">
        </div>

        <div class="form-group">
            <label for="thumbnail">URL Poster</label>
            <input type="text" name="thumbnail_url" class="form-control" id="thumbnail" value="{{ $movieData['Poster'] }}" required>
        </div>

        <div class="form-group">
            <label for="poster">Upload Poster (opsional)</label>
            <input type="file" name="poster" class="form-control" id="poster">
        </div>

        <div class="form-group">
            <label for="video_file">Upload Film/Serial TV</label>
            <input type="file" name="video_file" class="form-control" id="video_file">
        </div>

        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
    @endif
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    var episodeField = document.getElementById('episode-field');
    if (this.value === 'tv_show') {
        episodeField.style.display = 'block';  // Tampilkan input episode jika Serial TV
    } else {
        episodeField.style.display = 'none';  // Sembunyikan jika Film
    }
});
</script>
@endsection
