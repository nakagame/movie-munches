<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    private $genre;

    public function __construct(Genre $genre) {
        $this->genre = $genre;
    }
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                'name' => 'Horror',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Comedy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $this->genre->insert($genres);
    }
}
