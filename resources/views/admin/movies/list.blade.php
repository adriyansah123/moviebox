@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>{{ $movie->title }}</h1>
    
        <!-- Form untuk pencarian film dari API OMDb -->
        <div class="row">
            <div class="col">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Launch demo modal
                </button>
                  
                <!-- Modal -->
                <form action="{{ route('episode.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $movie->title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <div class="form-group">
                          <label for="">Season</label>
                          <input type="number" name="season" id="" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="">Episode</label>
                          <input type="number" name="episode" id="" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="">File</label>
                          <input type="file" name="file" id="" class="form-control">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                </form>
            </div>
        </div>

        <table class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>Season</th>
                    <th>Episode</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($episode as $item)
                    <tr>
                        <td>{{ $item->season }}</td>
                        <td>{{ $item->episode }}</td>
                        <td>{{ $item->file }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection