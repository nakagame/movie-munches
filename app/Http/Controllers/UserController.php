<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function show($id) {
        $user        = $this->user->findOrFail($id);
        $discussions = $user->discussion_rooms()->paginate(10);

        return view('profile.show')
            ->with('user', $user)
            ->with('discussions', $discussions);
    }

    public function update(Request $request) {
        $request->validate([
            'name'   => 'required|min:1|max:255',
            'email'  => 'required|email|max:255|unique:users,email,'. Auth::user()->id,
            'avatar' => 'max:1048|mimes:png,jpg,png,gif',
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->avatar) {
            $user->avatar = 'data:image'. $request->avatar->extension(). ';base64,'. base64_encode(file_get_contents($request->avatar));
        }
        $user->save();

        return redirect()->back();
    }
}
