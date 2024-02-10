<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cast;

class CastController extends Controller
{
    private $cast;

    public function __construct(Cast $cast) {
        $this->cast = $cast;
    }

    public function index(Request $request) {
        $query = $request->input('search');
    
        // Check if a search query is present
        if ($query) {
            $searched_casts = $this->cast->where('name', 'like', '%' . $query . '%')
                                        ->orWhere('country', 'like', '%' . $query . '%')
                                        ->orderBy('name')
                                        ->paginate(8);

            return view('casts.index')->with('all_casts', $searched_casts);
        }

        // If no search query, retrieve all casts
        $all_casts = $this->cast->orderBy('name')->paginate(8);

        return view('casts.index')->with('all_casts', $all_casts);
    }

    public function store(Request $request) {
        $request->validate([
            'name'    => 'required|min:1|max:255|unique:casts,name,',
            'avatar'  => 'required|mimes:jpeg,jpg,png,gif|max:1048',
            'country' => 'required|min:1|max:50',
        ]);

        $this->cast->name    = ucwords(strtolower($request->name));
        $this->cast->avatar  = 'data:image'. $request->avatar->extension(). ';base64,'. base64_encode(file_get_contents($request->avatar));
        $this->cast->country = $request->country;
        $this->cast->save();

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name'    => 'required|min:1|max:255|unique:casts,name,'. $id,
            'avatar'  => 'mimes:jpeg,jpg,png,gif|max:1048',
            'country' => 'required|min:1|max:50',
        ]);

        $cast = $this->cast->findOrFail($id);
        
        $cast->name    = $request->name;
        $cast->country = $request->country;
        if($request->avatar) {
            $cast->avatar  = 'data:image'. $request->avatar->extension(). ';base64,'. base64_encode(file_get_contents($request->avatar));
        }
        $cast->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $this->cast->destroy($id);

        return redirect()->back();
    }
}
