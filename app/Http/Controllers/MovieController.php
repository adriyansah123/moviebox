<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    //
    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    public function watch($id, $season = null, $episode = null)
    {
        if (is_null($season)) {
            $movie = Movie::findOrFail($id); // Mengambil data film berdasarkan ID
            return view('movies.watch', compact('movie'));
        } else {
            $episode = Episode::where('movie_id', $id)->where('season', $season)->where('episode', $episode)->first();
            return view('movies.watch', compact('episode'));
        }
    }

    public function episode($id)
    {
        $movie = Movie::findOrFail($id); // Mengambil data film berdasarkan ID
        return view('movies.episode', compact('movie'));
    }
}
