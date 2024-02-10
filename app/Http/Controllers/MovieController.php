<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Cast;
use App\Models\DiscussionRoom;
use Carbon\Carbon;

class MovieController extends Controller
{
    private $movie;
    private $genre;
    private $cast;

    public function __construct(Movie $movie, Genre $genre, Cast $cast) {
        $this->movie = $movie;
        $this->genre = $genre;
        $this->cast  = $cast;
    }

    public function index() {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        $latest_movies      = $this->movie->latest()->take(5)->get();
        $latest_top5_movies = $this->movie
                                   ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                   ->orderBy('rate','DESC')
                                   ->take(5)
                                   ->get();

        return view('movies.index')
                ->with('latest_movies', $latest_movies)
                ->with('latest_top5_movies', $latest_top5_movies);
    }

    public function create() {
        $all_genre = $this->genre->all();

        return view('movies.create')->with('all_genre', $all_genre);
    }

    public function show($id) {
        $movie = $this->movie->findOrFail($id);
        
        return view('movies.show')->with('movie', $movie);
    }

    public function showCasts(Request $request, $movie_id) {
        $movie = $this->movie->findOrFail($movie_id);
        
        $query = $request->input('search');
    
        // Check if a search query is present
        if ($query) {
            $searched_casts = $this->cast->where('name', 'like', '%' . $query . '%')
                                        ->orWhere('country', 'like', '%' . $query . '%')
                                        ->orderBy('name')
                                        ->get();

            return view('movies.show-cast')
                    ->with('movie', $movie)
                    ->with('all_casts', $searched_casts);
        }

        // If no search query, retrieve all casts
        $all_casts = $this->cast->orderBy('name')->get();
        
        return view('movies.show-cast')
            ->with('movie', $movie)    
            ->with('all_casts', $all_casts);
    }

    public function edit($id) {
        $movie     = $this->movie->findOrFail($id);
        $all_genre = $this->genre->all();
        $all_casts = $this->cast->orderBy('name')->get();

        return view('movies.edit')
                ->with('movie', $movie)
                ->with('all_genre', $all_genre)
                ->with('all_casts', $all_casts);
    }

    public function search(Request $request) {
        $movies = $this->movie
                        ->where('title', 'like', '%'. $request->search. '%')
                        ->orWhereHas('genres', function($query) use ($request) {
                            $query->where('name', 'like', '%'. $request->search. '%');
                        })
                        ->get();


        return view('movies.search')
                ->with('movies', $movies)
                ->with('search', $request->search);
    }

    public function store(Request $request) {
        $request->validate([
            'title'        => 'required|min:1|max:255|unique:movies,title,',
            'description'  => 'required|min:1|max:1000',
            'cover'        => 'required|max:1048|mimes:png,jpg,jpeg.gif',
            'rate'         => 'required|between:0,10.0',
            'genre'        => 'required',
            'year'         => 'required',
            'release_time' => 'required|min:0',
            'movie_url'    => 'max:1000'
        ]);

        $this->movie->title        = ucwords(strtolower($request->title));
        $this->movie->description  = $request->description;
        $this->movie->rate         = $request->rate;
        $this->movie->year         = $request->year;
        $this->movie->release_time = $request->release_time;
        $this->movie->cover        = 'data:image'. $request->cover->extension(). ';base64,'. base64_encode(file_get_contents($request->cover));
        $this->movie->user_id      = Auth::user()->id;
        $this->movie->movie_url    = $request->movie_url;
        $this->movie->save();

        $selected_genres = [];
        foreach($request->genre as $genre_id) {
            $selected_genres[] = ['genre_id' => $genre_id];
        }
        $this->movie->movieGenre()->createMany($selected_genres);

        return redirect()->route('index');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title'        => 'required|min:1|max:255|unique:movies,title,'. $id,
            'description'  => 'required|min:1|max:1000',
            'cover'        => 'max:1048|mimes:png,jpg,jpeg.gif',
            'rate'         => 'required|between:0,10.0',
            'genre'        => 'required',
            'year'         => 'required',
            'release_time' => 'required|min:0',
            'movie_url'    => 'max:1000'
        ]);

        $movie = $this->movie->findOrFail($id);

        $movie->title        = ucwords(strtolower($request->title));
        $movie->description  = $request->description;
        $movie->rate         = $request->rate;
        $movie->year         = $request->year;
        $movie->release_time = $request->release_time;
        $movie->user_id      = Auth::user()->id;
        $movie->movie_url    = $request->movie_url;

        if($request->cover) {
            $movie->cover = 'data:image'. $request->cover->extension(). ';base64,'. base64_encode(file_get_contents($request->cover));
        }
        
        $movie->save();

        $movie->movieGenre()->delete();

        $selected_genres = [];
        foreach($request->genre as $genre_id) {
            $selected_genres[] = ['genre_id' => $genre_id];
        }
        $movie->movieGenre()->createMany($selected_genres);

        return redirect()->route('movie.show', $request->id);
    }

    public function storeCasts(Request $request, $movie_id) {
        $movie = $this->movie->findOrFail($movie_id);
        
        $movie->movieCast()->delete();

        if($request->cast) {
            foreach($request->cast as $cast_id) {
                $selected_casts[] = ['cast_id' => $cast_id];
            }
            $movie->movieCast()->createMany($selected_casts);
        }
        
        return redirect()->route('movie.edit', $movie_id);
    }

    public function destroy($id) {
        DiscussionRoom::where('movie_id', $id)->update(['movie_id' => null]);
       
        $movie = $this->movie->findOrFail($id);

        $movie->movieCast()->delete();
        $movie->movieGenre()->delete();
        $movie->delete();

        return redirect()->route('index');
    }
}
