<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    private $genre;

    public function __construct(Genre $genre) {
        $this->genre = $genre;
    }

    public function index() {
        $all_genres = $this->genre->all();
        return view('genres.index')->with('all_genres', $all_genres);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:genres,name,'
        ]);

        $this->genre->name = ucwords($request->name);
        $this->genre->save();

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:genres,name,'. $id
        ]);

        $genre = $this->genre->findOrFail($id);
        $genre->name = ucwords($request->name);
        $genre->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $this->genre->destroy($id);
        return redirect()->back();
    }
}
