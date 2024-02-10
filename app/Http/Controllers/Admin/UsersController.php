<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index() {
        $all_users = $this->user
                          ->withTrashed()
                          ->orderBy('role_id')
                          ->orderBy('name')
                          ->paginate(8);

        return view('users.index')->with('all_users', $all_users);
    }

    public function deactive($id) {
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id) { 
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function addAdmin($id) {
        $user = $this->user->findOrFail($id);
        $user->role_id = 1;
        $user->save();

        return redirect()->back();
    }

    public function removeAdmin($id) {
        $user = $this->user->findOrFail($id);
        $user->role_id = 2;
        $user->save();
        
        return redirect()->back();
    }
}
