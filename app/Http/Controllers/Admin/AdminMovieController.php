<?php 
namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Models\Episode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movie = Movie::all();
        return view('admin.index', compact('movie'));
    }
    
    public function create()
    {
        return view('admin.movies.create');
    }

    public function episodelist(Request $request)
    {
        $id = $request->id;
        $movie = Movie::find($id);
        $episode = Episode::where('movie_id', $id)->get();
        return view('admin.movies.list', compact('episode', 'movie'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'genre' => 'required',
            'release_date' => 'required|date',
            'type' => 'required|in:movie,tv_show',
            'episode_number' => 'nullable|integer|min:1',
            'thumbnail_url' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_file' => 'nullable|mimes:mp4,mov,avi,mkv|max:3145728',  // Maksimum 20MB
        ]);

        // Ambil informasi untuk membuat path
        $year = explode('–', $validated['release_date'])[0]; // Mengambil tahun pertama dari range
        $genre = Str::slug($validated['genre']);
        $titleSlug = Str::slug($validated['title']);

        // Buat direktori untuk menyimpan file
        $directoryPath = "movies/{$year}/{$genre}/{$titleSlug}";
        $videoPath = '-';

        // Upload video
        if ($request->video_file) {
            $videoPath = $request->file('video_file')->store($directoryPath, 'public');
        }

        // Upload atau ambil poster
        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store("posters/{$year}/{$genre}/{$titleSlug}", 'public');
        } else {
            if (!empty($validated['thumbnail_url'])) {
                $posterContents = file_get_contents($validated['thumbnail_url']);
                $posterName = "{$titleSlug}.jpg";
                Storage::disk('public')->put("posters/{$year}/{$genre}/{$titleSlug}/{$posterName}", $posterContents);
                $posterPath = "posters/{$year}/{$genre}/{$titleSlug}/{$posterName}";
            }
        }

        // Simpan ke database
        Movie::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'genre' => $validated['genre'],
            'release_date' => $validated['release_date'],
            'type' => $validated['type'],
            'episode_number' => $validated['episode_number'],  // Simpan nomor episode jika serial TV
            'thumbnail' => $posterPath,
            'video_url' => $videoPath,
        ]);

        return redirect()->route('movies.create')->with('success', 'Film atau Serial TV berhasil ditambahkan!');
    }


    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $title = urlencode($request->input('title'));
        $apiKey = config('services.omdb.key');
        $url = config('services.omdb.url') . "?t={$title}&plot=full&apikey={$apiKey}";

        $response = file_get_contents($url);
        $movieData = json_decode($response, true);

        if (isset($movieData['Error'])) {
            return redirect()->back()->withErrors(['error' => 'Film tidak ditemukan!']);
        }

        return view('admin.movies.create', ['movieData' => $movieData]);
    }

    // Menyimpan episode ke database
    public function storeEpisode(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'season' => 'required|integer',
            'episode' => 'required|integer',
            'file' => 'required|file|mimes:mp4,mkv,avi', // Validasi tipe file
        ]);

        $movie_id = $request->movie_id;
        $movie = Movie::find($movie_id);

        if ($movie) {
            $year = date('Y', strtotime($movie->release_date));
            $titleSlug = Str::slug($movie->title);
            // Menyimpan file video ke storage
            $videoPath = '-';
            $file = $request->file('file');
            
            // Upload video
            if ($file) {
                $directoryPath = "tv_show/{$year}/{$titleSlug}";
                $extension = $file->getClientOriginalExtension();
                $filename = "S{$request->season} - {$request->episode}.{$extension}";
                $path = $file->storeAs($directoryPath, $filename, 'public');
            }
    
            // Menyimpan episode ke database
            Episode::create([
                'movie_id' => $movie_id,
                'season' => $request->input('season'),
                'episode' => $request->input('episode'),
                'file' => $path,
            ]);
    
            return redirect()->route('movies.episodelist', ['id' => $movie_id])->with('success', 'Episode berhasil ditambahkan!');
        }
    }
}
