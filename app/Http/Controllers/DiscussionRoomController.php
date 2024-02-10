<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiscussionRoom;
use App\Models\Movie;

class DiscussionRoomController extends Controller
{
    private $discussion_room;
    private $movie;

    public function __construct(DiscussionRoom $discussion_room, Movie $movie) {
        $this->discussion_room = $discussion_room;
        $this->movie           = $movie;
    }

    public function index() {
        $all_movies = $this->movie->orderBy('title')->get();

        if (Auth::user()->role_id === 1) {
            $all_discussions = $this->discussion_room->orderBy('updated_at', 'DESC')->withTrashed()->paginate(10);
        } else {
            $all_discussions = $this->discussion_room->orderBy('updated_at', 'DESC')->paginate(10);
        }

        return view('discussion-room.index')
            ->with('all_movies', $all_movies)
            ->with('all_discussions', $all_discussions);
    }

    public function show($id) {
        $discussion = $this->discussion_room->findOrFail($id);
        return view('discussion-room.main')->with('discussion', $discussion);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|min:1|max:100',
            'movie_id' => 'nullable|unique:discussion_rooms,movie_id,'
        ]);

        $this->discussion_room->title    = $request->title;
        $this->discussion_room->movie_id = $request->movie_id;
        $this->discussion_room->user_id  = Auth::user()->id;
        $this->discussion_room->save();

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|min:1|max:100'
        ]);

        $discussion = $this->discussion_room->findOrFail($id);
        $discussion->title = $request->title;
        $discussion->save();

        return redirect()->back();
    }

    public function hide($id) {
        $this->discussion_room->destroy($id);
        return redirect()->back();
    }

    public function visble($id) {
        $this->discussion_room->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}

