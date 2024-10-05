@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Film</h1>

    <!-- Form untuk pencarian film dari API OMDb -->
    <div class="row">
        <div class="col">
            <a href="{{ route('movies.create') }}" class="btn btn-primary">Tambah </a>
        </div>
    </div>
    <table class="table mt-3" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Film</th>
                <th>Jenis</th>
                <th>Episode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movie as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->type }}</td>
                <td>
                    @if ($item->type == "tv_show")
                        <a href="{{ route('movies.episodelist', ['id' => $item->id]) }}">klik</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
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
