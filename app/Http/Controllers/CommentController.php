<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    public function store(Request $request, $discussion_id) {
        $request->validate([
            'comment' => 'required|min:1|max:1000'
        ]);

        $this->comment->body               = $request->comment;
        $this->comment->user_id            = Auth::user()->id;
        $this->comment->discussion_room_id = $discussion_id;
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $comment = $this->comment->findOrFail($id);
        $comment->forceDelete();

        return redirect()->back();
    }

    public function banned($id) {
        $this->comment->destroy($id);

        return redirect()->back();
    }
}
