<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function movieGenre() {
        return $this->hasMany(MovieGenre::class);
    }

    public function movieCast() {
        return $this->hasMany(MovieCast::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
    }
}
