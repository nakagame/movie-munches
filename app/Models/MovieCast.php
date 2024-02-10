<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCast extends Model
{
    use HasFactory;

    protected $table    = 'movie_cast';
    protected $fillable = ['movie_id', 'cast_id'];
    public $timestamps  = false;

    public function cast() {
        return $this->belongsTo(Cast::class);
    }
}
